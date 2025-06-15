# Freemarket

Laravelを使ったフリマアプリケーションです。

## 機能概要

- ユーザー登録・ログイン機能（Laravel Fortify使用）
- 商品の出品・購入機能
- プロフィールの編集機能
- 商品の検索機能
- 商品のお気に入り・コメント機能

## 使用技術

- PHP 8.4.2
- laravel 8.83.29
- nginx 1.21.1
- MySQL（MariaDB 10.3 使用）
- Docker / Docker Compose

## セットアップ手順

Dockerビルド

1. git clone git@github.com:reina017719/Freemarket.git
2. docker compose up -d --build

*MySQLは、OSによって起動しない場合があるのでそれぞれのPCに合わせて docker-compose.yml ファイルを編集してください。

Laravel環境構築
1. docker-compose exec php bash
2. composer install
3. .env.exampleファイルから.envを作成し、環境変数を変更
4. php artisan key:generate
5. php artisan migrate
6. php artisan db:seed

## アップロード画像について

- ユーザーがアップロードした画像は 'storage/app/  public' に保存されます。
- ローカル環境では以下のコマンドでシンボリックリンクを作成してください：

php artisan storage:link

## URL

- 開発環境：http://localhost/
- phpMyAdmin：http://localhost:8080/
