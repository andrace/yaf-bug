<?php

/**
 * @name SampleModel
 * @desc sample数据获取类, 可以访问数据库，文件，其它系统等
 * @author root
 */
class SampleModel {

    public $connect;
    public $db;
    public $redis;

    public function __construct() {
        $this->connect = Yaf_Registry::get('connect');
        $this->redis = new MyRedis();
        $this->db = new Db($this->connect);
        $this->m = new MyMemcached();
    }

    public function selectSample() {
   //     $this->m->set('aaa', 'bbb', 300);
   //     echo $this->m->get('aaa');
//        $this->db->usetable('users'); 
//        $this->db->where(['id', '>', '1']);
//        $this->db->order(['id', 'desc']);
      //  $result = $this->db->usetable('users')->where(['id', '>', '1'])->order(['id', 'desc'])->get();
        //    $result =  $this->db->find(2);
      //  exit;
        $result = $this->db->usetable('users')->add(
                    ['name'=>'22222','hah'=>'111','xxx'=>'xxx']
                );
       // var_dump($result);
        return $result;  
    }

    public function insertSample($arrInfo) {
        return true;
    }

}
