<?php
# MetInfo Enterprise Content Management System 
# Copyright (C) MetInfo Co.,Ltd (http://#). All rights reserved. 

defined('IN_MET') or exit('No permission');
load::sys_func('common');

class pin {
	
	public function check_pin($pin){
		global $_M;
		$authpin = $this->getpin();
		if($authpin && $authpin ==  strtoupper($pin)){
			$this->setpin($this->make_rand(4));
			return true;
		}else{
			return false;
		}
	}
	
	public function create_pin(){
		$this->getAuthImage($this->make_rand(4));
	}
	
	function getAuthImage($text) {
		$this->setpin($text);
		$im_x = 160;
		$im_y = 40;
		$im = imagecreatetruecolor($im_x,$im_y);
		$text_c = ImageColorAllocate($im, mt_rand(0,100),mt_rand(0,100),mt_rand(0,100));
		$tmpC0=mt_rand(100,255);
		$tmpC1=mt_rand(100,255);
		$tmpC2=mt_rand(100,255);
		$buttum_c = ImageColorAllocate($im,$tmpC0,$tmpC1,$tmpC2);
		imagefill($im, 16, 13, $buttum_c);

		$font = PATH_SYS_PUBLIC.'font-awesome/fonts/verdana.ttf';

		for ($i=0;$i<strlen($text);$i++)
		{
			$tmp =substr($text,$i,1);
			$array = array(-1,1);
			$p = array_rand($array);
			$an = $array[$p]*mt_rand(1,10);
			$size = 28;
			imagettftext($im, $size, $an, 15+$i*$size, 35, $text_c, $font, $tmp);
		}


		$distortion_im = imagecreatetruecolor ($im_x, $im_y);

		imagefill($distortion_im, 16, 13, $buttum_c);
		for ( $i=0; $i<$im_x; $i++) {
			for ( $j=0; $j<$im_y; $j++) {
				$rgb = imagecolorat($im, $i , $j);
				if( (int)($i+20+sin($j/$im_y*2*M_PI)*10) <= imagesx($distortion_im)&& (int)($i+20+sin($j/$im_y*2*M_PI)*10) >=0 ) {
					imagesetpixel ($distortion_im, (int)($i+10+sin($j/$im_y*2*M_PI-M_PI*0.1)*4) , $j , $rgb);
				}
			}
		}

		$count = 160;
		for($i=0; $i<$count; $i++){
			$randcolor = ImageColorallocate($distortion_im,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255));
			imagesetpixel($distortion_im, mt_rand()%$im_x , mt_rand()%$im_y , $randcolor);
		}

		$rand = mt_rand(5,30);
		$rand1 = mt_rand(15,25);
		$rand2 = mt_rand(5,10);
		for ($yy=$rand; $yy<=+$rand+2; $yy++){
			for ($px=-80;$px<=80;$px=$px+0.1)
			{
				$x=$px/$rand1;
				if ($x!=0)
				{
					$y=sin($x);
				}
				$py=$y*$rand2;

				imagesetpixel($distortion_im, $px+80, $py+$yy, $text_c);
			}
		}


		Header("Content-type: image/JPEG");


		ImagePNG($distortion_im);


		ImageDestroy($distortion_im);
		ImageDestroy($im);
	}

	function make_rand($length="32"){
		$str="A2B3C4D5E6F7G8H9iJKLMNPQRSTUVWXYZ";
		$result="";
		for($i=0;$i<$length;$i++){
			$num[$i]=mt_rand(0,25);
			$result.=$str[$num[$i]];
		}
		return $result;
	}
	
	function setpin($str){
		load::sys_class('session', 'new')->set('pin', $str);
	}
	
	function getpin(){
		return load::sys_class('session', 'new')->get('pin');
	}
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://#). All rights reserved.
?>