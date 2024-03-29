<?php
#

defined('IN_MET') or exit('No permission');

load::mod_class('message/message_label');

/**
 * 反馈标签类
 */

class feedback_label extends message_label{

	public $lang;//语言

	/**
	 * 初始化
	 */
	public function __construct() {
		global $_M;
		$this->lang = $_M['lang'];
	}

	/**
	 * 获取简历字段表单数据
	 * @param  number  $id   反馈栏目id
	 * @return array         简历表单数组
	 */
	public function get_module_form($id){
		global $_M;
		$return['para'] = load::mod_class('parameter/parameter_label', 'new')->get_parameter_form('feedback',$id);
		$return['config']['url'] = load::mod_class('feedback/feedback_handle', 'new')->module_form_url($id);
		$return['config']['lang']['submit'] = $_M['word']['submit'];
		$return['config']['lang']['title'] = '';
		return $return;
  }

	public function get_module_form_html($id,$fdtitle='') {
		global $_M;
		$feedback = $this->get_module_form($id);

		if($_M['form']['fdtitle']){
			$fdtitle = $_M['form']['fdtitle'];
		}

		if($_M['form']['lang']){
			$this->lang = $_M['form']['lang'];
		}

		$referer = HTTP_REFERER;
$str .= <<<EOT
		<form method='POST' class="met-form met-form-validation" enctype="multipart/form-data" action='{$feedback['config']['url']}'>
		<input type='hidden' name='id' value="{$id}" />
		<input type='hidden' name='lang' value="{$this->lang}" />
		<input type='hidden' name='fdtitle' value='{$fdtitle}' />
		<input type='hidden' name='referer' value='{$referer}' />
EOT;
		foreach($feedback['para'] as $key => $val){
$str .= <<<EOT
		{$val['type_html']}

EOT;
		}
$str .= <<<EOT
			<div class="form-group m-b-0">
				<button type="submit" class="btn btn-primary btn-lg btn-block btn-squared">{$feedback['config']['lang']['submit']}</button>
			</div>
		</form>
EOT;
		return $str;
	}


	/**
	 * 获取单条news
	 * @param  string  $id      内容id
	 * @return array        		一个列表页面数组
	 */
	public function insert_feedback($id, $paras, $fdtitle, $customerid = '', $fromurl = '',$addtime, $ip = '') {
		global $_M;
		if(!$id){
			return false;
		}
		$data['class1'] = $id;
		$data['fdtitle'] = $fdtitle;
		$data['fromurl'] = $fromurl ? $fromurl : HTTP_REFERER;
		$data['ip'] = $ip ? $ip : IP;
		$data['customerid'] = $customerid;
        $data['lang']=$paras['lang'];
        $data['addtime']=$addtime ? $addtime : date('Y-m-d H:i:s',time());
		$fid = load::mod_class('feedback/feedback_database', 'new')->insert($data);
		if($fid){
			if(load::mod_class('parameter/parameter_label', 'new')->insert_list($fid, 'feedback', $paras)){
                return true;
			}

		}
	}

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://#). All rights reserved.
?>
