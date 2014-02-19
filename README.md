T2C-CTF-Release
===============

T2C CTFで使ったSystemのソースです。  
必要システム  
* ApacheかNginxなどのWeb Server  
* MySQL  
* Node.jsなどのパッケージ管理のnpm
* phpMyAdminなどのDB管理

###1.導入
初めに`git clone https://github.com/hasunuma/T2C-CTF-Release.git`などしてソースをローカルレポジトリに保存。  
define.phpと、server.jsにMySQLのDBのユーザ、パスワードを設定。



###2.MySQLの設定について
必要なテーブルはT2CCTF.sqlにあるので、これをMySQLに流し込む。  
またphpmyadminの管理をお勧めします。

###3.Node.jsについて
チャットやスコア更新はnodeを使っているので、`node server.js`などをして動かして下さい。  
またforeverなどでndoeをデーモン化するものも活用しましょう。

###3.admin ディレクトリーについて
admin/には管理者のみのアクセスを制限するようにしてください。  
admin/register.phpでプレ登録、register.phpは管理者1人でアカウント作成を完結出来る。

###4.脆弱性など
人間ですので、もし脆弱性等あればご連絡ください。  
それかPull Request投げてください。
