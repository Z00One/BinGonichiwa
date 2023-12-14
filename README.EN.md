[日本語](https://github.com/Z00One/BinGonichiwa/tree/main#readme)

<p align="center"><img src="public/assets/favicon.svg" width="150" alt="BinGonichiwa Logo"></p>

## About BinGonichiwa

BinGonichiwa is a real-time 1-on-1 Bingo game built with Laravel. This game utilizes Laravel's Broadcasting feature and a random matching function, allowing two users to play against each other in real-time.

## Main Features

-   Real-time 1-on-1 Bingo matches
-   Random user matching

## Technology Stack

-   Laravel
-   Laravel Echo
-   Tailwind CSS
-   MySQL
-   Redis
-   Pusher
-   Jetstream

## Installation

1. Clone the repository to your local machine: `https://github.com/Z00One/BinGonichiwa.git`
2. Navigate into the directory: `cd BinGonichiwa`
3. Install dependencies:
    - `composer install`
    - `npm install`
4. Set up Pusher: Refer to this [site](https://pusher.com/)
5. Copy `.env` file from `.env.example`: `cp .env.example .env`
6. Set the required values for your system:
    - `GAME_*`
    - `PUSHER_*={Value of pusher settings}`
    - `REDIS_*,`
7. If you do not have `mysql` or `redis`, download them or use docker images to build the necessary environment.
8. Migrate the database: `php artisan migrate`
9. Apply tailwind: `npm run dev` or `npm run build`
10. Start the server: `php artisan serve`

## Usage

1. Open your web browser and navigate to `http://localhost:8000`.
2. Click the Login button to log in with an existing account. Register If you have not account
3. On the main page, click the 'Matching Start' button. You will be randomly matched with another user to play a 1-on-1 Bingo game.

## ETC

-   If you are in a window environment, you can type the command `php artisan serve:local` in the console to serve on a private IP.
-   Bingonichiwa supports English and Japanese.
