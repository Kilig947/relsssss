<!--<?php
#

defined('IN_MET') or exit('No permission');

require $this->template('ui/head');
echo <<<EOT
-->
<div class="stat_list">
  <ul>
    <li ><a href="{$_M[url][own_form]}&a=doindex&class1={$_M[form][class1]}" title="{$_M[word][messageTitle]}">{$_M[word][messageTitle]}</a></li>
    <li><a href="{$_M[url][adminurl]}anyid=29&n=parameter&c=parameter_admin&a=doparaset&module=7&class1={$_M[form][class1]}" title="{$_M[word][messageVoice]}">{$_M[word][messageVoice]}</a></li>
    <li><a class="now syset" href="{$_M[url][own_form]}&a=dosyset&class1={$_M[form][class1]}" title="{$_M[word][messageincTitle]}">{$_M[word][messageincTitle]}</a></li>
  </ul>
</div>
<div style="clear:both;"></div>
<!--
EOT;
echo <<<EOT
-->
<form method="POST"  class="ui-form" name="myform" action="{$_M[url][own_form]}a=dosaveinc" target="_self">
		<input name="action" type="hidden" value="modify">
		<input name="class1" type="hidden" value="$class1">
		<input name="met_fd_email" type="hidden" value="0">
		<input name="met_fd_back" type="hidden" value="0">
		<input name="met_fd_sms_back" type="hidden" value="0">
		<input name="met_fd_type" type="hidden" value="0">
<div class="v52fmbx_tbmax">
<div class="v52fmbx_tbbox">
<div class="v52fmbx">
	<dl>
	 <dt>{$_M[word][messagesubmit]}{$_M[word][marks]}</dt>
	 <dd class="ftype_radio">
		<div class="fbox">
			<label><input name="met_fd_ok" type="radio" value="1" $met_fd_ok1[1]>{$_M[word][open]}</label>
			<label><input name="met_fd_ok" type="radio" value="0" $met_fd_ok1[0]>{$_M[word][close]}</label>
		</div>
	 </dd>
    </dl>
	<dl>
	<dt>{$_M[word][fdincTime]}{$_M[word][marks]}</dt>
	<dd class="ftype_input">
		<div class="fbox">
			<input type="text" name="met_fd_time" value="$met_fd_time">
		</div>
		<span class="tips">{$_M[word][fdincTip4]}</span>
	</dd>
     </dl>
    <!-- <dl>
		<dt>{$_M[word][fdincSlash]}{$_M[word][marks]}</dt>
		<dd class="ftype_textarea">
			<div class="fbox">
				<textarea name="met_fd_word">$met_fd_word</textarea>
			</div>
			<span class="tips">{$_M[word][fdincTip5]}</span>
		</dd>
    </dl>-->







		<div class="v52fmbx_dlbox">
		<dl>
			<dt>{$_M[word][message_name]}{$_M[word][marks]}</dt>
			<dd>
				<select name="met_message_fd_class">
<!--
EOT;
foreach($name_para as $key=>$val){
$select1='';
if($val[id]==$met_message_fd_class)$select1="selected='selected'";
echo <<<EOT
-->				<option value="$val[id]" $select1 >$val[name]</option>
<!--
EOT;
}
echo <<<EOT
-->

			</select>
			<span class="tips">{$_M[word][message_name1]}</span>
			</dd>
		</dl>
		</div>
		<div class="v52fmbx_dlbox">
		<dl>
			<dt>{$_M[word][message_content]}{$_M[word][marks]}</dt>
			<dd>
				<select name="met_message_fd_content">
<!--
EOT;
foreach($text_para as $key=>$val){
$select1='';
if($val[id]==$met_message_fd_content)$select1="selected='selected'";
echo <<<EOT
-->				<option value="$val[id]" $select1 >$val[name]</option>
<!--
EOT;
}
echo <<<EOT
-->

			</select>
			<span class="tips">{$_M[word][message_content1]}</span>
			</dd>
		</dl>
		</div>





        <dl>
	<dt>{$_M[word][messageincShow]}{$_M[word][marks]}</dt>
	<dd class="ftype_checkbox ftype_transverse">
		<div class="fbox">
			<label><input name="met_fd_type" type="checkbox" value="1" $met_fd_type1>{$_M[word][messageincTip3]}</label>
		</div>
	</dd>
