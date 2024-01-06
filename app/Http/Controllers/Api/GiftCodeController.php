<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GiftCodeRequest;
use App\Jobs\UseGiftCodeJob;
use App\Models\GiftCode;
use App\Models\User;
use App\Services\UseGiftCode;
use Illuminate\Http\JsonResponse;

class GiftCodeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(GiftCodeRequest $request): JsonResponse
    {
        $data = $request->validated();

        $params = [
            'phone_number' => $data['phone_number'],
            'email' => $data['email'],
        ];
        $user = User::updateOrCreate($params, $params);
        if (empty($user)) {
            return response()->json(
                ['message' => 'something went wrong please try again'],
                500
            );
        }

        $code = GiftCode::where('code', $data['code'])->first();

        if (config('app.solution') === 'rabbit') {
            dispatch(new UseGiftCodeJob($code, $user));
            return response()->json(['message' => 'You can see the result in your mail']);
        } else {
            return UseGiftCode::handle($code, $user);
        }

    }
}
