<?php
#
defined('IN_MET') or exit('No permission');
?>
<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-mobile"></i></span>
		<input type="text" name="phone" required class="form-control" placeholder="<?php echo $_M['word']['memberbasicCell'];?>"
		data-fv-phone="true"
		data-fv-phone-message="<?php echo $_M['word']['telok'];?>"

		data-fv-notempty-message="<?php echo $_M['word']['noempty'];?>"

		data-fv-stringlength="true"
		data-fv-stringlength-min="2"
		data-fv-stringlength-max="30"
		data-fv-stringlength-message="<?php echo $_M['word']['usernamecheck'];?>"
		/>
	</div>
</div>
<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
		<input type="password" name="password" required class="form-control" placeholder="<?php echo $_M['word']['password'];?>"
		data-fv-notempty-message="<?php echo $_M['word']['noempty'];?>"

		data-fv-identical="true"
		data-fv-identical-field="confirmpassword"
		data-fv-identical-message="<?php echo $_M['word']['passwordsame'];?>"

		data-fv-stringlength="true"
		data-fv-stringlength-min="3"
		data-fv-stringlength-max="30"
		data-fv-stringlength-message="<?php echo $_M['word']['passwordcheck'];?>"
		>
	</div>
</div>
<div class="form-group">
	<div class="input-group">
		<span class="input-group-addon"><i class="fa fa-unlock-alt"></i></span>
		<input type="password" name="confirmpassword" required data-password="password" class="form-control" placeholder="<?php echo $_M['word']['renewpassword'];?>"
		data-fv-identical="true"
		data-fv-identical-field="password"
		data-fv-identical-message="<?php echo $_M['word']['passwordsame'];?>"
		>
	</div>
</div>
<div class="form-group">
    <div class="input-group input-group-icon">
        <span class="input-group-addon"><i class="fa fa-shield"></i></span>
        <input type="text" name="code" required class="form-control" placeholder="<?php echo $_M['word']['memberImgCode'];?>" data-fv-notempty-message="<?php echo $_M['word']['noempty'];?>">
        <div class="input-group-addon p-5 login-code-img">
            <img src="<?php echo $_M[url][entrance];?>?m=include&c=ajax_pin&a=dogetpin" title="<?php echo $_M['word']['memberTip1'];?>" id='getcode' align="absmiddle" role="button">
        </div>
    </div>
</div>
<div class="form-group">
    <div class="input-group input-group-icon">
        <input type="text" name="phonecode" required class="form-control" placeholder="<?php echo $_M['word']['memberImgCode'];?>" data-fv-notempty-message="<?php echo $_M['word']['noempty'];?>">
        <div class="input-group-addon p-0">
            <button type="button" data-url="<?php echo $_M['url']['valid_phone'];?>" class="btn btn-success btn-squared w-full phone-code" data-retxt="<?php echo $_M['word']['resend'];?>">
                <?php echo $_M['word']['phonecode'];?>
                <span class="badge"></span>
            </button>
        </div>
    </div>
</div>