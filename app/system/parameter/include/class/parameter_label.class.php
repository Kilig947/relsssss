<?php
#

defined('IN_MET') or exit('No permission');

/**
 * parameter标签类
 */

class parameter_label {

	public $lang;

	/**
		* 初始化
		*/
	public function __construct() {
		global $_M;
		$this->parameter_database = load::mod_class('parameter/parameter_database', 'new');
	}

	public function name_to_num($module) {
		switch ($module) {
			case 'product':
				$mod = 3;
			break;
			case 'download':
				$mod = 4;
			break;
			case 'img':
				$mod = 5;
			break;
			case 'message':
				$mod = 7;
			break;
			case 'job':
				$mod = 6;
			break;
			case 'feedback':
				$mod = 8;
			break;
		}
		return $mod;
	}

	public function get_para($module, $class1, $class2) {
		$mod = is_numeric($module) ? $module : $this->name_to_num($module);
		return load::mod_class('parameter/parameter_database', 'new')->get_parameter($mod, $class1,$class2);
	}
  /**
	 * 获取字段提交表单，前台留言，反馈，招聘模块使用
	 * @param  string  $module  表单模块类型(feedback, message, job)
	 * @param  number  $id      一级栏目
	 * @return array            表单数组
	 */
	public function get_parameter_form($module, $id) {
		global $_M;
		$mod = $this->name_to_num($module);
		$parameter_database = load::mod_class('parameter/parameter_database', 'new');
		$p = $parameter_database->get_parameter($mod, $id);

		foreach ($p as $key => $para) {
			$list = $parameter_database->get_parameters($mod,$para['id']);
			$p[$key]['para_list'] = $list;
			$values = array();
			if($para['type'] ==4 || $para['type'] ==2 || $para['type'] ==6){
				foreach ($list as $val) {
					$query = "SELECT * FROM {$_M['table']['plist']} WHERE listid = {$listid} AND paraid={$para['id']} AND module={$module} AND info = '{$val['id']}' AND lang = '{$_M['lang']}'";
					$para_value = DB::get_one($query);

					if($para_value){
						$values[] = $para_value['info'];
					}
				}
			}else{
				$query = "SELECT * FROM {$_M['table']['plist']} WHERE listid = {$listid} AND paraid={$para['id']} AND module={$module} AND lang = '{$_M['lang']}'";
				$para_value = DB::get_one($query);
				$values = $para_value['info'];
			}

			if(is_array($values)){
				$p[$key]['value'] = implode('|', $values);
			}else{
				$p[$key]['value'] = $values;
			}
		}


		foreach ($p as $val) {
			$power = load::sys_class('user', 'new')->check_power($val['access']);
			if($power > 0){
				$paras[] = $val;
			}
		}
		if($mod == '8'){
			$query = "SELECT * FROM {$_M['table']['list']} WHERE bigid='{$id}' AND no_order='99999' AND lang='{$_M['lang']}'";
			$metlistrele = DB::get_one($query);
			if($metlistrele['info']){
				$config = load::sys_class('label', 'new')->get('config')->get_column_config($id);
				foreach($paras as $key => $val){
					if($val['id'] == $config['met_fd_class']){
						$paras[$key]['productlist'] = $metlistrele['info'];
					}
				}
			}
		}
		$paras = load::mod_class('parameter/parameter_handle', 'new')->para_handle_formation($paras);
		return $paras;
  }

