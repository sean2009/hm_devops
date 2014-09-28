<?php
$sides = array_fill_keys(array('index'), '');
$sides[Yii::app()->getController()->getAction()->getId()] = 'active';
?>
<div class="row">
    <div class="col-md-3">
        <ul class="nav sidenav">
            <li class="<?php echo $sides['index'] ?>"><a href="#">服务器列表</a></li>
        </ul>
    </div>
    <div class="col-md-9" role="main">
        <div>
            <a class="btn btn-primary" href="<?php echo $this->createUrl('server/add') ?>">新增服务器</a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>IP</th>
                    <th>状态</th>
                    <th>项目数</th>
                    <th>操作</th>
                </tr>
            </thead>
            <?php foreach ($list as $k => $val): ?>
            <tr class="alert <?php echo $val->status == ServerModel::STATUS_IS_OFF ? 'alert-danger' : '' ?>">
                <td><?php echo $k+1 ?></td>
                <td><?php echo $val->ip ?></td>
                <td><?php echo $val->status == ServerModel::STATUS_IS_OFF ? '已停用' : '使用中' ?></td>
                <td>0</td>
                <td>
                    <a href="<?php echo $this->createUrl('server/edit', array('id' => $val->id)) ?>" title="编辑"><span class="glyphicon glyphicon-edit"></span></a>
                    
                    <?php if ($val->status == ServerModel::STATUS_IS_OFF): ?>
                    <a class="change-status-link" href="<?php echo $this->createUrl('server/changeStatus', array('id' => $val->id, 'status' => ServerModel::STATUS_IS_ONLINE)) ?>" title="编辑"><span class="glyphicon glyphicon-play-circle"></span></a>
                    <?php else: ?>
                    <a class="change-status-link" href="<?php echo $this->createUrl('server/changeStatus', array('id' => $val->id, 'status' => ServerModel::STATUS_IS_OFF)) ?>" title="停用"><span class="glyphicon glyphicon-off"></span></a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php $this->widget('LinkPager', array('pages' => $pagination)) ?>
    </div>
</div>

<script type="text/javascript">
    $(function() {
        $(".change-status-link").click(function(e) {
            if (confirm('你确定要执行该操作？')) {
                $.getJSON(this.href, function(sData) {
                    if (!sData.success) {
                        Prompt.error(sData.msg);
                    } else {
                        window.location.reload(true);
                    }
                });
            }
            
            e.preventDefault();
        });
    });
</script>