<?php

Yii::import('application.extensions.net.mmanhua.network.SSH2', true);

use net\mmanhua\network\SSH2;

class ServerHelper {

    public static function getPhpExtensions($data) {
        $startExt = false;
        $extensions = array();
        foreach (explode("\n", $data) as $line) {
            if (strpos($line, '[PHP Modules]') !== false) {
                $startExt = true;
                continue;
            } elseif (strpos($line, '[Zend Modules]') !== false) {
                break;
            }
            if ($startExt) {
                $ext = trim($line);
                if (!empty($ext)) {
                    $extensions[] = $ext;
                }
            }
        }
        return $extensions;
    }

    /**
     * 将这个项目的nginx配置上传到服务器
     * 
     * @param ProjectModel $project
     * @param ServerModel $server
     * @param \net\mmanhua\network\SSH2 $ssh2
     * @throws \net\mmanhua\network\SSH2Exception
     * @throws \net\mmanhua\network\SSH2IOException
     * @throws Exception
     */
    public static function updateNginxConf($project, $server, SSH2 $ssh2 = null) {
        if (!$ssh2) {
            $ssh2 = $server->getSSH2();
        }
        
        $file = tmpfile();
        fwrite($file, $project->nginx_conf);

        $nginxConf = $server->getNginxConfRedStarDir() . '/' . $project->getNginxConf();

        $ssh2->scp($file, $nginxConf);
        $str = $ssh2->exec('sudo ' . $server->nginx_path . ' -s reload');
        
        if (!empty($str)) {
            throw new Exception($str);
        }
    }
}
