<?php

class ProjectServerModel extends CActiveRecord {

    const STATUS_RUNNING = 1;
    const STATUS_UNINIT = 0;

    public static $statusMap = array(
        self::STATUS_RUNNING => '运行中',
        self::STATUS_UNINIT => '未初始化'
    );

    /**
     * 
     * @param type $className
     * @return ProjectServerModel
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'd_project_server';
    }

    public function rules() {
        return array(
            array('project_id,server_id', 'required'),
            array('server_id', '_validateServerId')
        );
    }

    public function relations() {
        return array(
            'server' => array(self::BELONGS_TO, 'ServerModel', 'server_id', 'on' => 'server.is_deleted=0'),
            'project' => array(self::BELONGS_TO, 'ProjectModel', 'project_id')
        );
    }

    public function beforeSave() {
        try {
            $project = ProjectModel::model()->findByPk($this->project_id);
            $server = ServerModel::model()->findByPk($this->server_id);

            $ssh2 = $server->getSSH2();

//            if ($project->framework != ProjectModel::FRAMEWORK_YIIEXT) {
                ServerHelper::updateNginxConf($project, $server, $ssh2);
//            }
        } catch (Exception $ex) {
            $this->addError('server_id', $ex->getMessage());
            return false;
        }

        return true;
    }

    public function afterSave() {
        $ssh2 = $this->server->getSSH2();
        $rsyncConf = Yii::app()->params['rsync']['config_file'];
        $data = parse_ini_string(stream_get_contents($ssh2->open($rsyncConf, 'rb')), true, INI_SCANNER_RAW);
        $data[$this->project->code] = array(
            'path' => $this->project->getRootPath(),
            'read only' => 'no',
            'comment' => $this->project->project_name,
            'list' => 'no',
            'ignore errors' => ''
        );

        $fp = $ssh2->open($rsyncConf, 'wb');
        fwrite($fp, Utils::arrToIniString($data));
        fclose($fp);
        try {
            $ssh2->exec('sudo mkdir -p ' . $this->project->getRootPath());
            $ssh2->exec("sudo chown -R {$this->server->web_username}.{$this->server->web_username} " . $this->project->getRootPath());
            $ssh2->exec('sudo killall -9 rsync; rm ' . Yii::app()->params['rsync']['pid']);
        } catch (Exception $ex) {
            
        }

        $ssh2->exec("sudo rsync --config=" . $rsyncConf . " --daemon");
    }

    public function afterDelete() {
        try {
            return true;
//            $server = ServerModel::model()->findByPk($this->server_id);
//            $project = ProjectModel::model()->findByPk($this->project_id);

//            if ($project->framework != ProjectModel::FRAMEWORK_YIIEXT) {
//                $ssh2 = $server->getSSH2();
//
//                $ssh2->unlink($server->getNginxConfRedStarDir() . '/' . $project->getNginxConf());
//                $ssh2->exec('sudo ' . $server->nginx_path . ' -s reload');
//            }
        } catch (Exception $ex) {
            $this->addError('server_id', $ex->getMessage());
            return false;
        }
    }

    public function _validateServerId() {
        if (!$this->hasErrors() && self::model()->exists('project_id=:p AND server_id=:s', array(':p' => $this->project_id, ':s' => $this->server_id))) {
            $this->addError('server_id', "这台服务器已经添加过了");
        }
    }

}
