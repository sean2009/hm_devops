<style type="text/css">
    #revision-form .revision-list {max-height: 500px;overflow: auto;}
    #revision-form .form-control {border-top-right-radius: 0;border-bottom-right-radius: 0;border-right-width: 0;}

</style>
<ol class="breadcrumb">
    <li><a href="#">Home</a></li>
    <li><a href="<?php echo $this->createUrl('project/index') ?>">项目</a></li>
    <li class="active"><?php echo $project->project_name ?></li>
</ol>

<div class="row">
    <?php echo $this->renderPartial('_sidenav', array('project' => $project)) ?>
    <div class="col-md-9" role="main">
        <fieldset>
            <legend>最新的50个版本</legend>
            <form method="post" id="revision-form" action="<?php echo $this->createUrl('deploy/submit') ?>">
                <?php echo CHtml::hiddenField('project_id', $project->id) ?>
                <?php echo CHtml::hiddenField('servers', "") ?>
                <?php echo CHtml::hiddenField('memo') ?>
                <div class="revision-list">
                    <?php foreach ($logs as $val): ?>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <input class="revision" name="revision[]" <?php echo $val['rev'] == $lastRevision ? 'checked="checked"' : '' ?> value="<?php echo $val['rev'] ?>" type="checkbox">
                                </span>
                                <span class="form-control">
                                    <?php echo $val['rev'], ' - ', date('y/m/d', strtotime($val['date'])), ' - ', htmlspecialchars($val['msg']) ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><input type="checkbox" value="1" name="rsync_config" checked="checked" /></span>
                        <span class="form-control">同步配置</span>
                    </div>
                </div>
<!--                <div class="form-group">
                    <div class="buttonset"><?php // echo CHtml::radioButtonList('env', ServerModel::ENV_PRE,  ServerModel::$envMapNames, array('separator' => '')) ?></div>
                </div>-->
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="提交发布" />    
                </div>
            </form>    
        </fieldset>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        var servers = <?php echo json_encode($servers) ?>;

        $("#revision-form").submit(function() {
            var $checkbox = $('input.revision:checked', this);
            
            if ($checkbox.size() == 0) {
                alert("请选择你要发布的版本");
            } else if (!servers) {
                alert('你指定的环境还没有服务器，请先去添加一台服务器，并初始化它');
            } else {
                var memo = $.trim(window.prompt("发布备注"));
                
                $(this).find("input[name=memo]").val(memo);
                
                if (!memo) {
                    alert("请填写发布备注");
                    return false;
                }
                
                return true;
            }
            return false;
        });
    });
</script>