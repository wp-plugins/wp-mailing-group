<?php
$status = get_option( 'wpmg_mailing_license_status' );	
if($status == 'invalid'){die();}
$WPMG_SETTINGS = get_option("WPMG_SETTINGS");
$versionno     = $WPMG_SETTINGS["MG_VERSION_NO"];
$plugintype    = $WPMG_SETTINGS["MG_PLUGIN_TYPE"];
$websiteurl    = $WPMG_SETTINGS["MG_WEBSITE_URL"];
?>
<style>
.form-table th, .form-wrap label {
	width:160px !important;
}
</style>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#toplevel_page_mailinggroup_intro").removeClass('wp-not-current-submenu');
		jQuery("#toplevel_page_mailinggroup_intro").addClass('wp-has-current-submenu');
		jQuery(".toplevel_page_mailinggroup_intro").removeClass('wp-not-current-submenu');
		jQuery(".toplevel_page_mailinggroup_intro").addClass('wp-has-current-submenu');
		jQuery("#toplevel_page_mailinggroup_intro ul li.wp-first-item").addClass("current");
	});
</script>
<div class="wrap">
	<h2 class="nav-tab-wrapper">
        <a href="admin.php?page=wpmg_mailinggroup_intro" title="<?php _e("Introduction", 'mailing-group-module'); ?>" class="nav-tab"><?php _e("Introduction", 'mailing-group-module'); ?></a>
        <a href="admin.php?page=wpmg_mailinggroup_messagelist" class="nav-tab" title="<?php _e("Custom Messages", 'mailing-group-module'); ?>"><?php _e("Custom Messages", 'mailing-group-module'); ?></a>
		<a href="admin.php?page=wpmg_mailinggroup_adminmessagelist" class="nav-tab" title="<?php _e("Admin Messages", 'mailing-group-module'); ?>"><?php _e("Admin Messages", 'mailing-group-module'); ?></a>
        <a href="admin.php?page=wpmg_mailinggroup_style" class="nav-tab" title="<?php _e("Stylesheet", 'mailing-group-module'); ?>"><?php _e("Stylesheet", 'mailing-group-module'); ?></a>
        <?php if($plugintype=='PAID') { ?>
        	<a href="admin.php?page=wpmg_mailinggroup_contact" class="nav-tab" title="<?php _e("Contact", 'mailing-group-module'); ?>"><?php _e("Premium Support", 'mailing-group-module'); ?></a>
        <?php } ?>
        <a href="admin.php?page=wpmg_mailinggroup_help" class="nav-tab nav-tab-active" title="<?php _e("Help", 'mailing-group-module'); ?>"><?php _e("Help", 'mailing-group-module'); ?></a>
    </h2>
   <div>
    	<h3><?php echo sprintf( __('Mailing Group Module Help (Version : %s)','mailing-group-module'), $versionno ); ?></h3>
    </div>
    <div class="div800">
    	<a name="top"><h3><?php _e("Overview", 'mailing-group-module'); ?></h3></a>
		<ul>
			<li><a href="#quickstart"><?php _e("Quick Start", 'mailing-group-module'); ?></a></li>
			<li><a href="#registration"><?php _e("Registration Form Shortcode", 'mailing-group-module'); ?></a></li>
			<li><a href="#installation"><?php _e("Cron Scripts / Scheduled Tasks", 'mailing-group-module'); ?></a></li>
			<li><a href="#upgrading"><?php _e("Access to Premium Support", 'mailing-group-module'); ?></a></li>
		</ul>
		<br>
		<a name="quickstart"><h3><?php _e("Quick Start", 'mailing-group-module'); ?></h3></a>
		<?php _e("For a quick start guide in just six steps, please refer to the FAQ here:", 'mailing-group-module'); ?> <a href="http://www.wpmailinggroup.com/faq/quick-start-in-6-steps/" target="_blank">www.wpmailinggroup.com/faq/quick-start-in-6-steps/</a><br><br>

		<a name="registration"><h3><?php _e("Registration Form Shortcode", 'mailing-group-module'); ?></h3></a>
		<?php _e("Insert the following registration form shortcode on a page or widget on your website to allow users to subscribe:", 'mailing-group-module'); ?><br />
		<b>[mailing_group_form]</b><br /><br>
		<?php _e("There is more information on attributes that can be used in the Shortcode here:", 'mailing-group-module'); ?><br>
		<a href="http://www.wpmailinggroup.com/faq/shortcodes/" target="_blank">www.wpmailinggroup.com/faq/shortcodes/</a><br><br />

		<?php _e("Style settings can be done from Mailing Group Manager -> General Settings -> Stylesheet", 'mailing-group-module'); ?><br />
		<br>

		<a href="#top"><?php _e("^Back to top", 'mailing-group-module'); ?></a><br>
		<br>

		&nbsp;
		<a name="installation"><h3><?php _e("Cron Scripts / Scheduled Tasks your server", 'mailing-group-module'); ?></h3></a>
		<em><?php _e("Overview:", 'mailing-group-module'); ?></em> <br>
		<?php _e("This plugin automatically runs every time a visitor comes to your website, through an automatic call to the in-built WordPress Cron Manager (wp-cron). This will trigger the email box specified for the Mailing Group to be checked for new messages, for queued messages to be sent on to all registered members, and for any bounced messages to be checked.", 'mailing-group-module'); ?> <br><br>

		<?php _e("If you have visitors coming to your site every few minutes on average, this should be sufficient for the plugin to run smoothly, with the sending and receiving of Mailing Group messages. If, however, you have a lower traffic website, the plugin will benefit from you setting up a Cron Manager / Scheduled Task call via the control panel on your web server.", 'mailing-group-module'); ?><br><br>

		<?php _e("If you do not have access to Cron / Scheduled Task settings on your web server, the plugin will still run, but email messages will only be received and sent on when your website is visited. It does not have to be a logged-in or registered user: ANY visitor who loads ANY page of the site that contains WordPress code is sufficient.", 'mailing-group-module'); ?><br><br>

		<em><?php _e("Settings:", 'mailing-group-module'); ?></em><br>
		(<?php _e("This step is not necessary on high traffic websites, with visitors every couple of minutes or more often.", 'mailing-group-module'); ?>)<br><br>

		<?php _e("In the Cron Manager on your website, locate the Command field, and paste the line below making sure you change <em>www.yoursite.com</em> to the WordPress installation on your own web server:", 'mailing-group-module'); ?><br><br>

		<strong>wget http://<em>www.yoursite.com</em>/wp-cron.php</strong><br><br>

		<?php _e("On some systems, you may need to use a curl function instead:", 'mailing-group-module'); ?><br>
		<strong>curl -s http://<em>www.yoursite.com</em>/wp-cron.php</strong><br><br>

		<em><?php _e("Further information:", 'mailing-group-module'); ?></em><br>
		<?php _e("For more information on how to set up the crons on your server, please refer to the documentation below for your control panel type:", 'mailing-group-module'); ?><br><br>

		>From cPanel:<br>http://docs.cpanel.net/twiki/bin/view/AllDocumentation/CpanelDocs/CronJobs<br><br>

		>From Plesk:<br>http://www.hosting.com/support/plesk/crontab/<br><br>

		>From Telnet / Putty / Command line (for Advanced Users):<br>
		http://www.web-site-scripts.com/knowledge-base/article/AA-00484/0/Setup-Cron-job-on-Linux-UNIX-via-command-line.html<br>
		<br>
		<a href="#top"><?php _e("^Back to top", 'mailing-group-module'); ?></a><br>
		<br>

		<!-- echo __('<a name="upgrading"><h3>Upgrading to Premium version</h3></a>', 'mailing-group-module');
        echo __('<p>Upgrading to the Premium plugin version adds many extra benefits. You can host unlimited Mailing Groups on your WordPress installation, keep searchable Archives of the messages, find messages by the individual member who posted them, and import members from external .VCF files.<br /><br />To upgrade, please deactivate and delete the Free plugin. Do not worry about your existing Mailing Group settings: all the data will be saved - only the unnecessary Free plugin files will be deleted. After uploading the Premium plugin and activating it, your existing Mailing Group will be ready and waiting for you on the list!</p>', 'mailing-group-module');
		echo sprintf( __('<a href="%s" target="_blank">Upgrade Now ></a>', 'mailing-group-module') , $websiteurl ); -->
		<a name="upgrading"><h3><?php _e("Access to Premium Support", 'mailing-group-module'); ?></h3></a>
        <p><?php _e("Please click the Premium Support tab to gain access to the support ticket system which is reserved exclusively for Premium plugin users.", 'mailing-group-module'); ?></p>
		
    <br><br><a href="#top"><?php _e("^Back to top", 'mailing-group-module'); ?></a><br>
    </div>
</div>