<?php

return array(
    'language' => 'zh_cn',
    'import' => array(
        'application.components.*',
        'application.models.*',
        'yii_ext_lib.extensions.db.*',
        'application.widgets.*'
    ),
    'components' => array_merge(array(), require(dirname(__FILE__) . '/' . DEV_ENVIRONMENT . '/components.php')),
    'params' => array(
        'deploy_base_dir' => '/app',
        'rsync' => array(
            'pid' => '/var/run/rsyncd.pid',
            'config_file' => '/usr/local/conf/rsyncd.conf',
            'lock' => '/var/run/rsync.lock'
        ),
        'php' => array(
            'extensions' => array('pdo_mysql', 'oci8', 'mongo', 'mbstring', 'curl', 'yar', 'fastdfs_client')
        ),
        'svn' => array(
            'username' => 'xiaopeng',
            'password' => 'xiaopeng'
        ),
        'exclude' => array(
            'yii' => array('protected/runtime/*', 'config/pro/*'),
            'ecshop' => array('temp/caches/*', 'config.php', 'init.php', 'temp/compiled/*', 'temp/static_caches/*'),
        )
    )
);
