<ol class="breadcrumb">
    <li><a href="#">Home</a></li>
    <li><a href="<?php echo $this->createUrl('project/index') ?>">项目</a></li>
    <li class="active"><?php echo $project->project_name ?></li>
</ol>
<div class="row">
    <?php echo $this->renderPartial('_sidenav', array('project' => $project)) ?>
    <div class="col-md-9" role="main">
        <a href="#myModal" class="btn btn-primary" data-toggle="modal">添加服务器</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>IP</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <?php foreach ($list as $k => $val): ?>
            <tr>
                <td><?php echo $k+1 ?></td>
                <td><?php echo $val->server->ip ?></td>
                <td><?php echo ProjectServerModel::$statusMap[$val->status] ?></td>
                <td>
                    <a class="remove-link" title="移除" href="<?php echo $this->createUrl('project/removeServer', array('project_id' => $project->id, 'server_id' => $val->server_id)) ?>"><span class="glyphicon glyphicon-remove"></span></a>
                    <?php if ($val->status == ProjectServerModel::STATUS_UNINIT): ?>
                    <a class="init-link" title="初始化" href="<?php echo $this->createUrl('project/initServer', array('project_id' => $project->id, 'server_id' => $val->server_id)) ?>"><span class="glyphicon glyphicon-flash"></span></a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <?php echo CHtml::form($this->createUrl('project/addServer'), 'post', array('id' => 'server-form')) ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">添加一台新的服务器</h4>
            </div>
            <div class="modal-body">
                <?php echo CHtml::hiddenField('project_id', $project->id) ?>
                <?php echo CHtml::dropDownList('server_id', '', ServerModel::getAvailableServeies($project), array('class' => 'chzn-select', 'style' => 'width: 190px;', 'placeholder' => '选择服务器')) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <input type="submit" class="btn btn-primary" value="添加">
            </div>
        </div>
        <?php echo CHtml::endForm() ?>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $("#server-form").submit(function(e) {
            var $submit = $(this).find('input[type=submit]');
            $submit.attr('disable', 'disable').val('添加中...');
            $.post(this.action, $(this).serialize(), function(sData) {
                if (!sData.success) {
                    Prompt.error(sData.msg);
                } else {
                    window.location.reload(true);
                }
                $submit.removeAttr('disable').val('添加');
            }, 'json');
            e.preventDefault();
        });
        
        $(".remove-link").click(function(e) {
            if (!confirm("你确定要将这台服务器移出吗？")) {
                e.preventDefault();
            }
        });
        $(".init-link").click(function(e) {
            $(document.body).block({message: "正在初始化..."});
            $.getJSON(this.href, function(sData) {
                $(document.body).unblock();
                if (sData.success) {
                    alert("初始化成功");
                    window.location.reload(true);
                } else {
                    Prompt.error(sData.msg);
                }
            });
            e.preventDefault();
        });
    });
</script>