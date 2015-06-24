<?php
$status = get_option( 'wpmg_mailing_license_status' );	
if($status == 'invalid'){die();}
/* get all variables */
$actreq = (isset($_REQUEST["act"])? wpmg_trimVal($_REQUEST["act"]): '');
$info   = (isset($_REQUEST["info"])? wpmg_trimVal($_REQUEST["info"]): '');
$delid  = (isset($_GET["did"])? wpmg_trimVal($_GET["did"]): '');
$id     = (isset($_GET["uid"])? wpmg_trimVal($_GET["uid"]): '');
$gid    = (isset($_GET["gid"])? wpmg_trimVal($_GET["gid"]): '');
$eid    = (isset($_GET["eid"])? wpmg_trimVal($_GET["eid"]): '');
/* get all variables */

if(isset($_POST['massaction']) && $_POST['massaction']=='1') {
	if(count($_POST['deletemsg'])>0) {
		foreach($_POST['deletemsg'] as $key => $delid) {
			$modfields = array("id","type","status");
			$modgrpinfo['id']     = $delid;
			$modgrpinfo['type']   = 'moderation';
			$modgrpinfo['status'] = '0';	
			$objMem->updRow($table_name_parsed_emails,$modgrpinfo,$modfields);	
		}
	}
	wpmg_redirectTo("wpmg_mailinggroup_message_moderation&info=upd_app");
	exit;
} else if($actreq=='approve' && $delid!='') {
	$modfields = array("id","type","status");
	$modgrpinfo['id']     = $delid;
	$modgrpinfo['type']   = 'moderation';
	$modgrpinfo['status'] = '0';	
	$objMem->updRow($table_name_parsed_emails,$modgrpinfo,$modfields);	
	wpmg_redirectTo("wpmg_mailinggroup_message_moderation&info=upd_app");
	exit;
}

if(isset($_POST['massaction']) && $_POST['massaction']=='2') {
	if(count($_POST['deletemsg'])>0) {
		foreach($_POST['deletemsg'] as $key => $delid) {
			$wpdb->query("delete from ".$table_name_parsed_emails." where id=".$delid);
		}
	}
	wpmg_redirectTo("wpmg_mailinggroup_message_moderation&info=upd");
	exit;
} else if($actreq=='del' && $delid!='') {
	$wpdb->query("delete from ".$table_name_parsed_emails." where id=".$delid);
	wpmg_redirectTo("wpmg_mailinggroup_message_moderation&info=upd");
	exit;
}

