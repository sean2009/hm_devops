<?php

return array(
    'db' => array(
        'class' => 'CDbConnection',
        'connectionString' => "mysql:host=127.0.0.1;port=3306;dbname=devops",
        'emulatePrepare' => true,
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8',
        'tablePrefix' => 'b_',
        'schemaCachingDuration' => 0,
    )
);
