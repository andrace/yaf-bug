<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Db {

    private $config; //配置
    public $connect = false; //连接
    private $sql;  //sql语句
    private $table; //表
    private $setwhere;
    private $where; //条件
    private $setLimit;
    private $limit; //limit
    private $add_column; //添加的字段值
    private $add_value;  //添加的字段名
    private $update_column;
    private $column = '*'; //select x
    private $action; //方法类型
    private $setOrder;
    private $order;  //排序
    private $protected;  //受保护的字段
    private $insert;

    public function __construct($connect) {
        $this->connect = $connect;
    }

    protected function sqlAction() {
        switch ($this->action) {
            case 'find' :
                $this->sql = 'select ' . $this->column . ' from ' . $this->table . $this->setwhere . $this->where . $this->setOrder . $this->order;
                break;
            case 'get':
                $this->sql = 'select ' . $this->column . ' from ' . $this->table . $this->setwhere . $this->where . $this->setOrder . $this->order . $this->setLimit . $this->limit;
                break;
            case 'add':
                $this->sql = 'insert into ' . $this->table . '(' . $this->add_column . ') value ' . $this->add_value;
                break;
            case 'update':
                $this->sql = 'update ' . $this->table . ' set ' . $this->update_column . ' where ' . $this->where;
                break;
            case 'del':
                $this->sql = 'delete from ';
                break;
        }
    }

    public function useTable($table) {
        $this->table = $table;
    }

    private function execSql() {
        return $this->connect->query($this->sql);
    }

    public function column($array = '*') {
        if ('*' == $array) {
            $this->column = '*';
        } else {
            foreach ($array as $v) {
                $this->column .= $v . ',';
            }
            $this->column = rtrim($this->column, ',');
        }
        return $this;
    }

    public function find($id) {
        $this->action = 'find';
        $this->where = 'id = ' . $id;
        $this->sqlAction();
        $result = $this->execsql()->fetch_assoc();
        $this->resetThis();
        return $result;
    }

    public function get() {
        $this->action = 'get';
        $this->sqlAction();
        $result = $this->execsql()->fetch_all(MYSQLI_ASSOC);
        $this->resetThis();
        return $result;
    }

    public function add(array $arrData) {
        $this->add_column = $this->add_value = '';
        $flag = $flagV = 1;
        $true = is_array(current($arrData)); //判断是否一次插入多条数据
        if ($true) {
            //构建插入多条数据的sql语句
            foreach ($arrData as $arr) {
                $this->add_value .= $flag ? '(' : ',(';
                foreach ($arr as $key => $value) {
                    if ($flagV) {
                        if ($flag)
                            $this->add_column .= "$key";
                        $this->add_value .= "'$value'";
                        $flagV = 0;
                    } else {
                        if ($flag)
                            $this->add_column .= ",$key";
                        $this->add_value .= ",'$value'";
                    }
                }
                $this->add_value .= ') ';
                $flag = 0;
                $flagV = 1;
            }
        } else {
            //构建插入单条数据的sql语句
            $this->insert = $arrData;
            foreach ($arrData as $key => $value) {
                if ($flagV) {
                    $this->add_column = "$key";
                    $this->add_value = "('$value'";
                    $flagV = 0;
                } else {
                    $this->add_column .= ",$key";
                    $this->add_value .= ",'$value'";
                }
            }
            $this->add_value .= ") ";
            $insert = $arrData;
        }
        $this->action = 'add';
        $this->sqlAction();
        $this->execsql();
        $this->resetThis();
        if (!$true) {
            return $insert = array_merge(['id' => mysqli_insert_id($this->connect)], $insert);
        }
        return true;
    }

    public function update(array $array) {
        $this->action = 'update';
        foreach ($array as $k => $v) {
            $this->update_column .= $k . '=' . $v . ',';
        }
        $this->update_column = rtrim($this->update_column, ',');
    }

    public function del() {
        $this->action = 'del';
    }

    public function where(array $array) {
        $this->setwhere = ' where ';
        if ($this->where) {
            $this->where .= ' and ';
        }
        foreach ($array as $v) {
            if (is_array(current($array))) {
                foreach ($v as $sep_option) {
                    $this->where .= $sep_option . ' ';
                }
                $this->where .= ' and ';
            } else {
                $this->where .= $v . ' ';
            }
        }
        $this->where = rtrim($this->where, 'and ');
        return $this;
    }

    public function whereIn($array) {
        
    }

    public function order(array $array = []) {
        $this->setOrder = ' order by ';
        foreach ($array as $v) {
            if (is_array(current($array))) {
                foreach ($v as $sep_option) {
                    $this->order .= $sep_option . ' ';
                }
                $this->order .= ' ';
            } else {
                $this->order .= $v . ' ';
            }
        }
         return $this;
    }

    public function limit($want = 1, $begin = 0) {
        $this->setLimit = ' limit ';
        $this->limit = $begin . ',' . $want;
         return $this;
    }

    public function sepWhere($array) {
        
    }

    private function returnInfo($type) {
        
    }

    private function resetThis() {
        $this->sql = '';  //sql语句
        $this->where = ''; //条件
        $this->limit_begin = 0; //limit begin
        $this->limit = 1; //limit
        $this->add_column = ''; //添加的字段值
        $this->add_value = '';  //添加的字段名
        $this->update_column = '';
        $this->column = ''; //select x
        $this->action = ''; //方法类型
        $this->order = '';  //排序
        $this->protected = '';  //受保护的字段
        $this->insert = '';
        $this->setwhere = '';
        $this->setLimit = '';
        $this->setOrder = '';
    }

}