if(isset($_POST['massaction']) && $_POST['massaction']=='3') {
	if(count($_POST['deletemsg'])>0) {
		foreach($_POST['deletemsg'] as $key => $delid) {
			$mailresult = $objMem->selectRows($table_name_parsed_emails, "",  " where id = '".$delid."'");
			$groupid = $mailresult[0]->email_group_id;
			$resultgpid = $objMem->selectRows($table_name_group, "",  " where id=".$groupid);
			if (count($resultgpid)>0) {
				$groupName = $resultgpid[0]->title;
			}
			$admin_email = get_option( 'admin_email' );

			$subjects  = '"Access Denied" by admin --- '.$mailresult[0]->email_subject;
			$to        = $mailresult[0]->email_to;
			$to_name   = $mailresult[0]->email_to_name;
			$from      = $mailresult[0]->email_from;
			$from_name = $mailresult[0]->email_from_name;
			
			$message  = "";
			$message  .= "The following message you sent to the <b>".$groupName."</b> Mailing Group has been deleted by a moderator. You may have used inappropriate words, or tried to post while still a new member. Please contact the Administrator <a href='mailto:".$admin_email."' />".$admin_email."</a> if you have questions about this. Thank you.";
			
			$content  = "";	
			$content  .= $message;
			$content  .= "<br>";
			$content  .= "<br>***********************************************<BR>";
			$content  .= "SUBJECT: ".$mailresult[0]->email_subject.'<br>';
			$content  .= "MESSAGE: ".$mailresult[0]->email_content; 
			
			$headers[] = 'To: '. $from_name .'<'.$from.'>'."\r\n";
			$headers[] = 'X-Mailer: PHP' . phpversion() . "\r\n";
			$headers[] = 'MIME-Version: 1.0'."\r\n";
			$headers[] = 'Content-Type: ' . get_bloginfo('html_type') . '; charset=\"'. get_bloginfo('charset') . '\"'."\r\n";
			$headers[] = 'Content-type: text/html'."\r\n";				
			
			wp_mail($from,$subjects,$content,$headers);
			$wpdb->query("delete from ".$table_name_parsed_emails." where id=".$delid);
			wpmg_redirectTo("wpmg_mailinggroup_message_moderation&info=upd_inform");
			exit;
		}
	}
	wpmg_redirectTo("wpmg_mailinggroup_message_moderation&info=upd_inform");
	exit;
} else if($actreq=='del_inform' && $delid!='' && $eid!='') {

    $mailresult = $objMem->selectRows($table_name_parsed_emails, "",  " where id = '".$delid."'");
	$groupid = $mailresult[0]->email_group_id;
	$resultgpid = $objMem->selectRows($table_name_group, "",  " where id=".$groupid);
	if (count($resultgpid)>0) {
		$groupName = $resultgpid[0]->title;
	}
    $admin_email = get_option( 'admin_email' );

	$subjects  = $mailresult[0]->email_subject;
	$to        = $mailresult[0]->email_to;
	$to_name   = $mailresult[0]->email_to_name;
	$from      = $mailresult[0]->email_from;
	$from_name = $mailresult[0]->email_from_name;
	
	$message  = "";
	$message  .= "The following message you sent to the <b>".$groupName."</b> Mailing Group has been deleted by a moderator. You may have used inappropriate words, or tried to post while still a new member. Please contact the Administrator <a href='mailto:".$admin_email."' />".$admin_email."</a> if you have questions about this. Thank you.";
	
    $content  = "";	
	$content  .= $message;
	$content  .= "<br>";
	$content  .= "<br>***********************************************<BR>";
	$content  .= $mailresult[0]->email_content; 
	
	$headers[] = 'To: '. $from_name .'<'.$from.'>'."\r\n";
	$headers[] = 'X-Mailer: PHP' . phpversion() . "\r\n";
	$headers[] = 'MIME-Version: 1.0'."\r\n";
	$headers[] = 'Content-Type: ' . get_bloginfo('html_type') . '; charset=\"'. get_bloginfo('charset') . '\"'."\r\n";
	$headers[] = 'Content-type: text/html'."\r\n";				
	
	wp_mail($from,$subjects,$content,$headers);
	$wpdb->query("delete from ".$table_name_parsed_emails." where id=".$delid);
	wpmg_redirectTo("wpmg_mailinggroup_message_moderation&info=upd_inform");
	exit;
}

