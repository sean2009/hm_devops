<ol class="breadcrumb">
  <li><a href="#">Home</a></li>
  <li><a href="<?php echo $this->createUrl('server/index') ?>">服务器</a></li>
  <li class="active">添加服务器</li>
</ol>

<?php $this->renderPartial('_form', array('server' => $server)) ?>