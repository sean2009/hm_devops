<?php
$progress = array(BatchServerModel::STATUS_FAILED => 'progress-bar-danger', BatchServerModel::STATUS_IS_OK => 'progress-bar-success', BatchServerModel::STATUS_NO_START => 'progress-bar-warning');
$progressText = array(BatchServerModel::STATUS_FAILED => '发布出错', BatchServerModel::STATUS_IS_OK => '完成', BatchServerModel::STATUS_NO_START => '等待发布');
?>
<style type="text/css">
    .progress-bar span {color: black;}
</style>
<fieldset>
    <legend>
        <div class="alert alert-warning">
            <?php echo '正在发布 ', $batch->project->project_name ?>&nbsp;不要离开当前页面
            <span>初始化中...</span>
            当有服务器没有发布成功成功时，请<a class="alert-link" href="<?php echo $this->createUrl('deploy/view', array('batch_id' => $batch->batch_id)) ?>">点击这里</a>
        </div>
    </legend>
    <ul class="list-group">
        <?php foreach ($batch->batchServers as $status): ?>
            <li class="list-group-item" id="progress-<?php echo $status->id ?>">
                <div><?php echo $status->server->ip ?></div>
                <div class="progress">
                    <div class="progress-bar <?php echo $progress[$status->status] ?>" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                        <span><?php echo $progressText[$status->status] ?></span>
                    </div>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</fieldset>

<?php if (!$preview): ?>
    <script type="text/javascript">
        $(function() {
            var projectId = <?php echo $batch->project->id ?>;
            var batchServers = <?php echo json_encode(array_map(function($s) {return $s->id;}, $batch->batchServers)) ?>;
            var progressClasses = <?php echo json_encode($progress) ?>;
            var progressText = <?php echo json_encode($progressText) ?>;
            var batchId = <?php echo $batch->batch_id ?>;

            $.getJSON('<?php echo $this->createUrl('deploy/batchInit', array('batch_id' => $batch->batch_id)) ?>', function(sData) {
                var $alert = $("fieldset legend .alert span");
                if (sData.success) {
                    for (var i = 0; i < batchServers.length; i++) {
                        var serverId = batchServers[i];
                        if ($("#progress-" + serverId + " .progress-bar").hasClass('<?php echo $progress[BatchServerModel::STATUS_NO_START] ?>')) {
                            var $progress = $("#progress-" + serverId + " .progress");
                            $progress.addClass('progress-striped active').find('span').text('正在发布...');

                            $.post("<?php echo $this->createUrl('deploy/publish') ?>", {batch_id: batchId, item: serverId}, function(sData) {
                                var $progress = $("#progress-" + sData.item + " .progress");
                                $progress.removeClass('progress-striped active');

                                if (!sData.success) {
                                    $progress.find('span').text(progressText[<?php echo BatchServerModel::STATUS_FAILED ?>]).end().children('.progress-bar')
                                            .addClass(progressClasses[<?php echo BatchServerModel::STATUS_FAILED ?>]);
                                } else {
                                    $progress.find('span').text(progressText[<?php echo BatchServerModel::STATUS_IS_OK ?>]).end().children('.progress-bar')
                                            .removeClass('progress-bar-warning').addClass(progressClasses[<?php echo BatchServerModel::STATUS_IS_OK ?>]);
                                }
                            }, 'json');
                        }
                    }
                    $alert.text("初始化完成");
                } else {
                    $alert.text(sData.msg).parent().addClass('alert-danger');
                }
            });

        });
    </script>
<?php endif; ?>