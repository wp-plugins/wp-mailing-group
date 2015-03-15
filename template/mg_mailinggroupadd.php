<?php

/* get all variables */

$act = sanitize_text_field($_REQUEST["act"]);

$recid = sanitize_text_field($_REQUEST["id"]);

/* get all variables */

if($act=="upd" && $recid!='')

{

	$result = $objMem->selectRows($table_name_group, $recid);

	if (count($result) > 0 )

	{

		foreach($result as $row)

		{

			$id = $row->id;

			$title = wpmg_dbStripslashes(wpmg_dbHtmlentities($row->title));
			
			$use_in_subject = $row->use_in_subject;

			$email = $row->email;

			$password = $row->password;

			$smtp_server = $row->smtp_server;

			$pop_server = $row->pop_server;

			$smtp_port = $row->smtp_port;

			$pop_port = $row->pop_port;

			$smtp_username = $row->smtp_username;

			$smtp_password = wpmg_dbStripslashes(wpmg_dbHtmlentities($row->smtp_password));

			$pop_username = $row->pop_username;

			$pop_password = wpmg_dbStripslashes(wpmg_dbHtmlentities($row->pop_password));

			$archive_message = $row->archive_message;

			$auto_delete = $row->auto_delete;

			$auto_delete_limit = $row->auto_delete_limit;

			$footer_text = wpmg_dbStripslashes($row->footer_text);

			$sender_name = $row->sender_name;

			$sender_email = $row->sender_email;
			
			/* $reply_to = $row->reply_to; */

			$status = $row->status;
			
			$visibility = $row->visibility;
			$mail_type = $row->mail_type;	
	        $pop_server_type =$row->pop_server_type;			

			$btn = __("Update Mailing Group", 'mailing-group-module');

			$hidval = 2;

		}

	}

} else {

	$btn = __("Add Mailing Group", 'mailing-group-module');
    $mail_type ='wp';
	$pop_server_type ='pop3';
	$hidval = 1;

}

?>

<script>

