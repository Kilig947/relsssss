<?php
#

defined('IN_MET') or exit('No permission');

load::mod_class('news/news_database');

/**
 * 系统标签类
 */

class product_database extends news_database {
  public function __construct() {
    global $_M;
    $this->construct($_M['table']['product']);
    $this->multi_column = 1;
  }

  /**
   * 删除
   * @param  string  $id    id
   * @return bool           删除是否成功
   */
  public function del_by_id($id) {
    if(parent::del_by_id($id)) {
      load::mod_class('parameter/parameter_database', 'new')->del_list($id, $this->table_to_module($this->table));
      return true;
    } else {
      return false;
    }

  }

  public function table_to_module($table) {
    global $_M;
    switch ($table) {
      case $_M['table']['product']:
        $mod = 3;
      break;
      case $_M['table']['download']:
        $mod = 4;
      break;
      case $_M['table']['img']:
        $mod = 5;
      break;
    }
    return $mod;
  }

  public function table_para(){
    return 'id|title|ctitle|keywords|description|content|content1|content2|content3|content4|class1|class2|class3|no_order|wap_ok|img_ok|imgurl|imgurls|com_ok|issue|hits|updatetime|addtime|access|top_ok|filename|lang|recycle|displaytype|tag|links|displayimg|classother|imgsize';
  }

  public function get_multi_column_sql($class1, $class2, $class3){
    if($class1 || $class2 || $class3){
      $sql .= "AND (";
      if ($class1) {
        $sql .= " class1 = '{$class1}' AND ";
      }
      if ($class2) {
        $sql .= " class2 = '{$class2}' AND ";
      }
      if ($class3) {
        $sql .= " class3 = '{$class3}' AND ";
      }
      $sql = substr($sql, 0 , -4);
      $sql .= " OR (";
      $sql .= " classother REGEXP '/|-{$class1}-";
      $sql .= $class2?"{$class2}-":"[0-9]*-";
      $sql .= $class3?"{$class3}-|/'":"[0-9]*-|/'";
      $sql .= " )";
      $sql .= " )";
    }
    return $sql;
	}

  public function del_plist($id,$module){
      global $_M;
      $query="delete from {$_M[table][plist]} where listid='$id' and lang='{$_M[lang]}' and module='$module'";
      DB::query($query);
  }

  public function get_list_by_class123($class1,$class2,$class3)
  {
      global $_M;
      $where = "WHERE class1 = {$class1}";
      if($class2){
         $where .= " AND WHERE class2 = {$class2}";
      }

      if($class3){
         $where .= " AND WHERE class3 = {$class3}";
      }
      $query = "SELECT id,title FROM {$this->table} {$where} AND lang='{$_M['lang']}' ORDER BY no_order DESC";
      return DB::get_all($query);
  }
}

# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://#). All rights reserved.
?>
