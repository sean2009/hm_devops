<?php echo CHtml::form($this->createUrl('server/save'), 'POST', array('id' => 'server-form')) ?>
<?php echo CHtml::activeHiddenField($server, 'id') ?>
<div class="form-group">
    <label>IP</label>
    <?php echo CHtml::activeTextField($server, 'ip', array('class' => 'form-control')) ?>
</div>
<div class="form-group">
    <label>用户名</label><i class="help-inline">可执行sudo命令的用户</i>
    <?php echo CHtml::activeTextField($server, 'username', array('class' => 'form-control')) ?>
</div>
<div class="form-group">
    <label>密码</label><i class="help-inline">放心使用，经过加密处理</i>
    <?php echo CHtml::activePasswordField($server, 'password', array('class' => 'form-control')) ?>
</div>
<div class="form-group">
    <label>PHP路径</label>
    <?php echo CHtml::activeTextField($server, 'php_path', array('class' => 'form-control')) ?>
</div>
<div class="form-group">
    <label>Nginx路径</label>
    <?php echo CHtml::activeTextField($server, 'nginx_path', array('class' => 'form-control')) ?>
</div>
<div class="form-group">
    <label>nginx运行所属的用户</label>
    <?php echo CHtml::activeTextField($server, 'web_username', array('class' => 'form-control')) ?>
</div>
<div class="form-actions">
    <input type="reset" class="btn btn-default" value="重置"/>
    <input class="btn btn-primary" type="submit" value="保存"/>
</div>
<?php echo CHtml::endForm() ?>

<script type="text/javascript">
    $(function() {
        $("#server-form").submit(function(e) {
            var $submit = $(this).find('input[type=submit]');
            var orgText = $submit.val();
            
            $submit.attr('disabled', 'disabled').val('保存中...');
            
            $.post(this.action, $(this).serialize(), function(sData) {
                $submit.removeAttr('disabled');
                $submit.val(orgText);
                
                if (!sData.success) {
                    Prompt.error(sData.msg);
                } else {
                    alert("保存成功");
                    window.location = '<?php echo $this->createUrl('server/index') ?>';
                }
            }, 'json');
            
            e.preventDefault();
        });
    });
</script>