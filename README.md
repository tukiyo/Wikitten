wikittenとは
====
* [公式HP](http://wikitten.vizuina.com/)
* markdownで記述したファイルをwebブラウザでいい感じに表示してくれる君。
* 各種言語対応 (sh,php,css,python,ruby,sql,xml)
* Webでの編集機能が無かったが[EightMinusEight](https://github.com/EightMinusEight)さんができるようにしました。今回、これをフォークして手を加えました。

修正前
----
![](https://github-camo.global.ssl.fastly.net/49c07895d2ee3d967776e244f5af092a2fed17ed/687474703a2f2f77696b697474656e2e76697a75696e612e636f6d2f73637265656e73686f742e706e67)

修正後
----
![修正後.PNG](https://qiita-image-store.s3.amazonaws.com/0/25728/52f2a1db-78f0-155e-2187-2f2b8f06ab59.png)

修正内容
----
1. Alt-T でソースをトグル表示、Alt-S で保存、Alt-C でContentタブに切り替え。
1. 猫消した。
1. 最初から編集許可。
1. ツリーで画像ファイルの場合は画像アイコンを表示するようにした。また拡張子を非表示にした。
1. ツリーで画像リンクをクリックすると、同一ウィンドウで表示するように修正した。
1. h1〜h5,aタグをqiitaのものにした。

インストール
====

```bash:
$ cd /var/www
$ sudo git clone https://github.com/tukiyo/Wikitten.git
```

```bash:
$ sudo ln -s /etc/apache2/mods-available/rewrite.load \
  /etc/apache2/mods-enabled/
$ sudo /etc/init.d/apache2 restart
```

http://localhost/Wikitten でアクセスできます。


sambaでlibraryを共有
====

/var/www/Wikitten/library/ が文書データなので、自由なテキストエディタで編集できるようにsambaで共有する。
その際、ファイル権限の問題があるため、以下のスクリプトを用意してcronで定期的に修正かける。

```bash:chown_wiki_library.sh
#!/bin/sh
PATH_WIKI_LIBRARY=/var/www/Wikitten/library
chown -R www-data:www-data $PATH_WIKI_LIBRARY
chmod -R 777 $PATH_WIKI_LIBRARY
```

```bash:cronに追加
*/5 * * * * /root/cron/chown_wiki_library.sh
```

download
====
* [download](https://github.com/tukiyo/Wikitten.git)
