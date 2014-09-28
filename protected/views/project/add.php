<ol class="breadcrumb">
    <li><a href="#">Home</a></li>
    <li><a href="<?php echo $this->createUrl('project/index') ?>">项目</a></li>
    <li class="active">添加新项目</li>
</ol>

<?php $this->renderPartial('_form', array('project' => $project)) ?>