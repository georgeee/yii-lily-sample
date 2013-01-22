Lily module sample
---------------------

It's a sample project for [Lily](https://github.com/georgeee/yii-lily) module.
Demo is [here](http://georgeee.ru/lily-sample/).

Requirements
---------------------

Lily requires several extensions to be installed:

 * [EOAuth (required by EAuth)](http://www.yiiframework.com/extension/eoauth, "Yii EOAuth extension") 
 * [Loid extension (required by EAuth)](http://www.yiiframework.com/extension/loid "Yii loid extension")
 * [Yii mail (in order to send notification and activation mails for email authentication type)](http://www.yiiframework.com/extension/mail/ "Yii mail extension")
 * [EAuth](https://github.com/Nodge/yii-eauth)
 * [Lily](https://github.com/georgeee/yii-lily)

Installation instructions
---------------------------------

1. Download lily sample project (git clone https://github.com/georgeee/yii-lily-sample.git)
2. Create assets and protected/runtime directories `mkdir assets protected/runtime`
3. Download extensions listed above and put them into `protected/extensions`.
4. Put `framework` directory (or symbolic link to it) into `protected`
5. Deploy your database (here code is shown for mysql), put corresponding code into db section of config:

```php
<?php
 	'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=lily-sample',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '****',
			'charset' => 'utf8',
		),
```
6. Deploy the DB tables:
    1. `./yiic migrate --migrationPath=ext.lily.migrations --migrationTable=lily_migration up`
    2. `./yiic migrate up`
    3. Create authManager tables into your DB. You can do it by importing protected/data/authManager.sql
7. Initialize RBAC structure:
    1. Run `./yiic lily_rbac`, it will install Lily's RBAC structure
    2. Run `./yiic lily_rbac assign --user {uid} --role {role, default userAdmin}` to assign role to a user
    3. Run `./yiic rbac_installer`, it will install app's RBAC structure
    4. Run `./yiic rbac_installer assign --user {uid} --role {role, default articleAdmin}` to assign role to a user

8. Edit config/main.php, fill in your service data, configure yii-mail extension

How to use
------------

Just try it out:) You can register several accounts, then merge users, the you can view merge history or find yourself in user list, and so on.