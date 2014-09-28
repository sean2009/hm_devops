<?php

class ProjectController extends AuthController {

    public function init() {
        parent::init();
        set_time_limit(3600);
    }

    public function actionIndex() {
        $renderData = array();
        $criteria = new CDbCriteria(array(
            'order' => 'id DESC'
        ));
        $pagination = new CPagination(ProjectModel::model()->count());
        $pagination->setPageSize(20);
        $pagination->applyLimit($criteria);

        $list = ProjectModel::model()->findAll($criteria);

        $renderData['list'] = $list;
        $renderData['pagination'] = $pagination;

        $this->render('', $renderData);
    }

    public function actionAdd() {
        $renderData = array();
        $project = new ProjectModel();

        $renderData['project'] = $project;

        $this->render('', $renderData);
    }

    public function actionSave() {
        $ret = array('success' => false);

        if (isset($_POST['ProjectModel'])) {
            if ($_POST['ProjectModel']['id']) {
                $project = ProjectModel::model()->findByPk($_POST['ProjectModel']['id']);
            } else {
                $project = new ProjectModel();
            }
            $project->setAttributes($_POST['ProjectModel'], false);

            if ($project->save()) {
                $ret['success'] = true;
                $ret['id'] = $project;
            } else {
                $ret['msg'] = $project->getErrors();
            }
        }

        $this->responseJSON($ret);
    }

    public function actionView() {
        $project = ProjectModel::model()->findByPk($_GET['id']);
        $renderData = array('project' => $project);

        $this->render('', $renderData);
    }

    public function actionServer() {
        $project = ProjectModel::model()->findByPk($_GET['id']);
        $renderData = array('project' => $project);

        $list = ProjectServerModel::model()->with('server')->findAllByAttributes(array('project_id' => $project->id));
        $renderData['list'] = $list;

        $this->render('', $renderData);
    }

    public function actionAddServer() {
        $ret = array('success' => false);

        if (!isset($_POST['server_id']) || empty($_POST['server_id'])) {
            $ret['msg'] = '请选择服务器';
        } else {
            $server = new ProjectServerModel();
            $server->setAttributes(array(
                'project_id' => $_POST['project_id'],
                'server_id' => $_POST['server_id']
                ), false);

            if ($server->save()) {
                $ret['success'] = true;
            } else {
                $ret['msg'] = $server->getErrors();
            }
        }

        $this->responseJSON($ret);
    }

    public function actionNginx() {
        $project = ProjectModel::model()->findByPk($_REQUEST['id']);
        $project->setScenario('nginx');
        $renderData = array('project' => $project);
        if (isset($_POST['ProjectModel']) && $_POST['ProjectModel']['nginx_conf']) {
            $project->setAttributes($_POST['ProjectModel'], false);
            $project->save();
        }

        $this->render('', $renderData);
    }

    public function actionRemoveServer() {
        $project = ProjectModel::model()->findByPk($_GET['project_id']);
        ProjectServerModel::model()->deleteAllByAttributes(array('project_id' => $project->id, 'server_id' => $_GET['server_id']));

        $this->redirect($this->createUrl('project/server', array('id' => $project->id)));
    }

    public function actionCode() {
        $project = ProjectModel::model()->findByPk($_REQUEST['id']);
        $renderData = array('project' => $project);
        
        $svn = new ESvn();

        $logs = $svn->log($project->svn_path, 0, 0, 50);
        $servers = $histories = array();
        $lastRevision = 0;

        foreach ($logs as $val) {
            if (!$lastRevision) {
                $lastRevision = $val['rev'];
            }
        }
        $renderData['lastRevision'] = $lastRevision;
        $renderData['logs'] = $logs;

        $list = ProjectServerModel::model()->findAll('project_id = :project_id',array(':project_id'=>$project->id));
        foreach($list as $val){
            $servers[] = $val->server_id;
        }
        $renderData['servers'] = $servers;

        $this->render('', $renderData);
        
        fastcgi_finish_request();
        $svn->update($project->getRootPath());
    }

    public function actionGetFile() {
        $revision = $_GET['revision'];
        $project = ProjectModel::model()->findByPk($_REQUEST['project_id']);
        $fileList = array();
        $pos = strrpos($project->svn_path, '/');
        $sub = substr($project->svn_path, $pos + 1) . '/';

        $svn = new ESvn();
        if ($revision == 0) {
            $list = Utils::listFiles($project->getRootPath());
            foreach ($list as $val) {
                $fileList[$val] = 0;
            }
        } else {
            $revision = explode(',', $revision);
            $logs = $svn->log($project->svn_path, min($revision), max($revision));
            foreach ($logs as $log) {
                if (in_array($log['rev'], $revision)) {
                    foreach ($log['paths'] as $val) {
                        if (strpos($val['path'], $sub) !== false && !in_array($val['path'], $fileList) && $val['action'] != 'D') {
                            $fileList[$val['path']] = $log['rev'];
                        }
                    }
                }
            }
        }

        $this->responseJSON($fileList);
    }

    public function actionInitServer() {
        $ret = array('success' => false);

        $project = ProjectModel::model()->findByPk($_GET['project_id']);
        $server = ServerModel::model()->findByPk($_GET['server_id']);
        
        $rsyncInfo = Utils::rsync($project, $server, true, true);
        if (!$rsyncInfo['success']) {
            $ret['msg'] = $rsyncInfo['msg'];
        } else {
            ProjectServerModel::model()->updateAll(array('status' => ProjectServerModel::STATUS_RUNNING), 'project_id=:p AND server_id=:s', array(
                ':p' => $project->id,
                ':s' => $server->id
            ));
            $ret['success'] = true;
        }

        $this->responseJSON($ret);
    }
    
    public function actionPublishLog() {
        $criteria = new CDbCriteria(array(
            'order' => 'dateline DESC'
        ));
        
        $total = BatchModel::model()->count($criteria);
        
        $pagination = new CPagination($total);
        $pagination->setPageSize(20);
        $pagination->applyLimit($criteria);
        
        $list = BatchModel::model()->with('project')->findAll($criteria);
        
        $renderData = array('pagination' => $pagination, 'list' => $list);
        
        $this->render('publishLog', $renderData);
    }

}
