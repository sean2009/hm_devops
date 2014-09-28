<ol class="breadcrumb">
    <li><a href="#">Home</a></li>
    <li><a href="<?php echo $this->createUrl('project/index') ?>">项目</a></li>
    <li class="active"><?php echo $project->project_name ?></li>
</ol>

<div class="row">
    <?php echo $this->renderPartial('_sidenav', array('project' => $project)) ?>
    <div class="col-md-9" role="main">
        <?php if (isset($_POST['ProjectModel'])): ?>
        <div class="alert alert-success">更新成功</div>
        <?php endif; ?>
        <?php echo CHtml::form($this->createUrl('project/nginx'), 'POST') ?>
            <?php echo CHtml::activeTextArea($project, 'nginx_conf', array('style' => 'width: 700px;height:600px;')) ?>
            <div class="form-actions">
                <?php echo CHtml::hiddenField('id', $project->id) ?>
                <input type="reset" class="btn btn-default" value="重置"/>
                <input type="submit" class="btn btn-primary" value="保存"/>
            </div>
        <?php echo CHtml::endForm() ?>
    </div>
</div>