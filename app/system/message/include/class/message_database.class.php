<?php
#

defined('IN_MET') or exit('No permission');

load::mod_class('news/news_database');

/**
 * 留言数据类
 */

class  message_database extends news_database{

	/**
	 * 初始化，继承类需要调用
	 */
	public function __construct() {
		global $_M;
		$this->construct($_M['table']['message']);
	}

	public function get_list_by_class_sql($id, $type = 'all') {
		$confival=$this->get_config_val('met_fd_type',7);
		if($confival){
           $sql .= " {$this->langsql} and checkok = 1";
		}else{
		   $sql .= " {$this->langsql}";
		}
		$sql .= " ORDER BY addtime DESC, id DESC ";
		return $sql;
	}

	/**
	 * 获取留言字段
	 * @param  string  $id      留言栏目id
	 * @return array            留言字段数组
	 */
	public function get_module_para() {
		return load::mod_class('parameter/parameter_database', 'new')->get_parameter($this->mod);
	}

	public function table_para(){
        return 'id|addtime|useinfo|access|customerid|lang|ip|imgname|checkok';
    }

    public function get_config_val($name,$module){
    	global $_M;
      $query= "select * from {$_M[table][column]} where module = '$module' and lang='{$_M[lang]}'";
      $message=DB::get_one($query);
      $query= "select * from {$_M[table][config]} where name = '$name' and columnid ='$message[id]' and lang='{$_M[lang]}'";
      $config=DB::get_one($query);
      return $config[value];
    }

    public function get_fd_value($name,$columnid)
    {
    	global $_M;
        $query= "select value from {$_M['table']['config']} where name = '$name' and columnid ='$columnid' and lang='{$_M[lang]}'";
        $config = DB::get_one($query);
        return $config['value'];
    }

    function update_fd_content($list){
    	global $_M;
    	$query="update {$_M[table][mlist]} set info ='$list[fd_content]' where lang='{$_M[lang]}' and listid= '{$list[id]}' and paraid='{$_M[config][met_message_fd_content]}'";
        DB::query($query);
    }

    public function del_mlist($id){
      global $_M;
      $query= "delete from {$_M[table][mlist]} where listid='$id'";
       return DB::query($query);
    } 

    function get_config_by_id($id){
       global $_M;
       $query="select * from {$_M[table][config]} WHERE lang='{$_M[lang]}' AND columnid ='$id'";
        return DB::get_all($query);
    }

    function get_message_columnid(){
      global $_M;
      $message=DB::get_one("select * from {$_M[table][column]} where module= 7 and lang ='{$_M[lang]}'");
      return $message[id];
    }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://#). All rights reserved.
?>
