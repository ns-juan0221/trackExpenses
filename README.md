# マネーログ
#### 品目やお店で検索ができるから、どこが安かったかなどの比較ができる家計簿アプリです。
#### URL:https://money-log.net   
#### 上記URLはゲストページへ飛びます
![ログイン画面](https://github.com/user-attachments/assets/9b781b30-a5ec-42ed-a34f-aeaef981909b)

## 画面遷移図について
<img width="700" alt="Image" src="https://github.com/user-attachments/assets/c2e03f8e-7a16-45ea-b2d5-792e69b1a858" />

## ER図について
<img width="700" alt="Image" src="https://github.com/user-attachments/assets/c6da832c-c09f-4967-a2be-a826db3df8ea" />

## 開発環境について
### 使用技術
#### 【フロントエンド】
- #### HTML
- #### CSS
- #### Bootstrap 5.3.0
- #### JavaScript
- #### Node.js 18
#### 【バックエンド】
- #### php:8.2-fpm
- #### Laravel 9.52.18
#### 【開発環境】
- #### Docker 27.3.1 / Docker Compose v2.29.7<br/>(nginx, php-fpm,mysql 8.0.40)
### 使用ツール
- #### バージョン管理： Git / GitHub
- #### IDE： Visual Studio Code
- #### DBクライアント：DBeaver
- #### ER図, 画面遷移図：draw.io

## 機能一覧
### 認証機能
- #### ユーザー登録機能：名前・メールアドレス・ユーザーネーム・パスワード登録
- #### ログイン機能：メールアドレス・パスワード認証
- #### ログアウト機能：ログイン前画面に遷移
### メイン機能
- #### 収支登録機能：収入・支出それぞれに合った項目の登録
- #### 収支編集機能：収入・支出それぞれの項目の変更
- #### 収支削除機能：収入・支出の項目の削除
- #### 検索機能：品目(like検索)、お店(like検索)、メモ(like検索)、日付、金額、カテゴリ、いずれかの項目で検索


