<?php
#
defined('IN_MET') or exit('No permission');
?>
<include file="metinfo.inc.php"/>
<?php $met_page=$template_type=='ui'?'index':''; ?>
<include file="head" page="$met_page"/>
<?php
if(file_exists(PATH_OWN_FILE."templates/met/css/metinfo.css")){
	$own_metinfo_css_filemtime = filemtime(PATH_OWN_FILE.'templates/met/css/metinfo.css');
?>
<link href="{$_M['url']['own_tem']}css/metinfo.css?{$own_metinfo_css_filemtime}" rel='stylesheet' type='text/css'>
<?php } ?>