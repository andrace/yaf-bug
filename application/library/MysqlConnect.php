<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class MysqlConnect {

    public $connect;
    private $config;

    public function __construct($config) {
        $this->config = $config;
        
        $this->connect = new mysqli($this->config->host,$this->config->username,$this->config->password,$this->config->database);  
    }

    public function init() {
        return $this->connect;
        
    }

}
