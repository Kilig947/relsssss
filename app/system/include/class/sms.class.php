<?php
#

defined('IN_MET') or exit('No permission');

/**
 * 短信发送类
 * @param string $errorcode  出错信息
 */
load::sys_class('curl');
class sms extends curl{
	public $errorcode;

	/**
	 * 发送短信
	 * @DateTime 2017-07-27
	 * @param    [type]     $phone   [description]
	 * @param    [type]     $message [description]
	 * @param    integer    $type    [description]
	 * @return   [type]              [description]
	 */
	public function sendsms($phone, $message, $type = 6){
		global $_M;


		if(file_exists(PATH_ALL_APP.'met_sms') && $_M['config']['met_sms_url'])
		{
			$sms = load::app_class('met_sms/include/class/met_sms','new');
			$this->errorcode = $sms->auto_send($phone,$message);
		}else{
			$this->errorcode =$_M['word']['msmnoifno'];
		}
		return $this->errorcode;

	}


}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://#). All rights reserved.
?>