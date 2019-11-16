<?php
#

defined('IN_MET') or exit('No permission');

load::mod_class('message/message_op');

/**
 * news标签类
 */

class job_op extends message_op {

	/**
		* 初始化
		*/
	public function __construct() {
		global $_M;
    $this->database = load::mod_class('job/job_database', 'new');
	}

  //删除
  public function del_by_class($classnow) {
    global $_M;
    //删除字段
    //删除简历
  }
  
	/*复制*/
	public function list_copy($classnow, $toclass1, $toclass2, $toclass3, $tolang){
		global $_M;

    $c = load::sys_class('label', 'new')->get('column')->get_column_id($classnow);
    $this->database->set_lang($c['lang']);
		$contents = $this->database->get_list_by_class($classnow);
		foreach($contents as $list){
			$id = $list['id'];
			$list['id']       = '';
			$list['filename'] = '';
			$list['lang']     = $tolang ? $tolang : $list['lang'];	

			$id_array[$id] =  $this->database->insert($list);
		}
		return $id_array;
	}

	/*移动产品*/
	public function list_move($id,$class1,$class2,$class3){
    return true;
  }
  
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://#). All rights reserved.
?>
