<?php
#

defined('IN_MET') or exit('No permission');

load::sys_class('web');

class about extends web {
	public function __construct() {
		global $_M;
		parent::__construct();
	}

  public function doabout() {
		global $_M;
		if($_M['form']['id']){
			$this->input_class($_M['form']['id']);
		}else{
			if(!is_numeric($_M['form']['metid'])){
				$custom = load::sys_class('label', 'new')->get('column')->get_column_filename($_M['form']['metid']);
             if(!$custom && $_M['form']['metid']!=''){
			 $custom = load::mod_class('about/about_database', 'new')->get_list_by_filename($_M['form']['metid']);
			 $custom=$custom[0];
			 }
				$_M['form']['metid'] = $custom['id'];
			}
			$this->input_class($_M['form']['metid']);
		}
		$data = load::sys_class('label', 'new')->get('about')->get_about($this->input['classnow']);
		$this->check($data['access']);

		if(!$data['isshow']){
			$next2 = load::sys_class('label', 'new')->get('column')->get_column_son($data['id']);
			if($next2[0]['module'] != 1){
				header("HTTP/1.1 301 Moved Permanently");
				header("Location: {$next2[0][url]}");
				exit;
			}

			if(!$next2[0]['isshow']){
				$next3 = load::sys_class('label', 'new')->get('column')->get_column_son($next2[0]['id']);
				$this->add_input('classnow', $next3[0]['id']);
				if($next3[0]['module'] != 1){
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: {$next3[0][url]}");
					exit;
				}
			}else{
				if($next2[0]['module'] == 1){
					$this->add_input('classnow', $next2[0]['id']);
				}
				foreach ($next2 as $key => $value) {
                	if($next2[$key]['module'] == 1 && $next2[$key]['filename'] && strstr($_SERVER['REQUEST_URI'],$next2[$key]['filename'])){
                        $this->add_input('classnow', $next2[$key]['id']);
                	}
                }
			}
			$data = load::sys_class('label', 'new')->get('about')->get_about($this->input['classnow']);
		}
		$this->add_array_input($data);
		$this->seo($data['name'], $data['keywords'], $data['description']);
		$this->seo_title($data['ctitle']);
		require_once $this->template('tem/show');
  }

}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://#). All rights reserved.
?>