jQuery(document).ready(function(){

	jQuery('#addgroup').submit(function(){

		if(trim(jQuery("#title").val())=="" || trim(jQuery("#title").val())=='<?php _e("e.g. My Group Name", 'mailing-group-module'); ?>') { alert("<?php _e("Please enter group name.", 'mailing-group-module'); ?>"); jQuery("#title").focus(); return false;}

		if(jQuery("#mail_group option:selected").val()=="") { alert("<?php _e("Please select email group.", 'mailing-group-module'); ?>"); jQuery("#mail_group").focus(); return false;}

		if(trim(jQuery("#email").val())=="" || trim(jQuery("#title").val())=='<?php _e("e.g. my-list@mailserver.com", 'mailing-group-module'); ?>') { alert("<?php _e("Please enter email address.", 'mailing-group-module'); ?>"); jQuery("#email").focus(); return false; }

		if(!checkemail(jQuery("#email").val())) { alert("<?php _e("Please enter valid email address.", 'mailing-group-module'); ?>"); jQuery("#email").focus(); return false;}

		if(trim(jQuery("#password").val())=="") { alert("<?php _e("Please enter password.", 'mailing-group-module'); ?>"); jQuery("#password").focus(); return false;}

		if(trim(jQuery("#pop_server").val())=="" || trim(jQuery("#pop_server").val())=='<?php _e("e.g. pop.mailserver.com", 'mailing-group-module'); ?>') { alert("<?php _e("Please enter POP server.", 'mailing-group-module'); ?>"); jQuery("#pop_server").focus(); return false; }

		if(trim(jQuery("#pop_port").val())=="") { alert("<?php _e("Please enter POP port.", 'mailing-group-module'); ?>"); jQuery("#pop_port").focus(); return false; }

		if(jQuery('#pop_secure').is(':checked')) { if(trim(jQuery("#pop_username").val())=="") {alert("<?php _e("Please enter POP username.", 'mailing-group-module'); ?>");jQuery("#pop_username").focus();return false;} if(trim(jQuery("#pop_password").val())=="") {alert("<?php _e("Please enter POP password.", 'mailing-group-module'); ?>");jQuery("#pop_password").focus();return false;}} else { jQuery("#pop_username").val(""); jQuery("#pop_password").val(""); }
	    
		if(jQuery("input[name=mail_type]:checked").val() =='smtp'){	 if(trim(jQuery("#smtp_server").val())=="" || trim(jQuery("#smtp_server").val())=='<?php _e("e.g. smtp.mailserver.com", 'mailing-group-module'); ?>') { 				alert("<?php _e("Please enter SMTP server.", 'mailing-group-module'); ?>");				jQuery("#smtp_server").focus();				return false;			} 		}
		/*if(trim(jQuery("#smtp_server").val())=="" || trim(jQuery("#smtp_server").val())=='<?php _e("e.g. smtp.mailserver.com", 'mailing-group-module'); ?>') { alert("<?php _e("Please enter SMTP server.", 'mailing-group-module'); ?>"); jQuery("#smtp_server").focus(); return false; }*/

		if(trim(jQuery("#smtp_port").val())=="") { alert("<?php _e("Please enter SMTP port.", 'mailing-group-module'); ?>"); jQuery("#smtp_port").focus();return false; }

		if(jQuery('#smtp_secure').is(':checked')) { if(trim(jQuery("#smtp_username").val())=="") {alert("<?php _e("Please enter smtp username.", 'mailing-group-module'); ?>");jQuery("#smtp_username").focus();return false;} if(trim(jQuery("#smtp_password").val())=="") {alert("<?php _e("Please enter smtp password.", 'mailing-group-module'); ?>");jQuery("#smtp_password").focus();return false;}} else { jQuery("#smtp_username").val(""); jQuery("#smtp_password").val(""); }

		if(jQuery('#auto_delete_yes').is(':checked')) { if(trim(jQuery("#auto_delete_limit").val())!='' && trim(jQuery("#auto_delete_limit").val()) > '0') { if(!checknumber(jQuery("#auto_delete_limit").val())) { alert("<?php _e("Please enter valid number of days.", 'mailing-group-module'); ?>"); jQuery("#auto_delete_limit").focus(); return false; } } else { alert("<?php _e("Please enter number of days for auto-deletion.", 'mailing-group-module'); ?>"); jQuery("#auto_delete_limit").focus(); return false; } } else { jQuery("#auto_delete_limit").val('0');}

		if(trim(jQuery("#sender_name").val())=="" || trim(jQuery("#sender_name").val())=='<?php _e("e.g. Mailing Group Name Administrator", 'mailing-group-module'); ?>') { alert("<?php _e("Please enter sender name.", 'mailing-group-module'); ?>"); jQuery("#sender_name").focus(); return false; }

		if(trim(jQuery("#sender_email").val())=="" || trim(jQuery("#sender_email").val())=='<?php _e("e.g. admin@yourMailingGroup.com", 'mailing-group-module'); ?>') { alert("<?php _e("Please enter sender email.", 'mailing-group-module'); ?>"); jQuery("#sender_email").focus(); return false; }

		if(!checkemail(jQuery("#sender_email").val())) { alert("<?php _e("Please enter valid email address.", 'mailing-group-module'); ?>"); jQuery("#sender_email").focus(); return false;}

		var data = jQuery(this).serialize()

		jQuery.post(ajaxurl, data, function(response) { if(response=='exists') { jQuery("#ajaxMessages_inn").html("<?php wpmg_showmessages("error", __("Mailing group already exists.", 'mailing-group-module')); ?>"); } else if(response=='updated') { jQuery("#ajaxMessages").html("<?php wpmg_showmessages("updated", __("Mailing group has been updated successfully.", 'mailing-group-module')); ?>"); showdatatable(); } else if(response=='added') { jQuery("#ajaxMessages").html("<?php wpmg_showmessages("updated", __("Mailing group has been added successfully.", 'mailing-group-module')); ?>"); showdatatable();} else if(response=='free') { jQuery("#ajaxMessages").html("<?php wpmg_showmessages("error", __("You can only add one mailing group per domain, Please upgrade to Paid version for more features.", 'mailing-group-module')); ?>"); showdatatable();}});

		return false;

	});

	jQuery("#archive_message").click(function(){ if(jQuery('#archive_message').is(':checked')) { jQuery("#auto_delete_no").attr('disabled',false); jQuery("#auto_delete_yes").attr('disabled',false); jQuery("#auto_delete_limit").attr('disabled',false); } else { jQuery("#auto_delete_no").attr('disabled',true); jQuery("#auto_delete_yes").attr('disabled',true); jQuery("#auto_delete_limit").attr('disabled',true); } });
	jQuery("#smtp_secure").click(function(){ if(jQuery('#smtp_secure').is(':checked')) { jQuery("#smtp_secured_div").show(); } else { jQuery("#smtp_secured_div").hide(); jQuery("#smtp_username").val(""); jQuery("#smtp_password").val(""); }});
	jQuery("#pop_secure").click(function(){ if(jQuery('#pop_secure').is(':checked')) { jQuery("#pop_secured_div").show(); } else { jQuery("#pop_secured_div").hide(); jQuery("#pop_username").val(""); jQuery("#pop_password").val(""); }});	
	jQuery(".mail_type").click(function(){    
    var mail_type = jQuery(this).val();   
	if(mail_type == 'smtp'){	
        jQuery("#smtp_mail_div").show();
	}else if(mail_type == 'wp'){
		jQuery("#smtp_mail_div").hide();
		jQuery("#smtp_secured_div").hide();
		jQuery('#smtp_secure').prop('checked', false);
	}else if(mail_type == 'php'){	
	    jQuery("#smtp_mail_div").hide(); 
		jQuery("#smtp_secured_div").hide();
		jQuery('#smtp_secure').prop('checked', false);	
	}		  
	});	
	});


