<?php
#

defined('IN_MET') or exit('No permission');

class valid {

	public function get_email($email,$type = 'register'){
		global $_M;
		//生成加密字符串
		$auth = load::sys_class('auth', 'new');
		$p = urlencode($auth->encode($email,'',3600));
		//发邮件
		$jmail = load::sys_class('jmail', 'new');
		$touser = $email;

		$title = $_M['config']['met_member_email_reg_title'];
		$body = $_M['config']['met_member_email_reg_content'];
		$url = $_M['url']['valid_email'];

		if($type=='getpassword'){
			$title = $_M['config']['met_member_email_password_title'];
			$body = $_M['config']['met_member_email_password_content'];
			$url = $_M['url']['password_valid'];
		}
		if($type=='emailedit'){
			$title = $_M['config']['met_member_email_safety_title'];
			$body = $_M['config']['met_member_email_safety_content'];
			$url = $_M['url']['emailedit'];
		}
		if($type=='emailadd'){
			$title = $_M['config']['met_member_email_safety_title'];
			$body = $_M['config']['met_member_email_safety_content'];
			$url = $_M['url']['profile_safety_emailadd'];
		}
		$url = $url."&p={$p}";
		$title = $this->repalce_email($title, $url);
		$body = $this->repalce_email($body, $url);
		return $jmail->send_email($touser, $title, $body);
	}

	public function repalce_email($str, $url){
		global $_M;
		$str = str_replace('{webname}', $_M['config']['met_webname'], $str);
		$str = str_replace('{weburl}', $_M['config']['met_weburl'], $str);
		$str = str_replace('{opurl}', $url, $str);
		return $str;
	}

	public function get_tel($tel){
		global $_M;
        if(!load::sys_class('pin', 'new')->check_pin($_M['form']['code']) && $_M['config']['met_memberlogin_code'] ){
            echo  $_M['word']['membercode'];
            die;
        }
		$session = load::sys_class('session', 'new');
		if($session->get("phonetime")&&time()<($session->get("phonetime")-220)){
			return false;
			die;
		}

		$code = random(6, 1);
		$time = time()+300;
		$session->set("phonecode",$code);
		$session->set("phonetime",$time);
		$session->set("phonetel",$tel);

		$sms = load::sys_class('sms', 'new');
		$ret = $sms->sendsms($tel, "{$_M['word']['usesendcode']}{$code}{$_M['word']['usesendcodeinfo']}");
		return $ret;

	}
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://#). All rights reserved.
?>