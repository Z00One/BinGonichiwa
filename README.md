(English)["./README.EN.md"]

<p align="center"><img src="public/assets/favicon.svg" width="150" alt="BinGonichiwa Logo"></p>

## BinGonichiwa について

BinGonichiwa は Laravel を利用したリアルタイム 1 対 1 ビンゴゲームです。このゲームは Laravel の Broadcasting 機能とランダムマッチング機能を利用して、2 人のユーザーがリアルタイムで対戦できるようになっています。

## 主な機能

-   リアルタイム 1 対 1 ビンゴマッチ
-   ランダムユーザーマッチング

## 技術スタック

-   Laravel
-   Laravel Echo
-   Tailwind CSS
-   MySQL
-   Redis
-   Pusher
-   Jetstream

## インストール

1. リポジトリをローカルマシンにクローンします: `https://github.com/Z00One/BinGonichiwa.git`
2. ディレクトリに移動します: `cd BinGonichiwa`
3. Composer と Npm を使用して依存関係をインストールします: `composer install`, `npm install`
4. Pusher を設定します: この[サイト](https://pusher.com/)ご参考ください
5. `.env.example` ファイルをコピーして。`.env` ファイルを作ります: `cp .env.example .env`
6. システムに必要な値を設定します:
    - `GAME_*`
    - `PUSHER_*={pusherの設定の値}`
    - `REDIS_*,`
7. `mysql` や `redis` がない場合はダウンロードや docker のイメージを利用して必要な環境を構築します
8. データベースをマイグレートします: `php artisan migrate`
9. tailwind を適用します:
    - `npm run dev`
    - `npm run build`
10. サーバーを起動します: `php artisan serve`

## 使用方法

1. ウェブブラウザを開いて `http://localhost:8000` に移動します。
2. ログインボタンをクリックして既存のアカウントでログインします。アカウントがない場合は登録します
3. メインページで 'マッチング開始' ボタンをクリックします。あなたはランダムにマッチングされたユーザーと 1 対 1 のビンゴゲームをプレイします。

## ETC

-   コンソールに `php artisan serve:local` コマンドを入力して、プライベート IP で serve することができます。
-   Bingonichiwa は日本語と英語に対応しています。
