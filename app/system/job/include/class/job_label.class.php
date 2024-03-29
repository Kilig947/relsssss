<?php
#

defined('IN_MET') or exit('No permission');

load::mod_class('message/message_label');

/**
 * 招聘标签类
 */

class job_label  extends message_label {

	/**
		* 初始化
		*/
	public function __construct() {
		global $_M;
		$this->construct('job', $_M['config']['met_job_list']);
	}

	/**
	 * 获取简历字段表单
	 * @return array         简历表单数组
	 */
	public function get_module_form($id){
		global $_M;
		$return['para'] = load::mod_class('parameter/parameter_label', 'new')->get_parameter_form('job', $id);
		$return['config']['url'] = load::mod_class('job/job_handle', 'new')->module_form_url($id);
		$return['config']['lang']['submit'] = $_M['word']['submit'];
		$return['config']['lang']['cvtitle'] = $_M['word']['cvtitle'];
		$return['config']['lang']['cancel'] = $_M['word']['cancel'];
		$return['config']['lang']['title'] = '';
		return $return;
  }

	/**
	 * 获取简历字段表单
	 * @return array         简历表单数组
	 */
	public function get_module_form_html($id){
		global $_M;
		$job = $this->get_module_form($id);
$str .= <<<EOT
		<form method='POST' class="met-form met-form-validation"  enctype="multipart/form-data" action='{$job['config']['url']}'>
		<input type="hidden" name="lang" value="{$_M[lang]}">
		<input type="hidden" name="jobid" value="{$id}">
EOT;
		foreach($job['para'] as $key => $val){
$str .= <<<EOT
		{$val['type_html']}

EOT;
		}
$str .= <<<EOT
		<div class="form-group m-b-0">
		    <button type="submit" class="btn btn-primary btn-squared">{$job['config']['lang']['submit']}</button>
		    <button type="button" class="btn btn-default btn-squared m-l-5" data-dismiss="modal">{$job['config']['lang']['cancel']}</button>
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
	public function insert_cv($jobid, $paras, $customerid = '',$ip = '') {
		global $_M;
		if(!$jobid){
			return false;
		}
		$data['jobid'] = $jobid;
		$data['ip'] = $ip ? $ip : IP;
		$data['customerid'] = $customerid;
		$data['addtime'] =date('Y-m-d H:i:s',time());
		$data['lang'] = $_M[form][lang];
		if($_M[config][met_cv_type]==1 or $_M[config][met_cv_type]==2){
		    $jid = load::mod_class('job/jobcv_database', 'new')->insert($data);
			if($jid){
				if(load::mod_class('parameter/parameter_label', 'new')->insert_list($jid, 'job', $paras)){
                     return true;
				}
			}
	    }
	}
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://#). All rights reserved.
?>
