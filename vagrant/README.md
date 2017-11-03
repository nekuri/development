# 開発用Vagrant

使用しているboxは以下  
https://atlas.hashicorp.com/oppara/boxes/CentOS-6.7-dev


## 事前準備

### Vagrantfileの変更方法

1) ホスト名案件名に応じて変更する  
**アンダーバーは使えない**

```
HOSTNAME = "vagrant-sample"
```

2) FQDNを案件名に応じて変更する  
**アンダーバーは使えない**

```
FQDN = "vagrant-sample.local"
```

FQDNは、dev.confのServerNameに設定されます。  
また、hostsupdaterプラグインがインストールされている場合は、ホスト側の/etc/hostsにも設定されます。

3) IPアドレスを適当なものに変更する

```
IP_ADDRESS = "192.168.10.10"
```

dotenvを使用すれば外部から設定変更が可能です。  
[dotenvを利用して環境ごとでVagrantfileの設定値を変更してみる](http://blog.glidenote.com/blog/2014/02/26/vagrant-dotenv/)

```
$ vagrant plugin install dotenv
$ cd project/vagrant
$ echo "VAGRANT_IP_ADDRESS=192.168.100.100" > .env
$ vagrant up
```

4) 使用するデータベースを1、使用しないデータベースを0にする

```
USE_MYSQL = 1
USE_POSTGRES = 0
```

5) データベースのユーザ名、パスワード、データベース名、テスト用データベース名を書き変える

```
DB_USER = "vagrant"
DB_NAME = "vagrant_sample_develop"
DB_PASS = ""
TEST_DB_NAME = "vagrant_sample_test"
```

6) インストールしたいPHPのバージョンを指定する（必要が無ければ変えなくてよい）

```
PHP_VERSION = "56"
```

7) インストールしたいCakePHPのバージョンを指定する（必要が無ければ変えなくてよい）

```
CAKEPHP = 2
```

### CakePHP2系の場合

`etc/cakephp2_composer.json`の修正  

1) インストールしたいCakePHPのバージョンに書き変える（必要が無ければ変えなくてよい）

```
"cakephp/cakephp": "2.7.*"
```

2) インストールしたいCakePHPのプラグインを追記する（必要が無ければ変えなくてよい） 

```
"phpunit/phpunit": "3.7.*",
"cakedc/migrations": "2.3.*",
"cakephp/debug_kit": "2.2.*"
```

### CakePHP3系の場合

`scripts/cakephp3.sh`の修正  

1) インストールしたいCakePHPのバージョンに書き変える（必要が無ければ変えなくてよい）

```
composer self-update && composer create-project --prefer-dist "cakephp/app=3.2.*" ${ROOT} << END_OF_INPUT
y
END_OF_INPUT
```

2) インストールしたいCakePHPのプラグインを追記する（必要が無ければ変えなくてよい） 

```
composer require cakephp/acl
composer require jcpires/cakephp3-aclmanager
```


###  etc/dev.confの変更方法

1) ドキュメントルートのパスを案件の構造に合うように書き変える（必要が無ければ変えなくてよい）


```
DocumentRoot "/srv/httpd/app/webroot"
```

2) ドキュメントルートのパスを案件の構造に合うように書き変える（必要が無ければ変えなくてよい）

```
<Directory "/srv/httpd/app/webroot">
```



## 事後設定

### 各ファイル、ディレクトリのパーミッションの確認

#### CakePHP2の場合

cakeコマンドは`0755`  
cakeコマンド以外のファイルは`0644`

```
$ find /path/to/app -type f | grep -v -e 'cake$' | xargs chmod 0644
```

tmp内のディレクトリは`0777`  
それ以外のディレクトリは`0755`

```
$ find /path/to/app -type d | xargs chmod 0755
$ find /path/to/app/tmp -type d | xargs chmod 0777
```

#### CakePHP3の場合

binディレクトリ内のファイルは`0755`  
binディレクトリ内以外のファイルは`0644`

tmp, logs内のディレクトリは`0777`  
それ以外のディレクトリは`0755`

```
$ find /path/to/logs -type d | xargs chmod 0777
$ find /path/to/tmp -type d | xargs chmod 0777
```


### app/Controller/AppController.phpでコンポーネントを読み込む（必要な場合のみ）

```
    /**
     * components
     *
     * @var array
     */
    public $components = array(
        'DebugKit.Toolbar'
    );
```


### 設定したIPアドレスにアクセスすると、グリーンの画面が表示されるはず！



## 補足 

- PostgreSQLとApacheは元からインストールされているboxファイルを使用しているため、  
Vagrant内にはインストールのコマンドが書かれていません

- CakePHPもをコンポーザでインストールするようにしていますが、その場合は、CakePHPをzipで落としてきたときとディレクトリ構成が若干変わります  
（CakePHP本体がlibディレクトリ内に入ってないとか）

- CakePHPもをコンポーザでインストールする場合は、　app/webroot/index.phpとwebroot/test.php内に書かれている
CakePHP本体のパスを書き換える必要がありますがVagrant内で書き変えています

- app/Config/database.php.defaultをapp/Config/database.phpにリネームしたり、tmpディレクトリ内にemptyファイルを生成したりと、Vagrant内で出来そうなことは
極力Vagrantに任せる作りになっています
