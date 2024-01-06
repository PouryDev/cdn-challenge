<?php

namespace App\Jobs;

use App\Mail\GiftCodeResultMail;
use App\Models\GiftCode;
use App\Models\Transaction;
use App\Models\User;
use App\Services\GiftCodeService;
use App\Services\TransactionService;
use App\Services\WalletService;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class UseGiftCodeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private GiftCode $code;
    private User $user;

    /**
     * Create a new job instance.
     */
    public function __construct(GiftCode $code, User $user)
    {
        $this->code = $code;
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (!GiftCodeService::isValid($this->code, $this->user->id)) {
            $this->onFail('User could not use the gift code', false);
        }

        $wallet = $this->user->wallet()->first();
        $amount = $this->code->amount;

        DB::beginTransaction();
        $transaction = TransactionService::create(
            $amount,
            $this->user->id,
            Transaction::TYPES['gift'],
            $wallet->id,
            $this->code->id,
        );
        if (is_null($transaction)) {
            $this->onFail('Something went wrong on storing new transaction');
        }

        $flag = WalletService::increaseBalance($wallet, $amount);
        if (!$flag) {
            $this->onFail('Something went wrong on increasing wallet balance');
        }

        $flag = TransactionService::changeStatus($transaction, Transaction::STATUSES['success']);
        if (!$flag) {
            $this->onFail('Something went wrong on changing transaction status');
        }

        $flag = GiftCodeService::use($this->code, $this->user);
        if (!$flag) {
            $this->onFail('Something went wrong on using gift code');
        }

        DB::commit();

        Mail::to($this->user->email)->send(new GiftCodeResultMail(true));
    }

    /**
     * Do needed operations if anything failed
     *
     * @param string $message
     * @param bool $dbRollback
     * @return void
     * @throws Exception
     */
    private function onFail(string $message, bool $dbRollback = true): void
    {
        if ($dbRollback) {
            DB::rollBack();
        }

        Mail::to($this->user->email)->send(new GiftCodeResultMail(false));
        throw new Exception($message);
    }
}
