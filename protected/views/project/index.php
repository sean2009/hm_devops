<div class="row">
    <div class="col-md-3">
        <?php echo $this->renderPartial('_sidenav_1') ?>
    </div>
    <div class="col-md-9">
        <a class="btn btn-primary" href="<?php echo $this->createUrl('project/add') ?>">添加新项目</a>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>项目名</th>
                    <th>项目代码</th>
                    <th>服务器数</th>
                    <th>操作</th>
                </tr>
            </thead>
            <?php foreach ($list as $k => $val): ?>
                <tr>
                    <td><?php echo $k + 1 ?></td>
                    <td><?php echo $val->project_name ?></td>
                    <td><?php echo $val->code ?></td>
                    <td><?php echo 0 ?></td>
                    <td><a href="<?php echo $this->createUrl('project/view', array('id' => $val->id)) ?>" title="编辑"><span class="glyphicon glyphicon-edit"></span></a></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <?php $this->widget('LinkPager', array('pages' => $pagination)) ?>
    </div>
</div>