<?php

class BatchServerModel extends CActiveRecord {
    
    const STATUS_NO_START = 0;
    const STATUS_IS_OK = 1;
    const STATUS_FAILED = 2;
    
    /**
     * 
     * @param type $className
     * @return BatchServerModel
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'd_batch_server';
    }
    
    public function relations() {
        return array(
            'server' => array(self::BELONGS_TO, 'ServerModel', 'server_id'),
            'batch' => array(self::BELONGS_TO, 'BatchModel', 'batch_id'),
        );
    }
    
}
