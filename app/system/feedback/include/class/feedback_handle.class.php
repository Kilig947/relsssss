<?php
#

defined('IN_MET') or exit('No permission');

load::mod_class('message/message_handle');

/**
 * 反馈处理类
 */

class feedback_handle extends message_handle {

	/**
	 * 处理反馈列表字段
	 * @param  string  $feedback_list 反馈列表数组
	 * @return array                 处理过后的反馈列表
	 */
	public function para_handle($feedback_list){
		global $_M;
		foreach ($feedback_list as $key => $val) {
			$feedback_list[$key] = $this->one_para_handle($val);
		}
		return $feedback_list;
  }

	/**
	 * 处理设置字段
	 * @param  string  $feedback 设置数组
	 * @return array           处理过后的栏目图片数组
	 */
	public function one_para_handle($feedback) {
		global $_M;
		return $feedback;
	}

	/**
	 * 处理设置字段
	 * @param  string  $id     反馈栏目id
	 * @return array           提交表单地址
	 */
	public function module_form_url($id) {
		global $_M;
		$column = load::sys_class('label', 'new')->get('column')->get_column_id($id);
		return $this->url_transform($column['foldername'].'/index.php?action=add&lang='.$column['lang']);
	}

	public function get_feedback_config($id){
        global $_M;
        $message=load::mod_class('message/message_database','new')->get_config_by_id($id);
        foreach ($message as $key => $value) {
        	$messagecfg[$value[name]]=$value;
        }
        return $messagecfg;
	}
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://#). All rights reserved.
?>
