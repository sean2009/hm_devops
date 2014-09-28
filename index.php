<?php

define('YII_DEBUG', true);
define('YII_IS_MONITORING', false);

include '../yiiext/yii_ext_lib/bootStrap.php';

Yii::createWebApplication('./protected/config/main.php')->run();