</dl>
  <dl>
	<dt>{$_M[word][messageincSend]}{$_M[word][marks]}</dt>
	<dd class="ftype_checkbox ftype_transverse">
		<div class="fbox">
			<label><input name="met_fd_email" type="checkbox" value="1" $met_fd_email1>{$_M[word][messageincTip4]}</label>
		</div>
	</dd>
</dl>


<dl>
	<dt>{$_M[word][message_AcceptMail]}{$_M[word][marks]}</dt>
	<dd class="ftype_input">
		<div class="fbox">
			<input type="text" name="met_fd_to" value="$met_fd_to">
		</div>
		<span class="tips">{$_M[word][fdincTip9]}</span>
	</dd>
     </dl>
	<h3 class="v52fmbx_hr metsliding" sliding="1">{$_M[word][feedbackauto]}</h3>
	<div class="metsliding_box metsliding_box_1">
		 <dl>
	     <dt>{$_M[word][fdincAuto]}{$_M[word][marks]}</dt>
	     <dd class="ftype_checkbox ftype_transverse">
		 <div class="fbox">
			<label><input name="met_fd_back" type="checkbox" value="1" {$met_fd_back1}>{$_M[word][fdincTip10]}</label>
		 </div>
	     </dd>
         </dl>
		<div class="v52fmbx_dlbox">
		<dl>
			<dt>{$_M[word][fdincEmailName]}{$_M[word][marks]}</dt>
			<dd>
			<select name="met_message_fd_email">
<!--
EOT;
foreach($email_para as $key=>$val){
$select1='';
if($val[id]==$met_message_fd_email)$select1="selected='selected'";
echo <<<EOT
-->
				<option value="$val[id]" $select1 >$val[name]</option>
<!--
EOT;
}
echo <<<EOT
-->

			</select>
			<span class="tips">{$_M[word][fdincTip11]}</span>
			</dd>
		</dl>
		</div>


        <dl>
	<dt>{$_M[word][fdincFeedbackTitle]}{$_M[word][marks]}</dt>
	<dd class="ftype_input">
		<div class="fbox">
			<input type="text" name="met_fd_title" value="$met_fd_title">
		</div>
		<span class="tips">{$_M[word][fdincAutoFbTitle]}</span>
	</dd>
</dl>







        <dl>
	<dt>{$_M[word][fdincAutoContent]}{$_M[word][marks]}</dt>
	<dd class="ftype_textarea">
		<div class="fbox">
			<textarea name="met_fd_content" >{$_M[config][met_fd_content]}</textarea>
		</div>
		<span class="tips"></span>
	</dd>
</dl>


		<h3 class="v52fmbx_hr metsliding" sliding="1">{$_M[word][feedbackautosms]}</h3>
	<div class="metsliding_box metsliding_box_1">

        <dl>
	<dt>{$_M[word][fdincAutosms]}{$_M[word][marks]}</dt>
	<dd class="ftype_checkbox">
		<div class="fbox">
			<label><input name="met_fd_sms_back" type="checkbox" value="1" $met_fd_sms_back1>{$_M[word][fdincTipsms]}</label>
		</div>
	</dd>
</dl>

		<div class="v52fmbx_dlbox">
		<dl>
			<dt>{$_M[word][fdinctellsms]}{$_M[word][marks]}</dt>
			<dd>
			<select name="met_message_fd_sms">
<!--
EOT;
foreach($phone_para as $key=>$val){
$select1='';
if($val[id]==$met_message_fd_sms)$select1="selected='selected'";
echo <<<EOT
-->
				<option value="$val[id]" $select1 >$val[name]</option>
<!--
EOT;
}
echo <<<EOT
-->

			</select>
			<span class="tips">{$_M[word][fdinctells]}</span>
			</dd>
		</dl>
		</div>
        <dl>
	<dt>{$_M[word][fdincAutoContentsms]}{$_M[word][marks]}</dt>
	<dd class="ftype_textarea">
		<div class="fbox">
			<textarea name="met_fd_sms_content" >{$_M[config][met_fd_sms_content]}</textarea>
		</div>
		<span class="tips"></span>
	</dd>
</dl>


		</div>
		<div class="v52fmbx_submit">
			<input type="submit" name="Submit" value="{$_M[word][Submit]}" class="submit" onclick="return Smit($(this),'myform')" />
		</div>
	</div>
</div>
</div>
</div>
</div>
</div>
</form>
<!--
EOT;
require $this->template('ui/foot');
# This program is an open source system, commercial use, please consciously to purchase commercial license.
# Copyright (C) MetInfo Co., Ltd. (http://#). All rights reserved.
?>