<?php

class ESvn {

    private $_baseDir;

    public function __construct() {
        svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_USERNAME, Yii::app()->params['svn']['username']);
        svn_auth_set_parameter(SVN_AUTH_PARAM_DEFAULT_PASSWORD, Yii::app()->params['svn']['password']);
        $this->_baseDir = Yii::app()->params['deploy_base_dir'];
    }

    public function checkOut($repos, $targetPath, $revision = 0) {
        $ret = @svn_checkout($repos, $targetPath, $revision);
        if (!$ret) {
            exec("rm -rf $targetPath");
        }

        return $ret;
    }

    public function log($url, $startRevision = 0, $endRevision = 0, $limit = 0) {
        return svn_log($url, $startRevision, $endRevision, $limit, SVN_DISCOVER_CHANGED_PATHS);
    }

    public function update($path) {
        return svn_update($path);
    }

    public function export($svnPath, $fromPath, $toPath, $workingCopy = true, $revision = null) {
        $filelist = array();
        $revision = !is_array($revision) ? array($revision) : $revision;
        sort($revision);
        $sub = substr($svnPath, strrpos($svnPath, '/') + 1);

        foreach ($revision as $v) {
            $log = $this->log($svnPath, $v, $v);
            if (!empty($log)) {
                foreach ($log[0]['paths'] as $s_v) {
                    $s_v['path'] = substr($s_v['path'], strpos($s_v['path'], $sub) + strlen($sub));
                    if (is_file($fromPath . $s_v['path'])) {
                        $filelist[$s_v['path']] = $log[0]['rev'];
                    }
                }
            }
        }
        foreach ($filelist as $file => $v) {
            $sFile = $fromPath . '/' . $file;
            $tFile = $toPath . '/' . $file;
            $pathInfo = pathinfo($tFile);
            if (!is_dir($pathInfo['dirname'])) {
                mkdir($pathInfo['dirname'], 0777, true);
            }
            svn_export($sFile, $tFile, false, $v);
        }
        
        return true;
    }

    /**
     * 对多维数组进行搜索 
     * 
     * @author wengxianhu 
     * @date 2013-08-05 
     * @param array $parents 被搜索数组 
     * @param array $searched 搜索数组 
     * @return boolean 
     */
    private function multidimensional_search($parents = array(), $searched = array()) {
        if (empty($searched) || empty($parents)) {
            return false;
        }

        foreach ($parents as $key => $value) {
            $exists = true;
            foreach ($searched as $skey => $svalue) {
                $exists = ($exists && IsSet($parents[$key][$skey]) && $parents[$key][$skey] == $svalue);
            }
            if ($exists) {
                return $key;
            }
        }

        return false;
    }

}
