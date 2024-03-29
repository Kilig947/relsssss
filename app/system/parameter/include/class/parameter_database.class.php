<?php
#

defined('IN_MET') or exit('No permission');

load::sys_class('database');

/**
 * 字段数据库类
 */

class  parameter_database extends database{

	/**
		* 初始化
		*/
	public function __construct() {
		global $_M;
		$this->construct($_M['table']['parameter']);
	}

	//获取list存放的表
	public function get_plist_table($module){
		global $_M;
		switch ($module) {
			case 7:
			$table = $_M['table']['mlist'];
			break;
			default:
			$table = $_M['table']['plist'];
			break;
		}
		return $table;
	}

	/**
	 * 获取字段
	 * @param  string  $lang    语言
	 * @param  string  $module  模块（3:产品|4:下载|5:图片|6:简历|7:留言|8:反馈|10:会员）
	 * @param  string  $class1  一级栏目
	 * @return array            字段数组
	 */
	public function get_list($id, $module){
		global $_M;
		$table = $this->get_plist_table($module);
		$query = "SELECT * FROM {$table} WHERE listid = '{$id}' AND module = '{$module}'";
		$list = DB::get_all($query);
		foreach ($list as $key => $val) {
			$relist[$val['paraid']] = $val;
		}
		return $relist;
	}

	/**
	 * 写入字段
	 * @param  string  $lang    语言
	 * @param  string  $module  模块（3:产品|4:下载|5:图片|6:简历|7:留言|8:反馈|10:会员）
	 * @param  string  $class1  一级栏目
	 * @return array            字段数组
	 */
	public function insert_list($listid, $paraid, $info, $imgname, $lang, $module){
		global $_M;
		$para_list = load::mod_class('parameter/parameter_list_database', 'new');
		$para_list->construct($module);
		$array['listid'] = $listid;
		$array['paraid'] = $paraid;
		$array['info'] = $info;

		$array['lang'] = $lang;
		$array['module'] = $module;
		if($module!=8){
           $array['imgname'] = $imgname;
		}
		return $para_list->insert($array);
	}

		/**
	 * 写入字段
	 * @param  string  $lang    语言
	 * @param  string  $module  模块（3:产品|4:下载|5:图片|6:简历|7:留言|8:反馈|10:会员）
	 * @param  string  $class1  一级栏目
	 * @return array            字段数组
	 */
	public function add_list($listid, $paraid, $info, $imgname, $module){
		global $_M;
		$para_list = load::mod_class('parameter/parameter_list_database', 'new');
		$para_list->construct($module);
		return $para_list->add_para_value($listid, $paraid, $info, $imgname);
	}
	/**
	 * 写入字段
	 * @param  string  $lang    语言
	 * @param  string  $module  模块（3:产品|4:下载|5:图片|6:简历|7:留言|8:反馈|10:会员）
	 * @param  string  $class1  一级栏目
	 * @return array            字段数组
	 */
	public function update_list($listid, $paraid, $info, $imgname, $module){
		global $_M;
		$para_list = load::mod_class('parameter/parameter_list_database', 'new');
		$para_list->construct($module);
		return $para_list->update_by_listid_paraid($listid, $paraid, $info, $imgname);
	}

	/**
	 * 写入字段
	 * @param  string  $lang    语言
	 * @param  string  $module  模块（3:产品|4:下载|5:图片|6:简历|7:留言|8:反馈|10:会员）
	 * @param  string  $class1  一级栏目
	 * @return array            字段数组
	 */
	public function del_list($listid, $module){
		global $_M;
		$para_list = load::mod_class('parameter/parameter_list_database', 'new');
		$para_list->construct($module);
		return $para_list->del_by_listid($listid);
	}

	public function delete_list($listid,$paraid,$module)
	{
		$para_list = load::mod_class('parameter/parameter_list_database', 'new');
		$para_list->construct($module);
		return $para_list->delete_list_value($listid,$paraid);
	}

	/**
	 * 获取字段
	 * @param  string  $lang    语言
	 * @param  string  $module  模块（3:产品|4:下载|5:图片|6:简历|7:留言|8:反馈|10:会员）
	 * @param  string  $class1  一级栏目
	 * @param  string  $class2  二级栏目
	 * @param  string  $class3  三级栏目
	 * @return array            字段数组
	 */
	public function get_parameter($module , $class1 = '' , $class2 = '' , $class3 = '' ){
		global $_M;
		$where = "WHERE {$this->langsql} AND (( module = '$module' AND class1 = 0) OR ( module = '$module'";
		if($class1){
			$where .=" AND class1 = '$class1' ";
		}
		if($class2){
			$where .=" AND class2 = '$class2' ";
		}
		if($class3){
			$where .=" AND class3 = '$class3' ";
		}
		$where .= " ) )";
		$query = "SELECT * FROM {$_M['table']['parameter']} {$where} ORDER BY no_order ASC, id DESC ";
		$paras = DB::get_all($query);

		return $paras;
	}

