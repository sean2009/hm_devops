<?php
$action = Yii::app()->getController()->getAction()->getId();
$actives = array_fill_keys(array('index', 'view', 'nginx', 'code'), '');
$actives[$action] = 'active';
?>

<ul class="nav sidenav">
    <li class="<?php echo $actives['index'] ?>"><a href="<?php echo $this->createUrl('project/index'); ?>">项目列表</a></li>
    <li class="<?php echo $actives['publishLog'] ?>"><a href="<?php echo $this->createUrl('project/publishLog'); ?>">发布日志</a></li>
</ul>
