<?php

class ProjectModel extends CActiveRecord {

    /**
     * 
     * @param type $className
     * @return ProjectModel
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'd_project';
    }

    public function rules() {
        return array(
            array('project_name,code,svn_path,domain,root_path', 'required'),
            array('code', '_validateCode'),
            array('svn_path', '_validateSVN'),
        );
    }

    public function attributeLabels() {
        return array(
            'project_name' => '项目名',
            'code' => '项目代码',
            'svn_path' => 'SVN路径',
            'root_path' => '项目根目录',
            'domain' => '域名'
        );
    }

    public function relations() {
        return array(
            'servers' => array(self::MANY_MANY, 'ServerModel', 'd_project_server(project_id, server_id)', 'on' => 'servers_servers.status=' . ProjectServerModel::STATUS_RUNNING . ' AND servers.is_deleted=0'),
        );
    }

    public function _validateSVN() {
        $svn = new ESvn();

        if ($this->isNewRecord && (!is_dir(Yii::app()->params['deploy_base_dir']) || !is_writable(Yii::app()->params['deploy_base_dir']))) {
            $this->addError('svn_path', Yii::app()->params['deploy_base_dir'] . ' 发布目录不可写或者不存在');
        }
        
        try {
            if (!$this->hasErrors() && !is_dir($this->getRootPath()) && !$svn->checkOut($this->svn_path, $this->getRootPath())) {
                $this->addError('svn_path', 'SVN路径错误（或者有中文文件名），不能导出');
            }
        } catch (Exception $ex) {
            $this->addError('svn_path', $ex->getMessage());
        }
    }

    public function _validateDomain() {
         $this->addError('domain', '域名不能为空');
    }

    public function _validateCode() {
        if (!preg_match('/^[A-Za-z0-9_\-]+$/', $this->code)) {
            $this->addError('code', '项目代码只可以为字母、数字或者下划线');
        } elseif ($this->isNewRecord && self::model()->exists('code=:code', array(':code' => $this->code))) {
            $this->addError('code', '这个项目已经存在了');
        }
    }

    public function beforeSave() {
//        if ($this->framework != self::FRAMEWORK_YIIEXT && $this->getScenario() == 'nginx') {
            if ($this->isNewRecord) {
                $nginxConf = file_get_contents(Yii::app()->basePath . '/config/nginx/partial.conf');
                $nginxConf = str_replace('{$domain}', $this->domain, $nginxConf);
                $nginxConf = str_replace('{$log_name}', $this->code, $nginxConf);
                $this->nginx_conf = str_replace('{$root_path}', $this->getRootPath(), $nginxConf);
            } else {
                foreach ($this->servers as $server) {
                    try {
                        ServerHelper::updateNginxConf($this, $server, $server->getSSH2());
                    } catch (Exception $ex) {
                        $this->addError('project_name', $ex->getMessage());
                    }
                }
            }    
//        }

        return true;
    }
    
    public function afterFind() {
        if (!is_dir($this->getConfigPath()) && $this->config_svn_path) {
            $svn = new ESvn();
            $svn->checkOut($this->config_svn_path, $this->getConfigPath());
        }
    }

    public function getRootPath() {
        return Yii::app()->params['deploy_base_dir'] . '/' . $this->root_path;
    }
    
    public function getTmpDeployDir() {
        return sys_get_temp_dir() . "/deploy/{$this->code}";
    }
    
    public function getConfigPath() {
        return sys_get_temp_dir() . '/app/product_configs/' . $this->code;
    }

    public function getNginxConf() {
        return "{$this->code}.conf";
    }

}
