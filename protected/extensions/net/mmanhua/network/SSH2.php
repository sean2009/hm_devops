<?php

namespace net\mmanhua\network;

class SSH2 {
    
    private $conn;
    
    /**
     * 初始化一个ssh2对象，如果链接不是服务器或者没有ssh2扩展没有安装，将抛出一个异常
     * 
     * @param string $host
     * @param int $port
     * @throws SSH2Exception
     */
    public function __construct($host, $port = 22) {
        if (!function_exists('ssh2_connect')) {
            throw new SSH2Exception("ssh2 extension not exists");
        }
        
        $this->conn = @ssh2_connect($host, $port);
        if (!$this->conn) {
            throw new SSH2Exception("can't connect to $host");
        }
    }
    
    public function authPassword($username, $password) {
        if (!ssh2_auth_password($this->conn, $username, $password)) {
            throw new SSH2Exception("SSH2 Authentication Failed");
        }
    }
    
    public function exec($cmd) {
        $stream = ssh2_exec($this->conn, $cmd, 'vt102');
        $errStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
        stream_set_blocking($stream, true);
        stream_set_blocking($errStream, true);
        
        $data = stream_get_contents($stream);
        $errData = stream_get_contents($errStream);
        
        fclose($stream);
        fclose($errStream);
        if (!empty($errData) && empty($data)) {
            throw new SSH2CommandException($errData);
        }
        
        return $data;
    }
    
    /**
     * 将一个本地文件句柄流上传到远程，出错时抛出异常
     * 
     * @param resource $srcStream
     * @param string $remoteFile
     * @return boolean
     * @throws SSH2IOException
     */
    public function scp($srcStream, $remoteFile) {
        $fp = $this->open($remoteFile, 'wb');
        rewind($srcStream);
        while (!feof($srcStream)) {
            fwrite($fp, fread($srcStream, 1024));
        }
        rewind($srcStream);
        fclose($fp);
        
        return true;
    }
    
    public function unlink($file) {
        return ssh2_sftp_unlink($this->getSftp(), $file);
    }
    
    /**
     * 打开一个文件，当文件不存在或者，没有权限时候，抛出异常，成功的时候返回一个文件句柄
     * 
     * @param string $file
     * @param string $mode
     * @return resource
     * @throws SSH2IOException
     */
    public function open($file, $mode = 'rb') {
        $fp = @fopen('ssh2.sftp://' . $this->getSftp() . $file, $mode);
        if (!$fp) {
            throw new SSH2IOException("$file not exists");
        }
        return $fp;
    }
    
    private function getSftp() {
        static $sftp = null;
        if (!$sftp) {
            $sftp = ssh2_sftp($this->conn);
        }
        return $sftp;
    }
    
}

class SSH2Exception extends \Exception {
    
}

class SSH2CommandException extends \Exception {
    
}

class SSH2IOException extends \Exception {
    
}