	//获取栏目下面的内容,返回内容不包含下级栏目内容
	public function get_list_by_class_no_next($id) {
		global $_M;
		if(is_numeric($id)){
			$class123 = load::sys_class('label', 'new')->get('column')->get_class123_no_reclass($id);
			$module = $class123['class1']['module'];
		}else{
			$module = load::sys_class('handle', 'new')->file_to_mod($id);
		}
		$sql = " {$this->langsql} AND module = '{$module}' ";

		if ($class123['class1']['id']) {
			if($module == 7 ){
				$sql .= " AND (class1 = '{$class123['class1']['id']}' OR class1 = 0)";
			}else{
				$sql .= " AND class1 = '{$class123['class1']['id']}' ";
			}
		} else {
			$sql .= " AND ( class1 = '' OR class1 = '0' ) ";
		}

		if ($class123['class2']['id']) {
			$sql .= " AND class2 = '{$class123['class2']['id']}' ";
		} else {
			$sql .= " AND ( class2 = '' OR class2 = '0' ) ";
		}

		if ($class123['class3']['id']) {
			$sql .= " AND class3 = '{$class123['class3']['id']}' ";
		} else {
			$sql .= " AND ( class3 = '' OR class3 = '0' ) ";
		}

		$query = "SELECT * FROM {$_M['table']['parameter']} WHERE $sql ";
		return DB::get_all(	$query);
	}

	/**
	 * 获取字段的选项列表
	 * @param  string  $paraid  字段id
	 * @return array            字段选项数组
	 */
	public function get_parameter_list($paraid) {
		global $_M;
		$query = "SELECT * FROM {$_M['table']['list']} WHERE bigid='{$paraid}' ORDER BY no_order ASC";
		return DB::get_all($query);
	}

	public function table_para(){
		return 'id|name|options|description|no_order|type|access|wr_ok|class1|class2|class3|module|lang|wr_oks|related';
	}

	public function add_parameter($option)
	{
		global $_M;

		$query = "SELECT * FROM {$_M['table']['para']} WHERE pid = {$option['pid']} AND value='{$option['value']}' AND module = {$option['module']} AND lang = '{$_M['lang']}'";
		$para = DB::get_one($query);
		if($para){
			return false;
		}

		$query = "INSERT INTO {$_M['table']['para']} SET pid = {$option['pid']},module={$option['module']},value='{$option['value']}',lang='{$_M['lang']}'";
		$row = DB::query($query);
		if(!$row){
			return false;
		}
		return DB::insert_id();
	}

	public function get_parameters($module,$pid)
	{
		global $_M;
		$query = "SELECT * FROM {$_M['table']['para']} WHERE pid = {$pid} AND module = {$module} AND lang = '{$_M['lang']}' ORDER BY `order` ASC";
		return DB::get_all($query);
	}

	public function get_parameter_value($module, $listid, $paraid){
		global $_M;
		$query = "SELECT * FROM {$_M['table']['plist']} WHERE listid = '{$listid}' AND module = '{$module}' AND paraid = '{$paraid}' AND lang = '{$_M['lang']}'";
		$list = DB::get_all($query);
		return $list;
	}


	public function get_para_value($paraid,$info)
	{
		$type = self::get_parameter_type($paraid);
		if($type == 2 || $type == 4 || $type == 6){
			return self::get_parameter_value_by_id($info);
		}else{
			return $info;
		}
	}

	public function get_parameter_type($id)
	{
		global $_M;
		$query = "SELECT type FROM {$_M['table']['parameter']} WHERE id = {$id}";
		$parameter = DB::get_one($query);
		return $parameter['type'];
	}

	public function get_parameter_value_by_id($id)
	{
		global $_M;
		$query = "SELECT value FROM {$_M['table']['para']} WHERE id = {$id}";
		$para = DB::get_one($query);
		return $para['value'];
	}

	public function update_para_value($option)
	{
		global $_M;

		$query = "UPDATE {$_M['table']['para']} SET value = '{$option['value']}',`order`='{$option['order']}' WHERE id = {$option['id']}";
		$row = DB::query($query);
		return $row;
	}

	public function add_para_value($option)
	{
		global $_M;
		$query = "INSERT INTO {$_M['table']['para']} SET pid = {$option['pid']},module = '{$option['module']}',`order`='{$option['order']}',value='{$option['value']}',lang='{$_M['lang']}'";
		$res = DB::query($query);

		if($res){
			return DB::insert_id();
		}

		return false;
	}

	public function delete_para_value($pid,$pids=array())
	{
		global $_M;
		if(!empty($pids)){
			$paraid = implode(',', $pids);
			$query = "DELETE FROM {$_M['table']['para']} WHERE id NOT IN ($paraid) AND pid = {$pid}";
			return DB::query($query);
		}else{
			$query = "DELETE FROM {$_M['table']['para']} WHERE pid = {$pid}";
			return DB::query($query);
		}

	}
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://#). All rights reserved.
?>
