<?php
$action = Yii::app()->getController()->getAction()->getId();
$actives = array_fill_keys(array('server', 'view', 'nginx', 'code'), '');
$actives[$action] = 'active';
?>

<div class="col-md-3">
    <ul class="nav sidenav">
        <li class="<?php echo $actives['view'] ?>"><a href="<?php echo $this->createUrl('project/view', array('id' => $project->id)); ?>">基本信息</a></li>
        <li class="<?php echo $actives['nginx'] ?>"><a href="<?php echo $this->createUrl('project/nginx', array('id' => $project->id)); ?>">Nginx</a></li>
        <li class="<?php echo $actives['server'] ?>"><a href="<?php echo $this->createUrl('project/server', array('id' => $project->id)); ?>">服务器</a></li>
        <li class="<?php echo $actives['code'] ?>"><a href="<?php echo $this->createUrl('project/code', array('id' => $project->id)); ?>">代码</a></li>
    </ul>
</div>
