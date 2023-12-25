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