</script>

<div id="ajaxMessages_inn"></div>

<div xmlns="http://www.w3.org/1999/xhtml" class="wrap nosubsub">

    <h2><?php _e("Add/Edit Mailing Group", 'mailing-group-module'); ?></h2>

    <div id="col-left">

        <div class="col-wrap">

            <div>

                <div class="form-wrap">

                    <form class="validate" action="" method="post" id="addgroup">

                        <div class="form-field">

                            <label for="tag-name"><?php _e("Group Name", 'mailing-group-module'); ?> : </label>

                            <input type="text" size="40" id="title" name="title" value="<?php echo ($title!=''?$title:_e("e.g. My Group Name", 'mailing-group-module')); ?>" onfocus="if(this.value=='<?php _e("e.g. My Group Name", 'mailing-group-module') ?>'){ this.value=''; }" onblur="if(this.value==''){ this.value='<?php _e("e.g. My Group Name", 'mailing-group-module') ?>'; }"/>

                        </div>
                        
                        <div class="form-field">
                            <label for="tag-name"><?php _e("Use Group Name as prefix in email subject lines", 'mailing-group-module'); ?> : </label>
                            <input type="checkbox" name="use_in_subject" value="1" id="use_in_subject" <?php echo ($use_in_subject == '1' ? "checked" : ""); ?> />
                        </div>

                        <div class="form-field">

                            <label for="tag-name"><?php _e("Group Email Address", 'mailing-group-module'); ?> : </label>

                            <input type="text" size="40" id="email" name="email" value="<?php echo ($email!=''?$email:_e("e.g. my-list@mailserver.com", 'mailing-group-module')); ?>" onfocus="if(this.value=='<?php _e("e.g. my-list@mailserver.com", 'mailing-group-module') ?>'){ this.value=''; }" onblur="if(this.value==''){ this.value='<?php _e("e.g. my-list@mailserver.com", 'mailing-group-module') ?>'; }"/>

                            <br /><p class="noteclass">NB: Must be set up on server already as a POP or IMAP box.</p>

                        </div>

                        <div class="form-field">

                            <label for="tag-name"><?php _e("Password", 'mailing-group-module'); ?> : </label>

                            <input type="password" size="27" id="password" name="password" value="<?php echo $password; ?>"/>

                        </div>

                        <?php

						$classpop = "none";

						$checkSelpop = "";

                        if($pop_username!='' || $pop_password!='') {

                        	$classpop = "block";

							$checkSelpop = 'checked';

                        }

						?>
						<div class="form-field">	
							<label for="tag-name"><?php _e("Access Mailbox via", 'mailing-group-module'); ?> : </label> 				
							<input type="radio" class="pop_server_type" name="pop_server_type" <?php if($pop_server_type == 'pop3'){ echo 'checked'; } ?> value="pop3"/><p class="innn">&nbsp;&nbsp;<?php _e("POP3", 'mailing-group-module'); ?>&nbsp;&nbsp;&nbsp;&nbsp;</p>	
							<input type="radio" class="pop_server_type" name="pop_server_type" <?php if($pop_server_type == 'imap'){ echo 'checked'; } ?> value="imap"/><p class="innn">&nbsp;&nbsp;<?php _e("IMAP", 'mailing-group-module'); ?>&nbsp;&nbsp;&nbsp;&nbsp;</p>     
  						</div>	
                        <div class="form-field">

                            <label for="tag-name"><?php _e("Incoming Mail Server", 'mailing-group-module'); ?> : </label>

                            <div class="lft"><input type="text" size="40" id="pop_server" name="pop_server" value="<?php echo ($pop_server!=''?$pop_server:_e("e.g. pop.mailserver.com", 'mailing-group-module')); ?>" onfocus="if(this.value=='<?php _e("e.g. pop.mailserver.com", 'mailing-group-module') ?>'){ this.value=''; }" onblur="if(this.value==''){ this.value='<?php _e("e.g. pop.mailserver.com", 'mailing-group-module') ?>'; }"/></div>

                            <div class="rgt"><p class="innn"><?php _e("Port", 'mailing-group-module'); ?> : </p><input type="text" maxlength="5" id="pop_port" name="pop_port" value="<?php echo ($pop_port==''?"110":$pop_port); ?>"/></div>

                            <div class="rgt"><input type="checkbox" id="pop_secure" name="pop_secure" value="1" <?php echo $checkSelpop; ?>/><p class="innn">&nbsp;&nbsp;<?php _e("SSL/Secure Connection", 'mailing-group-module'); ?></p></div>

                        </div>

                        <div class="form-field" id="pop_secured_div" style="display:<?php echo $classpop; ?>;">

                                                        

                            <div class="form-field">

                                <label for="tag-name"><?php _e("Username", 'mailing-group-module'); ?> : </label>

                                <input type="text" size="27" id="pop_username" name="pop_username" value="<?php echo $pop_username; ?>"/>

                            </div>

                            

                            <div class="form-field">

                                <label for="tag-name"><?php _e("Password", 'mailing-group-module'); ?> : </label>

                                <input type="password" size="27" id="pop_password" name="pop_password" value="<?php echo $pop_password; ?>"/>

                            </div>

                            

                        </div>

                        <?php
						$classsmtp = "none";
						$checkSelsmtp = "";
                        if($smtp_username!='' || $smtp_password!='') {
                        	$classsmtp = "block";
							$checkSelsmtp = 'checked';
                        } 
						
						$classmail = "none"; 
   						if($mail_type=='smtp') {     
						$classmail = "block";   
						}		
						?>		
						<div class="form-field">	
						<label for="tag-name"><?php _e("Choose Mailing Function", 'mailing-group-module'); ?> : </label> 				
						<input type="radio" class="mail_type" name="mail_type" <?php if($mail_type == 'wp'){ echo 'checked'; } ?> value="wp"/><p class="innn">&nbsp;&nbsp;<?php _e("WP Mail", 'mailing-group-module'); ?>&nbsp;&nbsp;&nbsp;&nbsp;</p>	
						<input type="radio" id="mail_type_smtp" class="mail_type" name="mail_type" <?php if($mail_type == 'smtp'){ echo 'checked'; } ?> value="smtp"/><p class="innn">&nbsp;&nbsp;<?php _e("SMTP Mail", 'mailing-group-module'); ?>&nbsp;&nbsp;&nbsp;&nbsp;</p>     
						<input type="radio" class="mail_type" name="mail_type" <?php if($mail_type == 'php'){ echo 'checked'; } ?> value="php"/><p class="innn">&nbsp;&nbsp;<?php _e("PHP Mail", 'mailing-group-module'); ?>&nbsp;&nbsp;&nbsp;&nbsp;</p>      
  						</div>		
						
						<div class="form-field" id="smtp_mail_div" style="display:<?php echo $classmail; ?>;">
                            <label for="tag-name"><?php _e("SMTP Server", 'mailing-group-module'); ?> : </label>
                            <div class="lft"><input type="text" size="40" id="smtp_server" name="smtp_server" value="<?php echo ($smtp_server!=''?$smtp_server:_e("e.g. smtp.mailserver.com", 'mailing-group-module')); ?>" onfocus="if(this.value=='<?php _e("e.g. smtp.mailserver.com", 'mailing-group-module') ?>'){ this.value=''; }" onblur="if(this.value==''){ this.value='<?php _e("e.g. smtp.mailserver.com", 'mailing-group-module') ?>'; }"/><br>
                            </div>
                            <div class="rgt"><p class="innn"><?php _e("Port", 'mailing-group-module'); ?> : </p><input type="text" id="smtp_port" maxlength="5" name="smtp_port" value="<?php echo ($smtp_port==''?"25":$smtp_port); ?>"/></div>
                            <div class="rgt"><input type="checkbox" id="smtp_secure" name="smtp_secure" <?php echo $checkSelsmtp; ?> value="1"/><p class="innn">&nbsp;&nbsp;<?php _e("SSL/Secure Connection", 'mailing-group-module'); ?></p></div>
                            <p class="noteclass">SMTP not available or reliable? See <a href="http://www.wpmailinggroup.com/faq/send-mail-smtp/" target="_blank">Recommended SMTP Suppliers</a>.</em></p>

                        </div>

                        <div class="form-field" id="smtp_secured_div" style="display:<?php echo $classsmtp; ?>;">

                            <div class="form-field">

                                <label for="tag-name"><?php _e("Username", 'mailing-group-module'); ?> : </label>

                                <input type="text" id="smtp_username" name="smtp_username" size="27" value="<?php echo $smtp_username; ?>"/>

                            </div>

                            

                            <div class="form-field">

                                <label for="tag-name"><?php _e("Password", 'mailing-group-module'); ?> : </label>

                                <input type="password" id="smtp_password" name="smtp_password" size="27" value="<?php echo $smtp_password; ?>"/>

                            </div>

                        </div>

                        <div class="form-field">

                            <label for="tag-name"><?php _e("Auto-delete old messages", 'mailing-group-module'); ?> : </label>

                            <input type="radio" name="auto_delete" id="auto_delete_no" value="0" <?php echo ($auto_delete=='0'?"checked":($auto_delete==""?"checked":"")) ?> checked="checked" disabled="disabled" />&nbsp;<?php _e("No", 'mailing-group-module'); ?>&nbsp;

                            <input type="radio" name="auto_delete" disabled="disabled" value="1" id="auto_delete_yes" <?php echo ($auto_delete=='1'?"checked":"") ?> />&nbsp;<?php _e("Yes, after", 'mailing-group-module'); ?>&nbsp;

                            <input type="text" name="auto_delete_limit" disabled="disabled" id="auto_delete_limit" size="5" maxlength="2" value="<?php echo $auto_delete_limit; ?>"/>&nbsp;<?php _e("days", 'mailing-group-module'); ?>

                            <br /><p class="noteclass">(Auto-deletion in Premium version only)</p>

                        </div>

                        <div class="form-field">

                            <label for="tag-name"><?php _e("Footer text for emails", 'mailing-group-module'); ?> : </label>

                            <textarea name="footer_text" id="footer_text" rows="10" cols="80"><?php echo ($footer_text!=''?($footer_text):'-- -- -- --

This message was sent to <b>{%name%}</b> at <b>{%email%}</b> by the <a href="{%site_url%}">{%site_url%}</a> website using the <a href="http://WPMailingGroup.com">WPMailingGroup plugin</a>.

<b><a href="{%unsubscribe_url%}">Unsubscribe</a></b> | <a href="{%profile_url%}">Update Profile</a>'); ?></textarea>

                        </div>

                        <div class="form-field">

                       		<label for="tag-name">Available Variables</label>

                            <p class="codeexample"><code class="codemail">

                            	{%name%} = Name of the receiving member<br />

                                {%email%} = Email of the receiving member<br />

                                {%site_url%} = Site's URL<br />

                                {%archive_url%} = Message Archive page URL<br />(NB: Message Archive in Premium version only) <br />

                                {%profile_url%} = User profile URL<br />

                                {%unsubscribe_url%} = Unsubscribe URL

                            </code>

                            </p>

                        </div>

                        <div><h3><?php _e("Settings for Subscription Request messages", 'mailing-group-module'); ?></h3></div>

                        <div class="form-field">

                            <label for="tag-name"><?php _e("Sender name", 'mailing-group-module'); ?> : </label>

                            <input type="text" size="40" id="sender_name" name="sender_name" value="<?php echo ($sender_name!=''?$sender_name:_e("e.g. Mailing Group Name Administrator", 'mailing-group-module')); ?>" onfocus="if(this.value=='<?php _e("e.g. Mailing Group Name Administrator", 'mailing-group-module') ?>'){ this.value=''; }" onblur="if(this.value==''){ this.value='<?php _e("e.g. Mailing Group Name Administrator", 'mailing-group-module') ?>'; }"/>

                        </div>

                        <div class="form-field">

                            <label for="tag-name"><?php _e("Sender email", 'mailing-group-module'); ?> : </label>

                            <input type="text" size="40" id="sender_email" name="sender_email" value="<?php echo ($sender_email!=''?$sender_email:_e("e.g. admin@yourMailingGroup.com", 'mailing-group-module')); ?>" onfocus="if(this.value=='<?php _e("e.g. admin@yourMailingGroup.com", 'mailing-group-module') ?>'){ this.value=''; }" onblur="if(this.value==''){ this.value='<?php _e("e.g. admin@yourMailingGroup.com", 'mailing-group-module') ?>'; }"/>

                        </div>

                        <!-- <div class="clearbth"></div>
                        
                        <div class="form-field">

                            <label for="tag-name"><?php _e("Reply To", 'mailing-group-module'); ?> : </label>

                            <input type="text" size="40" id="reply_to" name="reply_to" value="<?php echo ($reply_to!=''?$reply_to:_e("e.g. admin@yourMailingGroup.com", 'mailing-group-module')); ?>" onfocus="if(this.value=='<?php _e("e.g. admin@yourMailingGroup.com", 'mailing-group-module') ?>'){ this.value=''; }" onblur="if(this.value==''){ this.value='<?php _e("e.g. admin@yourMailingGroup.com", 'mailing-group-module') ?>'; }"/>

                        </div> -->

                        <div class="clearbth"></div>

                        <div><h3><?php _e("Mailing Group Status", 'mailing-group-module'); ?></h3></div>

                        <div class="form-field">

                            <label for="tag-name"><?php _e("Status", 'mailing-group-module'); ?> : </label>

                            <select name="status" id="status">

                            	<option value="0" <?php echo ($status=='0'?"selected":""); ?>><?php _e("Inactive", 'mailing-group-module'); ?></option>

                                <option value="1" <?php echo ($status=='1'?"selected":""); ?> <?php echo ($status==''?"selected":"")?>><?php _e("Active", 'mailing-group-module'); ?></option>

                            </select>

                        </div>
                        
                        <div class="clearbth"></div>
                        <div class="form-field">
                            <label for="tag-name"><?php _e("Visibility", 'mailing-group-module'); ?> : </label>
                            <select name="visibility" id="visibility">
                            	<option value="1" <?php echo ($visibility=='1'?"selected":""); ?>><?php _e("Public", 'mailing-group-module'); ?></option>
                                <option value="2" <?php echo ($visibility=='2'?"selected":""); ?> <?php echo ($visibility==''?"selected":"")?>><?php _e("Invitation", 'mailing-group-module'); ?></option>
                                <option value="3" <?php echo ($visibility=='3'?"selected":""); ?> <?php echo ($visibility==''?"selected":"")?>><?php _e("Private", 'mailing-group-module'); ?></option>
                            </select>
                        </div>

                        <p>&nbsp;</p>

                        <p class="submit">

                            <input type="submit" value="<?php echo $btn; ?>" class="button" id="submit" name="submit"/>

                            <input type="hidden" name="addme" value=<?php echo $hidval;?> >

                            <input type="hidden" name="id" value=<?php echo $id;?> >

                            <input type="hidden" name="action" value="wpmg_addmailgroupsetting" />

                            <input type="hidden" name="page" value="wpmg_mailinggroup_add" />

                        </p>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>