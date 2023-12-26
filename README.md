# CDN Challenge

## Overview

Welcome to the CDN Challenge repository! This project features a gift application with two distinct services: "gift code" and "wallet." The challenge revolves around an exciting World Cup final match between Iran and Brazil. At halftime, we announce a special gift code for users, allowing them to claim a complimentary 10M IRR (Iranian Rial) in their wallet. Hurry up, as this offer is limited to the first 100 users!

## Installation

### 1. Build Docker Image

To get started, build the "cdn-challenge-app" Docker image. Run the following command in the root of the project:

```bash
docker build . -t cdn-challenge-app:0.0.1
```
### 2. Run with Docker Compose

Launch the project using Docker Compose with the following command:


```bash
docker-compose up -d
```
### 3. Database Setup

Run all Laravel migrations to set up the necessary database tables. Execute the following command:

```bash
php artisan migrate
```

## Usage
Once the installation steps are completed, users can participate in the gift challenge during halftime of the Iran vs. Brazil World Cup final match. They can redeem the announced gift code in the application to receive a complimentary 10M IRR in their wallet.

Please note that this offer is limited to the first 100 users, so participants should act promptly to secure their gift.

## How it works?
1. User gives the code
2. Create user if it wasn't stored in DB
3. Check if the code is correct and valid
4. Increment the redis key of the code and return max usage reached message to user if it was more than the usage limit of the gift code. Also decrement the redis key of the gift code.
5. Start a DB transaction and rollback + decrement the redis key if any query have failed
6. Create a transaction with pending status and gift type with the amount of the gift code
7. Increase the wallet amount with the code's amount
8. Create a user gift usage record
9. Increment the used count of the gift code

## Services
### Gift Code Service
Create -> create a gift code with the given amount, code, max_usage(which can be null) and expiration date if it was needed(nullable also) and return error if the code existed before <br>
Update -> update gift code’s code, amount, max_usage and expiration date <br>
Expire -> Set the expiration date for a day before <br>
Check -> Gets the user and the gift code and checks if the gift code has not reached its limit(from db) and also the user has not been used it before <br>
Use -> Gets the user, wallet and the gift code and stores the data in gift_code_usages table <br>

### Transaction Service
Create -> Create a transaction with the given user id, wallet_id, amount, status, type and gift_code if it was given. Also auto change the type to gift if there was a gift code in param <br>
changeStatus -> Change the status of a transaction with the given status <br>

### Wallet Service
Create -> Creates wallet with the given user id <br>
incrementBalance -> Increments or decrements the balance of the wallet <br>
