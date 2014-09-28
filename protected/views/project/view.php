<ol class="breadcrumb">
    <li><a href="#">Home</a></li>
    <li><a href="<?php echo $this->createUrl('project/index') ?>">项目</a></li>
    <li class="active"><?php echo $project->project_name ?></li>
</ol>

<div class="row">
    <?php echo $this->renderPartial('_sidenav', array('project' => $project)) ?>
    <div class="col-md-9" role="main">
        <?php $this->renderPartial('_form', array('project' => $project)) ?>
    </div>
</div>