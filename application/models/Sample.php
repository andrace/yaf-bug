<?php

/**
 * @name SampleModel
 * @desc sample数据获取类, 可以访问数据库，文件，其它系统等
 * @author root
 */
class SampleModel {

    public $connect;
    public $db;
    
    public function __construct() {
        $this->connect =Yaf_Registry::get('connect');
        $this->db = new Db($this->connect);
        
    }

    public function selectSample() {
        $this->db->usetable('users');
//        $this->db->where(['id','>','1']);
//        $this->db->order(['id','desc']);
//        $result = $this->db->find(2);
        $result = $this->db->add(
                    ['name'=>'22222','hah'=>'111','xxx'=>'xxx']
                );
        var_dump($result);
        return $result;  
        
      
    }

    public function insertSample($arrInfo) {
        return true;
    }

}
