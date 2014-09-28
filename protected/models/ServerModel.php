<?php

Yii::import('application.extensions.net.mmanhua.network.SSH2', true);

use net\mmanhua\network\SSH2;
use net\mmanhua\network\SSH2Exception;
use net\mmanhua\network\SSH2CommandException;
use net\mmanhua\network\SSH2IOException;

class ServerModel extends CActiveRecord {

    const ENV_PRO = 'pro';
    const ENV_PRE = 'pre';
    const STATUS_IS_ONLINE = 1;
    const STATUS_IS_OFF = 0;

    /**
     * 
     * @param type $className
     * @return ServerModel
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'd_server';
    }

    public function rules() {
        return array(
            array('ip,username,password,php_path,nginx_path,web_username', 'required'),
            array('ip', '_validateIp'),
            array('php', '_validateServer'),
            array('status', '_validateStatus', 'on' => 'update')
        );
    }

    public function attributeLabels() {
        return array(
            'username' => '用户名',
            'password' => '密码',
            'php_path' => 'PHP路径',
            'nginx_path' => 'Nginx路径',
            'web_username' => 'nginx运行所属的用户',
        );
    }

    public function beforeSave() {
        return true;
    }

    public function afterSave() {
        $ssh2 = $this->getSSH2();
        $ssh2->exec('sudo ' . $this->nginx_path);
    }

    public function _validateIp() {
        if (!filter_var($this->ip, FILTER_VALIDATE_IP)) {
            $this->addError('ip', 'IP格式错误');
        } elseif ($this->isNewRecord && ServerModel::model()->exists('ip=:ip', array(':ip' => $this->ip))) {
            $this->addError('ip', '该服务器已经存在');
        } elseif (ServerModel::model()->exists('ip=:ip AND id != :id', array(':ip' => $this->ip, ':id' => $this->id))) {
            $this->addError('ip', '该服务器已经存在');
        }
    }

    public function _validateStatus() {
        
    }

    public function _validateServer() {
        if (!$this->hasErrors()) {
            try {
                $ssh2 = $this->getSSH2();

                $extensions = ServerHelper::getPhpExtensions($ssh2->exec("{$this->php_path} -m"));
                foreach (Yii::app()->params['php']['extensions'] as $val) {
                    if (!in_array($val, $extensions)) {
                        $this->addError('php_path', "PHP缺少扩展 $val");
                        return;
                    }
                }
                $checkNginx = $ssh2->exec("file {$this->nginx_path}");
                if (strpos($checkNginx, 'ERROR') !== false) {
                    $this->addError('nginx_path', 'nginx 路径错误');
                } elseif (!$ssh2->exec("grep \"{$this->web_username}\" /etc/passwd")) {
                    $this->addError('web_username', 'nginx所属的用户错误');
                } elseif (!$ssh2->exec('grep "redstar/\*.conf" ' . $this->getNginxConfDir() . '/nginx.conf')) {
                    $this->addError('nginx_path', 'nginx主配置文件有误<br/>必须包含：include redstar/*.conf');
                } elseif (!$this->hasErrors()) {
                    $ssh2->exec('[ ! -e /usr/bin/rsync ] && sudo yum install -y rsync');
                    $ssh2->exec('sudo mkdir -p ' . $this->getNginxConfRedStarDir());

                    $rsyncConf = Yii::app()->params['rsync']['config_file'];
                    $ssh2->exec("[ ! -e $rsyncConf ] && touch $rsyncConf");
                    $str = stream_get_contents($ssh2->open($rsyncConf, 'rb'));

                    $fp = $ssh2->open($rsyncConf, 'wb');
                    $data = empty($str) ? array() : parse_ini_string($str, true);
                    $data = array_merge(array(
                        'uid' => $this->web_username,
                        'gid' => $this->web_username,
                        'max connections' => 4,
                        'pid file' => Yii::app()->params['rsync']['pid'],
                        'lock file' => Yii::app()->params['rsync']['lock']
                        ), $data);

                    fwrite($fp, Utils::arrToIniString($data));
                    fclose($fp);
                }
            } catch (SSH2Exception $ex) {
                $this->addError('ip', $ex->getMessage());
            } catch (SSH2CommandException $ex) {
                $this->addError('php', $ex->getMessage());
            } catch (SSH2IOException $ex) {
                $this->addError('ip', $ex->getMessage());
            }
        }
    }

    /**
     * 获取可用的服务器列表，返回服务器ID和服务器地址的关联数组
     * 
     * @return array {array()}
     */
    public static function getAvailableServeies($project = null) {
        $criteria = new CDbCriteria(array(
            'condition' => 'is_deleted=0 AND status=:status' . ($project ? " AND id NOT IN (SELECT server_id FROM d_project_server WHERE project_id={$project->id})" : ''),
            'params' => array(':status' => self::STATUS_IS_ONLINE)
        ));

        $ret = self::model()->findAll($criteria);
        $list = array();
        foreach ($ret as $val) {
            $list[$val->id] = $val->ip;
        }

        return $list;
    }

    /**
     * 获取一个ssh连接对象，如果出错将抛出异常
     * 
     * @return \net\mmanhua\network\SSH2
     */
    public function getSSH2() {
        $ssh2 = new SSH2($this->ip);
        $ssh2->authPassword($this->username, ECommon::decrypt($this->password));

        return $ssh2;
    }

    public function getNginxConfDir() {
        return $this->getNginxDir() . '/conf';
    }

    public function getNginxConfRedStarDir() {
        return $this->getNginxConfDir() . '/redstar';
    }

    public function getNginxDir() {
        $info = pathinfo($this->nginx_path);
        $info = pathinfo($info['dirname']);

        return $info['dirname'];
    }

}
