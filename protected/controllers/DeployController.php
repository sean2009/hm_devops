<?php


class DeployController extends AuthController {
    
    public function actionSubmit() {
        $revision = $_POST['revision'];
        $memo = $_POST['memo'];
        $env = $_POST['env'];
        
        $project = ProjectModel::model()->with('servers')->findByPk($_POST['project_id']);
        
//        if ($project->framework == ProjectModel::FRAMEWORK_YIIEXT) {
//            $servers = ServerModel::model()->findAllByAttributes(array('is_deleted' => 0, 'status' => ServerModel::STATUS_IS_ONLINE));
//        } else {
        $servers = ProjectServerModel::model()->findAll('project_id = :project_id',array(':project_id'=>$project->id));
        
//        }
        
        $batch = new BatchModel();
        $batch->setAttributes(array(
            'project_id' => $project->id,
            'revision' => implode(',', $revision),
            'memo' => $memo,
            'rsync_config' => (int) $_POST['rsync_config'],
        ), false);
        
        if ($batch->save()) {
            foreach ($servers as $val) {
                $batchServer = new BatchServerModel();
                $batchServer->setAttributes(array(
                    'batch_id' => $batch->batch_id,
                    'server_id' => $val->id,
                    'status' => BatchServerModel::STATUS_NO_START
                ), false);
                $batchServer->save();
            }
            $this->redirect($this->createUrl('deploy/view', array('batch_id' => $batch->batch_id)));
        }
    }
    
    public function actionView() {
        $batch = BatchModel::model()->with('project', 'batchServers')->findByPk($_GET['batch_id']);
        
        $renderData = array('batch' => $batch, 'preview' => isset($_GET['preview']));
        
        $this->render('', $renderData);
    }
    
    public function actionPublish() {
        $ret = array('success' => false);
        
        $batchServer = BatchServerModel::model()->with('batch', 'server')->findByPk($_POST['item']);
//        var_dump($batchServer->attributes);
//        die;
        if ($batchServer->status != BatchServerModel::STATUS_IS_OK) {
//            $project = 
            $rsyncInfo = Utils::rsync($batchServer->batch->project, $batchServer->server, $batchServer->batch->rsync_config, false);
//    var_dump($batchServer->batch->project);
//            var_dump($batchServer->server);
//            var_dump($batchServer->batch->rsync_config);
//            die;
//            var_dump($rsyncInfo);
            if (!$rsyncInfo['success']) {
                $ret['msg'] = $rsyncInfo['msg'];
            } else {
                $batchServer->status = BatchServerModel::STATUS_IS_OK;
                $batchServer->save();
                
                $ret['success'] = true;
            }
        }
        
        $ret['item'] = $batchServer->id;
        
        $this->responseJSON($ret);
    }
    
    public function actionBatchInit() {
        $ret = array('success' => false);
        $batch = BatchModel::model()->with('batchServers', 'project')->findByPk($_GET['batch_id']);
        $published = true;
        $tmpDir = $this->getTmpDir($batch->project);
        foreach ($batch->batchServers as $val) {
            if ($val->status != BatchServerModel::STATUS_IS_OK) {
                $published = false;
                break;
            }
        }
        
        if (!$published) {
            $emptyDir = Utils::getEmptyDir();
            
            if (!is_dir($tmpDir)) {
                mkdir($tmpDir, 0777, true);
            }

            exec("rsync --delete-before -d $emptyDir/ $tmpDir/", $outpur, $retVal);            
        }
        if ($published) {
            $ret['msg'] = '这个批次任务已经发布过了';
        } elseif ($retVal != 0) {
            $ret['msg'] = implode('', $outpur);
        } else {
            $svn = new ESvn();
            $ret['success'] = $svn->export($batch->project->svn_path, $batch->project->getRootPath(), $tmpDir, false, explode(',', $batch->revision));;
        }
        
        $this->responseJSON($ret);
    }
    
    private function getTmpDir($project) {
        return $project->getTmpDeployDir();
    }
    
}
