<?php

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Lily sample project',
    'aliases' => array(
        'lily' => 'ext.lily',
    ),
    // application components
    'components' => array(
        'db' => require(dirname(__FILE__) . '/db.php'),
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
            'assignmentTable' => '{{rbac_assignment}}',
            'itemChildTable' => '{{rbac_item_child}}',
            'itemTable' => '{{rbac_item}}',
        ),
    ),
    'commandMap' => array(
        'migrate' => array(
            'class' => 'system.cli.commands.MigrateCommand',
            'migrationPath' => 'application.migrations',
            'migrationTable' => 'ls_migration',
            'connectionID' => 'db',
        ),
        'lily_rbac' => array(
            'class' => 'lily.commands.LAuthInstaller'
        ),
        'rbac_installer' => array(
            'class' => 'application.commands.AuthInstaller'
        ),
    ),
);
