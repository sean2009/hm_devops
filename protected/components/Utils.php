<?php

class Utils {

    /**
     * 
     * @param string $dir
     * @param callable $filterCallBack
     * @return array
     */
    public static function listFiles($dir, $filterCallBack = null) {
        $dir = realpath($dir);
        $list = array();
        if (is_dir($dir)) {
            $fp = opendir($dir);
            while (($file = readdir($fp)) !== false) {
                if ($file != '.' && $file != '..' && $file != '.svn') {
                    $file = $dir . '/' . $file;
                    $filter = is_null($filterCallBack) ? true : call_user_func($filterCallBack, $file);
                    if (is_dir($file)) {
                        $list = array_merge($list, self::listFiles($file));
                    } else {
                        $list[] = $file;
                    }
                }
            }
            closedir($fp);
        }
        return $list;
    }

    /**
     * 根据项目的框架生成同步要排除的项
     * 
     * @param string $framework 项目使用的框架
     */
    public static function getRsyncExcludes($framework) {
        $excludes = array('--exclude=.svn');
//        if (isset(Yii::app()->params['exclude'][$framework])) {
//            foreach (Yii::app()->params['exclude'][$framework] as $val) {
//                $excludes[] = "--exclude=$val";
//            }
//        }
        return implode(' ', $excludes);
    }

    public static function arrToIniString($data) {
        $str = '';
        foreach ($data as $key => $val) {
            if (!is_array($val)) {
                $str .= $key . (empty($val) ? '' : " = $val") . "\n";
            } else {
                $str .= "[$key]\n" . self::arrToIniString($val) . "\n";
            }
        }
        return $str;
    }

    /**
     * 获取一个空目录
     * 
     * @return string
     */
    public static function getEmptyDir() {
        $emptyDir = sys_get_temp_dir() . '/deploy_empty_' . md5(__FILE__);
        if (!is_dir($emptyDir)) {
            mkdir($emptyDir);
        }
        return $emptyDir;
    }
    
    /**
     * 同步文件
     * 
     * @param ProjectModel $project 项目对象
     * @param ServerModel $server 服务器对象
     * @param boolean $rsyncConfig 是否包含配置文件
     * @param boolean $isInit 是否是初始化操作
     */
    public static function rsync($project, $server, $rsyncConfig = false, $isInit = false) {
        $ret = array();
        $rootPath = $isInit ? $project->getRootPath() : $project->getTmpDeployDir();
        $remote = " rsync://{$server->ip}/{$project->code}";
        exec("rsync -qrtz --ignore-errors " . Utils::getRsyncExcludes($project->framework) . " $rootPath/ $remote", $output, $returnVar);
        
        $ret['success'] = !$returnVar;
        $ret['msg'] = implode('', $output);
        
        if ($ret['success'] && $rsyncConfig && $project->config_svn_path) {
            $svn = new ESvn();
            $svn->update($project->getConfigPath());
            exec('rsync -qrtz --ignore-errors ' . $project->getConfigPath() . "/ $remote", $output, $returnVar);
        }
        
        return $ret;
    }

}