	/**
	 * 获取字段内容，前台产品，图片，下载模块使用
	 * @param  string  $module  表单模块类型(feedback, message, job)
	 * @param  number  $id      一级栏目
	 * @return array            表单数组
	 */
	public function get_parameter_contents($module, $id, $class1, $class2, $class3,$type=0) {
		global $_M;
		$mod = $this->name_to_num($module);
		$parameter_database = load::mod_class('parameter/parameter_database', 'new');
		$parameter = $parameter_database->get_parameter($mod);

		$list = $parameter_database->get_list($id, $mod);

		$userclass = load::sys_class('user', 'new');
		foreach ($parameter as $key => $val) {
			if($type){
				if($val['type'] != $type){
					continue;
				}
			}else{
				if($val['type'] == 10){
					continue;
				}
			}
			if (
				($val['class1'] == 0) ||
				($val['class1'] == $class1 && $val['class2'] == 0) ||
				($val['class1'] == $class1 && $val['class2'] == $class2 && $val['class3'] == 0) ||
				($val['class1'] == $class1 && $val['class2'] == $class2 && $val['class3'] == $class3)
			) {
				if($val['type'] == 5){
					$url = load::sys_class('handle', 'new')->url_transform($list[$val['id']]['info']);
					$value = "<a target='_blank' href='{$list[$val['id']]['info']}'>{$_M['word']['downloadtext1']}</a>";
				}else{
					if($val['type'] == 2 || $val['type'] == 4 || $val['type'] == 6){

						$value_list = $parameter_database->get_parameter_value($mod,$id,$val['id']);
						$value = "";
						foreach ($value_list as $v) {
							$para_value = $parameter_database->get_parameter_value_by_id($v['info']);
							if($para_value){
								$value .= ",".$para_value;
							}
						}
					}else{
						$value = $list[$val['id']]['info'];
					}
				}

				$value = trim($value,',');
				$pt['id'] =  $val['id'];
				$pt['name'] =  $val['name'];
				$pt['value'] =  $val['access'] ? $userclass->check_power_script($value, $val['access']) : $value;

				$relist[] = $pt;
			}
		}
		if($type){

			$inquiry = load::mod_class('config/config_database','new')->get_inquiry();
			if($inquiry){
				$column = load::mod_class('column/column_database','new')->get_column_by_id($inquiry);
				$feedback = array();
				if($_M['form']['id']){
					$product = load::mod_class('product/include/class/product_database','new')->get_list_one_by_id($_M['form']['id']);
					$product_title = urlencode($product['title']);
				}else{
					$product_title = "";
				}

				$feedback['id'] = 0;
				$feedback['name'] = $_M['word']['feedbackinquiry'];

				$feedback['value'] = $_M['url']['site']."{$column['foldername']}/index.php?fdtitle={$product_title}&lang={$_M['lang']}";

				$relist[] = $feedback;
			}
		}

		return $relist;
	}

	/**
	 * 获取字段内容，前台产品，图片，下载模块使用
	 * @param  string  $module  表单模块类型(feedback, message, job)
	 * @param  number  $id      一级栏目
	 * @return array            表单数组
	 */
	public function insert_list($listid, $module, $paras) {
		global $_M;
		$mod = $this->name_to_num($module);
		$list = array();
		foreach ($paras as $key => $val) {
			preg_match('/^para([0-9]+)/', $key, $out);
			if ($out[1]) {
				$list[$out[1]] .= $val.',';
			}
		}
		foreach ($list as $key => $val) {
			$val = trim($val, ',');
            $imgname=$key.'imgname';
			$paraid = load::mod_class('parameter/parameter_database', 'new')->insert_list($listid, $key, $val ,$paras[$imgname], $_M['form']['lang'], $mod);

		}
		return ture;
	}

	/**
	 * 获取字段搜索sql语句
	 * @param  string        $module  模块类型
	 * @param  string/array  $info    被搜索信息
	 * @return string                 sql语句
	 */
	public function get_search_list_sql($module, $precision, $info){
		global $_M;

		if(!is_array($info)){
			if($precision){
				$sql = "SELECT listid FROM {$_M['table']['plist']} WHERE info = '{$info}'";
			}else{
				$sql = "SELECT listid FROM {$_M['table']['plist']} WHERE info like '%{$info}%'";
			}
		}else{
			// $sql = "SELECT listid FROM {$_M['table']['plist']} WHERE 1=1 ";
			// foreach($info as $key => $val){
			// 	if($val['info']){
			// 		$sql .= " AND listid in (SELECT listid FROM {$_M['table']['plist']} WHERE paraid='{$val['id']}' AND info = '{$val['info']}')";
			// 	}
			// }
			// $sql = str_replace('WHERE 1=1 AND', 'WHERE', $sql);
			//
			$listid = $list =  array();
			$para_num = 0;
			foreach ($info as $key => $val) {
				if($val['info']){
					$query = "SELECT listid FROM {$_M['table']['plist']} WHERE paraid='{$val['id']}' AND info = '{$val['info']}'";

					$para_num++;
				}

				$res = DB::get_all($query);
				foreach ($res as $v) {
				 	array_push($listid, $v['listid']);
				}
			}

			if($para_num == 0){
				$query = "SELECT listid FROM {$_M['table']['plist']} WHERE paraid='{$val['id']}'";
				$res = DB::get_all($query);
				foreach ($res as $val) {
					$list[] = $val['listid'];
				}
			}else{
				$listid = array_count_values($listid);
				foreach ($listid as $key => $val) {
					if($val >= $para_num){
						$list[] = $key;
					}
				}
			}


			$list = implode(',', $list);
			return $list;
		}

		return $sql;
	}

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://#). All rights reserved.
?>
