<?php

/* get all variables */
$mail_type = (isset($_REQUEST["type"])? sanitize_text_field($_REQUEST["type"]): '');
$gid  = (isset($_REQUEST["gid"])? sanitize_text_field($_REQUEST["gid"]): '');

/* get all variables */
if(isset($gid) && $gid!=''){
	$result = $objMem->selectRows($table_name_group, $gid);
	if (count($result) > 0 )
	{
		foreach($result as $resultGroup)
		{
		    $toName  = 'WP Mailing Group';
			//$to      = 'gurwindersinghaulakh@gmail.com';
            $to      = get_option( 'admin_email' );			
			$subject = $mail_type.' Test Mail Connection';
			$body    = 'This is just demo email connection mail';
			if($mail_type == 'smtp'){
				require_once(WPMG_PLUGIN_PATH.'/lib/class.phpmailer.php');						
				$mail = new PHPMailer();	
				$mail->IsSMTP(); 				
				$mail->SMTPDebug = 1; 		
		
				if($resultGroup->smtp_username!='' && $resultGroup->smtp_password!='') {	
					$mail->Username   = $resultGroup->smtp_username; 	
					$mail->Password   = $resultGroup->smtp_password; 
					$mail->SMTPAuth   = true;								
					$mail->SMTPSecure = "ssl";	
																	
				} else {				
					$mail->Username   = $resultGroup->email; 	
					$mail->Password   = $resultGroup->password; 
					$mail->SMTPAuth   = false;								
				}	
				$mail->Host    = $resultGroup->smtp_server; 		
				$mail->Port    = $resultGroup->smtp_port; 							
				$mail->Sender  = $resultGroup->email; 	
						
				$mail->Subject = $subject;	
				$mail->IsHTML(true);				
				$mail->MsgHTML($body);	
					
				$mail->AddAddress($to, $toName);	
				if(!$mail->Send()) {				
                    echo 'failed';	
				} else {							
                    echo 'success';	
				}						
			}      			
			if($mail_type == 'php'){	

				$headers .= 'X-Mailer: PHP' . phpversion() . "\r\n";
				$headers .= 'MIME-Version: 1.0'."\r\n";
				$headers .= 'Content-Type: ' . get_bloginfo('html_type') . '; charset=\"'. get_bloginfo('charset') . '\"'."\r\n";
		 	    $headers .= 'Content-type: text/html'."\r\n";				
	
				$php_sent = mail($to, $subject, $body, $headers);

				if($php_sent) {				
                    echo 'success';	
				} else {					
                    echo 'failed';						
				}											
			}							
			if($mail_type == 'wp'){	
							
				$headers[] = 'X-Mailer: PHP' . phpversion() . "\r\n";
				$headers[] = 'MIME-Version: 1.0'."\r\n";
				$headers[] = 'Content-Type: ' . get_bloginfo('html_type') . '; charset=\"'. get_bloginfo('charset') . '\"'."\r\n";
			    $headers[] = 'Content-type: text/html'."\r\n";				
					
				$wp_sent = wp_mail( $to,$subject,$body,$headers);
							
				if($wp_sent) {				
                    echo 'success';	
				} else {					
                    echo 'failed';						
				}						
			}				
		}
	}
}

?>