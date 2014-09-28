<?php

class BatchModel extends CActiveRecord {
    
    const STATUS_NO_START = 0;
    const STATUS_IS_OK = 1;
    const STATUS_FAILED = 2;
    
    /**
     * 
     * @param type $className
     * @return BatchModel
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'd_batch';
    }
    
    public function beforeSave() {
        $this->dateline = time();
        
        return true;
    }
    
    public function relations() {
        return array(
            'project' => array(self::BELONGS_TO, 'ProjectModel', 'project_id'),
            'servers' => array(self::MANY_MANY, 'ServerModel', 'd_batch_server(batch_id,server_id)'),
            'batchServers' => array(self::HAS_MANY, 'BatchServerModel', 'batch_id')
        );
    }
}
