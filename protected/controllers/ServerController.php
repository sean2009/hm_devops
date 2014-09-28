<?php

class ServerController extends AuthController {
    
    public function actionIndex() {
        $renderData = array();
        $criteria = new CDbCriteria(array(
            'condition' => 'is_deleted=0',
            'order' => 'id DESC'
        ));
        
        $paginatin = new CPagination(ServerModel::model()->count($criteria));
        $paginatin->applyLimit($criteria);
        
        $list = ServerModel::model()->findAll($criteria);
        
        $renderData['list'] = $list;
        $renderData['pagination'] = $paginatin;
        
        $this->render('', $renderData);
    }
    
    public function actionAdd() {
        $renderData = array();
        $server = new ServerModel();
        $server->setAttributes(array(
            'username' => 'root',
            'php_path' => '/usr/local/php/bin/php',
            'nginx_path' => '/usr/local/nginx/sbin/nginx',
            'env' => ServerModel::ENV_PRO
        ), false);
        
        $renderData['server'] = $server;
        
        $this->render('', $renderData);
    }
    
    public function actionSave() {
        $ret = array('success' => false);
        
        if (isset($_POST['ServerModel'])) {
            if ($_POST['ServerModel'] && !$_POST['ServerModel']['id']) {
                $server = new ServerModel();
            } else {
                $server = ServerModel::model()->findByPk($_POST['ServerModel']['id']);
            }
            
            $server->setAttributes($_POST['ServerModel'], false);
            $server->password = ECommon::encrypt($server->password);
            
            if ($server->save()) {
                $ret['success'] = true;
            } else {
                $ret['msg'] = $server->getErrors();
            }
        }
        
        $this->responseJSON($ret);
    }
    
    public function actionEdit() {
        $renderData = array();
        $server = ServerModel::model()->findByPk($_GET['id']);
        
        $server->password = ECommon::decrypt($server->password);
        
        $renderData['server'] = $server;
        
        $this->render('', $renderData);
    }
    
    public function actionChangeStatus() {
        $ret = array('success' => false);
        $server = ServerModel::model()->findByPk($_GET['id']);
        $server->status = $_GET['status'];
        
        if ($server->update()) {
            $ret['success'] = true;
        } else {
            $ret['msg'] = $server->getErrors();
        }
        
        $this->responseJSON($ret);
    }
    
}
