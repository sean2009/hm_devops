<?php echo CHtml::form($this->createUrl('project/save'), 'post', array('id' => 'project-form')) ?>
<?php echo CHtml::activeHiddenField($project, 'id') ?>
<div class="form-group">
    <label>项目名</label>
    <?php echo CHtml::activeTextField($project, 'project_name', array('class' => 'form-control')) ?>
</div>
<div class="form-group">
    <label>项目代码</label><i class="help-inline">比如：passport_web, web_pay</i>
    <?php echo CHtml::activeTextField($project, 'code', array('class' => 'form-control')) ?>
</div>
<div class="form-group">
    <label>项目根目录</label><i class="help-inline">输入项目代码，自动生成</i>
    <div class="input-group">
        <span class="input-group-addon"><?php echo Yii::app()->params['deploy_base_dir'], '/' ?></span>
        <?php echo CHtml::activeTextField($project, 'root_path', array('class' => 'form-control')) ?>
    </div>
</div>
<div class="form-group domain-group">
    <label>域名</label>
    <div class="input-group">
        <span class="input-group-addon">http://</span>
        <?php echo CHtml::activeTextField($project, 'domain', array('class' => 'form-control')) ?>
    </div>
</div>
<div class="form-group">
    <label>SVN路径</label>
    <?php echo CHtml::activeTextField($project, 'svn_path', array('class' => 'form-control')) ?>
</div>
<div class="form-group config-group">
    <label>配置文件SVN路径</label>
    <?php echo CHtml::activeTextField($project, 'config_svn_path', array('class' => 'form-control')) ?>
</div>
<div class="form-actions">
    <input type="reset" class="btn btn-default" value="重置"/>
    <input class="btn btn-primary" type="submit" value="保存"/>
</div>
<?php echo CHtml::endForm() ?>

<script type="text/javascript">
    $(function() {
        $('#project-form').submit(function(e) {
            var $form = $(this);
            var $submit = $form.find('input[type=submit]');
            $submit.val('保存中...');

            $.post(this.action, $(this).serialize(), function(sData) {
                $submit.val('保存');
                if (!sData.success) {
                    Prompt.error(sData.msg);
                } else {
                    alert("保存成功");
                    window.location = '<?php echo $this->createUrl('project/view', array('id' => $project->id)) ?>' + sData.id;
                }
            }, 'json');
            e.preventDefault();
        });
        
        $("#ProjectModel_code").keyup(function() {
            $("#ProjectModel_root_path").val($(this).val());
        });
        $("#ProjectModel_framework").change(function() {
            if ($(this).val() == 'yiiext') {
                $(".domain-group").hide();
            } else {
                $(".domain-group").show();
            }
        });
    });
</script>