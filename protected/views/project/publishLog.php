<div class="row">
    <div class="col-md-3">
        <?php echo $this->renderPartial('_sidenav_1') ?>
    </div>
    <div class="col-md-9">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>批次ID</th>
                    <th>项目</th>
                    <th>版本</th>
                    <th>发布时间</th>
                    <th>发布备注</th>
                </tr>
            </thead>
            <?php foreach ($list as $val): ?>
            <tr>
                <td><a target="_blank" href="<?php echo $this->createUrl('deploy/view', array('batch_id' => $val->batch_id, 'preview' => 1)) ?>"><?php echo $val->batch_id ?></a></td>
                <td><a href="<?php echo $this->createUrl('project/view', array('id' => $val->project->id)) ?>"><?php echo $val->project->project_name ?></a></td>
                <td><?php echo $val->revision ?></td>
                <td><?php echo date('Y/m/d H:i:s', $val->dateline) ?></td>
                <td title="<?php echo $val->memo; ?>"><?php echo ECommon::substr($val->memo, 0, 10, true) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php $this->widget('LinkPager', array('pages' => $pagination)) ?>
    </div>
</div>