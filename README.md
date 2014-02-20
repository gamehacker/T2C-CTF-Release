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
またphpmyadminでの管理をお勧めします。

###3.Node.jsについて
チャットやスコア更新はnodeを使っているので、サーバサイドで`node server.js`などで動かして下さい。  
またforeverなどでndoeをデーモン化するもの良いでしょう。

###3.admin ディレクトリについて
admin/には管理者のみのアクセスを制限するようにしてください。  
admin/register.phpでプレ登録、admin/admin_register.phpは管理者1人でアカウント作成を完結出来ます。  
admin/index.phpにはdefine.phpのADMIN_IDのみアクセスできます。  
\あたりだよ！/というのはadmin/index.phpをブラウザで表示すれば鳴ります。

###4.脆弱性など
人間ですので、もし脆弱性等あればご連絡ください。  
それかPull Request投げてください。

###その他
音声はCeVIO Creative Studio FREEを使いました。  
http://cevio.jp/
