<?php
$tabs = array_fill_keys(array('server', 'project', 'user'), '');
$tabs[Yii::app()->getController()->getId()] = 'active';

?>
<header class="navbar navbar-inverse navbar-fixed-top bs-docs-nav" role="banner">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".bs-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="<?php echo Yii::app()->createUrl('site/index') ?>" class="navbar-brand">发布系统</a>
        </div>
        <nav class="collapse navbar-collapse" role="navigation">
            <ul class="nav navbar-nav">
                <li class="<?php echo $tabs['server'] ?>">
                    <a href="<?php echo Yii::app()->createUrl('server/index') ?>">服务器</a>
                </li>
                <li class="<?php echo $tabs['project'] ?>">
                    <a href="<?php echo Yii::app()->createUrl('project/index') ?>">项目</a>
                </li>
                <li class="<?php echo $tabs['user'] ?>">
                    <a href="<?php echo Yii::app()->createUrl('user/index') ?>">用户</a>
                </li>
            </ul>
        </nav>
    </div>
</header>