if($info=="upd_app") {
	wpmg_showmessages("updated", __("Message(s) has been Approved successfully.", 'mailing-group-module'));
}
if($info=="upd") {
	wpmg_showmessages("updated", __("Message(s) has been deleted successfully.", 'mailing-group-module'));
}
if($info=="upd_inform") {
	wpmg_showmessages("updated", __("Message(s) has been deleted successfully and inform to sender via email.", 'mailing-group-module'));
}
$result = $objMem->selectRows($table_name_parsed_emails, "",  " where status IN(6,7,8,9)");
$totcount = count($result);
if ($totcount>0) {
?>
<script type="text/javascript">
	/* <![CDATA[ */
	jQuery(document).ready(function(){
		/* Build the DataTable with third column using our custom sort functions */
		jQuery('#archivelist').DataTable( {
		    "searchHighlight": true,
			"aoColumns": [ 
				null,
				null,
				null,
				{ "bVisible": false },				
				{ "bVisible": false },
				null,
				null
			],
			"aoColumnDefs": [ 
			  { "bSortable": true,
			  	"aTargets": [ 0,1,2,3,4,5,6,7,8 ],
			  }
			],
			"fnDrawCallback":function(){
				if('<?php echo $totcount; ?>'<=5){
					document.getElementById('archivelist_paginate').style.display = "none";
				} else {
					document.getElementById('archivelist_paginate').style.display = "block";
				}
			}
		} );
		
		//jQuery('body').on('click', '.quick_view', function() {
		jQuery('body').on('click', '.quick_view', function() { jQuery('#archivelist > tbody  > tr').each(function() { jQuery(this).closest('tr').css("background-color","#F9F9F9"); }); jQuery(this).closest('tr').css("background-color","#FEA03D"); var thisId = this.name; var data = { action: 'wpmg_viewmessage', page: 'wpmg_mailinggroup_viewmessage',id:thisId}; jQuery.post(ajaxurl, data, function(response) {/* alert(response); */jQuery("#ajaxContent").html(response); jQuery("#ajaxstart").focus(); });});

		//jQuery('.quick_view').click(function(){ jQuery('#archivelist > tbody  > tr').each(function() { jQuery(this).closest('tr').css("background-color","#F9F9F9"); }); jQuery(this).closest('tr').css("background-color","#FEA03D"); var thisId = this.name; var data = { action: 'wpmg_viewmessage', page: 'mailinggroup_viewmessage',id:thisId}; jQuery.post(ajaxurl, data, function(response) {/* alert(response); */jQuery("#ajaxContent").html(response); jQuery("#ajaxstart").focus(); });});
		
		jQuery("#toplevel_page_mailinggroup_intro").removeClass('wp-not-current-submenu');
		jQuery("#toplevel_page_mailinggroup_intro").addClass('wp-has-current-submenu');
		jQuery("#toplevel_page_mailinggroup_intro ul :nth-child(3)").addClass("current");
	});
	/* ]]> */
</script>
<?php } ?>
<?php
$resultgp = $objMem->selectRows($table_name_group, "",  "");
if (count($resultgp)>0) {
	foreach ($resultgp as $rowgp) {
		$groupName = $rowgp->title;
	}
}
?>
<form name="moderationrequest" id="moderationrequest" action="" method="post">
    <div class="wrap">
        <h2><?php _e("Message Moderation ", 'mailing-group-module'); ?> <a href='admin.php?page=wpmg_mailinggroup_message_moderation'><?php _e('Back', 'mailing-group-module'); ?></a></h2>
        <?php
		if (count($result)>0) {
		?>
		<div class="tablenav top">
			<div class="alignleft actions">
				<select name="mass_action" id="mass_action">
					<option selected="selected" value=""><?php _e("Bulk actions", 'mailing-group-module'); ?></option>
					<option value="1"><?php _e("Approve Selected", 'mailing-group-module'); ?></option>
					<option value="2"><?php _e("Delete Selected", 'mailing-group-module'); ?></option>
					<option value="3"><?php _e("Delete & Inform to Sender", 'mailing-group-module'); ?></option>
				</select>
				<input type="submit" id="doaction" name="Save" value="<?php _e("Apply", 'mailing-group-module'); ?>" />
			</div>
			<br class="clear">
		</div>	
        <?php
		}
		?>		
		<table class="wp-list-table widefat fixed" id="archivelist">
            <thead>
                <tr role="row" class="topRow header_tab">
                    <th style="text-align:center" scope="col" class="check-column" width="4%"><input type="checkbox" /></th>
                    <th><?php _e("Sender", 'mailing-group-module'); ?></th>
                    <th><?php _e("Name", 'mailing-group-module'); ?></th>
                    <th><?php _e("Subject", 'mailing-group-module'); ?></th>
					<th><?php _e("Body", 'mailing-group-module'); ?></th>
                    <th><?php _e("Content", 'mailing-group-module'); ?></th>
                    <th><?php _e("Group", 'mailing-group-module'); ?></th>
					<th><?php _e("Moderation", 'mailing-group-module'); ?></th>					
                    <th><?php _e("Actions", 'mailing-group-module'); ?></th>
                </tr>
            </thead>
            <tfoot>
                <tr role="row" class="topRow header_tab">
                    <th style="text-align:center" scope="col" class="check-column" width="4%"><input type="checkbox" /></th>
                    <th><?php _e("Sender", 'mailing-group-module'); ?></th>
                    <th><?php _e("Name", 'mailing-group-module'); ?></th>
                    <th><?php _e("Subject", 'mailing-group-module'); ?></th>
					<th><?php _e("Body", 'mailing-group-module'); ?></th>
                    <th><?php _e("Content", 'mailing-group-module'); ?></th>
                    <th><?php _e("Group", 'mailing-group-module'); ?></th>
					<th><?php _e("Moderation", 'mailing-group-module'); ?></th>
                    <th><?php _e("Actions", 'mailing-group-module'); ?></th>
                </tr>
            </tfoot>			
            <tbody>
    		<?php
			if ($totcount>0) {
				foreach ($result as $row) {
				    $id = $emailId = $row->id;
					$sender  = $row->email_from;
					$name    = $row->email_from_name;
					$subject = $row->email_subject;
					$content = $row->email_content;
					$gid     = $row->email_group_id;
					$mod     = $row->status;
					     if($mod == 9){$mod_type = 'All Members';
					}elseif($mod == 8){$mod_type = 'New Members';
					}elseif($mod == 7){$mod_type = 'Specific Members';
					}elseif($mod == 6){$mod_type = 'Specific Text';}
					
					$resultGroup = $objMem->selectRows($table_name_group, "",  " where id = '".$gid."'");
				    $grpTitle = $resultGroup[0]->title;
				?>
				<tr>
					<td align="center" scope="row" class="check-column"><input type="checkbox" name="deletemsg[]" id="selector" value="<?php echo $id;?>" /></td>
					<td><?php echo $sender; ?></td>
					<td><?php echo $name; ?></td>
					<td><a href="#ajaxstart" title="<?php _e("View", 'mailing-group-module'); ?>" class="quick_view" name="<?php echo $emailId;?>"><?php echo $subject; ?></a></td>
                    <td><?php echo $content; ?></td>
					<td><?php echo wp_trim_words( $content, 20, '<a href="#ajaxstart" title="Read More" class="quick_view" name="'.$emailId.'">...Read More</a>' ); ?></td>
					<td><?php echo $grpTitle; ?></td>
					<td><?php echo $mod_type; ?></td>
					<td class="last">
				    	<a class="approve_record thickbox" title="<?php _e("Approve", 'mailing-group-module'); ?>" href="admin.php?page=wpmg_mailinggroup_message_moderation&act=approve&eid=<?php echo $emailId;?>&did=<?php echo $emailId;?>" onclick="return confirm('<?php _e("Are you sure you want to approve this message?", 'mailing-group-module'); ?>');"></a>|
					    <a class="send_mail thickbox" title="<?php _e("Delete and Inform to Sender", 'mailing-group-module'); ?>" href="admin.php?page=wpmg_mailinggroup_message_moderation&act=del_inform&eid=<?php echo $emailId;?>&did=<?php echo $emailId;?>" onclick="return confirm('<?php _e("Are you sure you want to delete these message(s) and inform the sender?", 'mailing-group-module'); ?>');"></a>|
						<a class="delete_record" title="<?php _e("Delete", 'mailing-group-module'); ?>" href="admin.php?page=wpmg_mailinggroup_message_moderation&act=del&did=<?php echo $emailId;?>" onclick="return confirm('<?php _e("Delete Selected Message(s).", 'mailing-group-module'); ?>');"></a>|
						<a href="#ajaxstart" class="view_record quick_view" title="<?php _e("View", 'mailing-group-module'); ?>" name="<?php echo $emailId;?>"></a>
					</td>
				</tr>
				<?php
				}
			} else { ?>
				<tr>
					<td colspan="6" align="center"><?php _e("There are currently no messages in the archive.", 'mailing-group-module'); ?></td>
				<tr>
			<?php } ?>
        	</tbody>
        </table>
        <?php
		if (count($result)>0) {
		?>		
		<div class="tablenav top">
			<div class="alignleft actions">
				<select name="mass_action2" id="mass_action2">
					<option selected="selected" value=""><?php _e("Bulk actions", 'mailing-group-module'); ?></option>
					<option value="1"><?php _e("Approve Selected", 'mailing-group-module'); ?></option>
					<option value="2"><?php _e("Delete Selected", 'mailing-group-module'); ?></option>
					<option value="3"><?php _e("Delete & Inform to Sender", 'mailing-group-module'); ?></option>
				</select>
				<input type="submit" id="doaction2" name="Save" value="<?php _e("Apply", 'mailing-group-module'); ?>" />
			</div>
			<br class="clear">
		</div>		
        <?php
		}
		?>
        <a href="#" id="ajaxstart" name="ajaxstart"></a>
        <div id="ajaxContent" class="ajaxContent"></div>
    </div>
</form>