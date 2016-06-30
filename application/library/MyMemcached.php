<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MyMemcached {

    private $memcached;

    /**
     * @param string $host
     * @param int $post
     */
    public function __construct() {
        return $this->memcached = Yaf_Registry::get('memcached');
    }
 
    public function set($key, $value, $timeOut=0){
        if(is_array($key)){
            //$key 为array
            //$value 为tag
            return $this->memcached->setMulti($key,$value);
        }
        return $this->memcached->set($key, $value, $timeOut);
    }
    
    public function add($key, $value, $timeOut=0){
        return $this->memcached->add($key, $value, $timeOut);
    }
    
     public function get($key,$value = ''){
          if(is_array($key)){
            //$key 为array
            //$value 为tag
            return $this->memcached->getMulti($key,$value);
        }
        return $this->memcached->get($key);
    }
//    public function 
}
