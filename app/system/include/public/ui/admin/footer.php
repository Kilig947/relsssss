<?php
#
defined('IN_MET') or exit('No permission');
$foot = str_replace('$metcms_v',$_M['config']['metcms_v'], $_M['config']['met_agents_copyright_foot']);
$foot = str_replace('$m_now_year',date('Y',time()), $foot);
echo <<<EOT
-->
<div class="footer"></div>
<!--
EOT;
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://#). All rights reserved..
?>