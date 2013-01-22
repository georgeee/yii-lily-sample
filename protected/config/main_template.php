<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Lily Module Sample',
    'theme' => 'classic',
    // preloading 'log' component
    'preload' => array('log'),
    'aliases' => array(
        'lily' => 'ext.lily',
    ),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'ext.eoauth.*',
        'ext.eoauth.lib.*',
        'ext.lightopenid.*',
        'ext.eauth.*',
        'ext.eauth.services.*',
        'ext.yii-mail.YiiMailMessage',
        'lily.LilyModule',
    ),
    'modules' => array(
        'lily' => array(
            'class' => 'lily.LilyModule',
            'relations' => array(
                //event example
                'profile' => array(
                    'relation' => array(CActiveRecord::HAS_ONE, 'Profile', 'uid'),
                    'onUserMerge' => 'event',
                    'onRegister' => array('profile/create'),
                ),
                //auto example
                'article' => array(
                    'relation' => array(CActiveRecord::HAS_MANY, 'Article', 'uid'),
                    'onUserMerge' => 'auto', //just updates indexes from old uid to new one
                ),
                //callback example
                'mhPieces' => array(
                    'relation' => array(CActiveRecord::HAS_MANY, 'MergeHistoryPiece', 'owner_id'),
                    'onUserMerge' => 'callback',
                    'callback' => array('MergeHistoryPiece', 'userMergeCallback'),
                ),
            ),
            'allowedRoutes' => array('gii'),
            'userNameFunction' => array('Profile', 'getName'), //callback, that should return name of the user
        ),
    ),
    // application components
    'components' => array(
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => true,
            'rules' => array(
                array(
                    'class' => 'application.components.UsernameRule',
                    'connectionID' => 'db',
                ),
                'user' => 'lily/user/view',
                'user/history' => 'site/mergeHistory',
                '<_a:(login|logout)>' => 'lily/user/<_a>',
                '<_a:(user|account)>s' => 'lily/<_a>/list',
                '<_a:(user|account)>/<action:\w+>' => 'lily/<_a>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ),
        ),
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
            'assignmentTable' => '{{rbac_assignment}}',
            'itemChildTable' => '{{rbac_item_child}}',
            'itemTable' => '{{rbac_item}}',
            'defaultRoles' => array('userAuthenticated', 'userGuest'),
        ),
        'loid' => array(
            'class' => 'ext.lightopenid.loid',
        ),
        'eauth' => array(
            'class' => 'ext.eauth.EAuth',
            'popup' => true, // Use the popup window instead of redirecting.
            'services' => array(// You can change the providers and their classes.
                'email' => array(
                    'class' => 'lily.services.LEmailService',
                ),
                'onetime' => array(
                    'class' => 'lily.services.LOneTimeService',
                ),
                'google' => array(
                    'class' => 'lily.services.LGoogleService',
                ),
                'yandex' => array(
                    'class' => 'lily.services.LYandexService',
                ),
                'twitter' => array(
                    // application registration: https://dev.twitter.com/apps/new
                    'class' => 'lily.services.LTwitterService',
                    'key' => '',
                    'secret' => '',
                ),
                'vkontakte' => array(
                    // application registration: http://vkontakte.ru/editapp?act=create&site=1
                    'class' => 'lily.services.LVKontakteService',
                    'client_id' => '',
                    'client_secret' => '',
                ),
                'mailru' => array(
                    // application registration: http://api.mail.ru/sites/my/add
                    'class' => 'lily.services.LMailruService',
                    'client_id' => '',
                    'client_secret' => '',
                ),
            ),
        ),
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
            'loginUrl' => array('/lily/user/login'),
            'autoUpdateFlash' => false,
        ),
        'db' => require(dirname(__FILE__) . '/db.php'),
        'errorHandler' => array(
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CDbLogRoute',
                    'logTableName' => 'ls_log_debug',
                    'categories' => 'debug',
                    'connectionID' => 'db',
                ),
                //Route for collecting Lily's trace and info messages
                array(
                    'class' => 'CDbLogRoute',
                    'logTableName' => 'ls_log_linfo',
                    'categories' => 'lily',
                    'levels' => 'trace, info',
                    'connectionID' => 'db',
                ),
                //Route for collecting Lily's warning and error messages
                array(
                    'class' => 'CDbLogRoute',
                    'logTableName' => 'ls_log_lwe',
                    'categories' => 'lily',
                    'levels' => 'error, warning',
                    'connectionID' => 'db',
                ),
                //Route for collecting exceptions
                array(
                    'class' => 'CDbLogRoute',
                    'logTableName' => 'ls_log_exc',
                    'categories' => 'exception.*',
                    'connectionID' => 'db',
                ),
            ),
        ),
        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType' => 'smtp',
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => false,
            'transportOptions' => array(
                'host' => 'smtp.gmail.com',
                'username' => '@gmail.com',
                'password' => '',
                'port' => 465,
                'encryption' => 'ssl',
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
    ),
);