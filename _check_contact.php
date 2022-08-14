<?php require_once("_top.php");
require_once("admin/config/config.php");  
require_once("admin/config/function.php");  
$name     = (!empty($_POST['name']))?FilterInput(strval($_POST['name'])):null; 
$phone    = (!empty($_POST['phone']))?FilterInput(strval($_POST['phone'])):null; 
$emailid  = (!empty($_POST['emailid']))?FilterInput(strval($_POST['emailid'])):null;
$subject = (!empty($_POST['subject']))?FilterInput(strval($_POST['subject'])):null; 
$message  = (!empty($_POST['message']))?FilterInput(strval($_POST['message'])):null; 

if (empty($name) OR empty($phone) OR empty($emailid) OR empty($subject) OR empty($message)) {
    echo $response = json_encode(array(
            "status" => false,
            "msg"    => "<div class='alert alert-danger'><strong>Enter the Details!</strong></div>" 
    ));
    die();
}
if (!ctype_digit($phone) OR strlen($phone)!=10) {
    echo $response = json_encode(array(
            "status" => false,
            "msg"    => "<div class='alert alert-danger'><strong>Enter 10 Digit Mobile Number!</strong></div>" 
    ));
    die();
}
if(!preg_match('/^[6-9][0-9]{9}$/',$phone)) {
    echo $response = json_encode(array(
            "status" => false,
            "msg"    => "<div class='alert alert-danger'><strong>Phone Number is Not Valid!</strong></div>" 
    ));
    die();
}
if (!filter_var($emailid, FILTER_VALIDATE_EMAIL)) {
    echo $response = json_encode(array(
            "status" => false,
            "msg"    => "<div class='alert alert-danger'><strong>Email ID is Not in Valid form!</strong></div>" 
    ));
    die();
} 

$time= Date('Y-m-d H:i:s');

$mail_subject = 'Quick Enquiry From North-East Car Rentals';
$emailmsg = '<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Quick Enquiry From North-East Car Rentals</title>
<style>img{border:none;-ms-interpolation-mode:bicubic;max-width:100%}body{background-color:#f6f6f6;font-family:sans-serif;-webkit-font-smoothing:antialiased;font-size:14px;line-height:1.4;margin:0;padding:0;-ms-text-size-adjust:100%;-webkit-text-size-adjust:100%}table{border-collapse:separate;mso-table-lspace:0;mso-table-rspace:0;width:100%}table td{font-family:sans-serif;font-size:14px;vertical-align:top}.body{background-color:#f6f6f6;width:100%}.container{display:block;margin:0 auto!important;max-width:580px;padding:10px;width:580px}.content{box-sizing:border-box;display:block;margin:0 auto;max-width:580px;padding:10px}.main{background:#fff;border-radius:3px;width:100%}.wrapper{box-sizing:border-box;padding:20px}.content-block{padding-bottom:10px;padding-top:10px}.footer{clear:both;margin-top:10px;text-align:center;width:100%}.footer td,.footer p,.footer span,.footer a{color:#999;font-size:12px;text-align:center}h1,h2,h3,h4{color:#000;font-family:sans-serif;font-weight:400;line-height:1.4;margin:0;margin-bottom:30px}h1{font-size:35px;font-weight:300;text-align:center;text-transform:capitalize}p,ul,ol{font-family:sans-serif;font-size:14px;font-weight:400;margin:0;margin-bottom:15px}p li,ul li,ol li{list-style-position:inside;margin-left:5px}a{color:#3498db;text-decoration:underline}.btn{box-sizing:border-box;width:100%}.btn > tbody > tr > td{padding-bottom:15px}.btn table{width:auto}.btn table td{background-color:#fff;border-radius:5px;text-align:center}.btn a{background-color:#fff;border:solid 1px #3498db;border-radius:5px;box-sizing:border-box;color:#3498db;cursor:pointer;display:inline-block;font-size:14px;font-weight:700;margin:0;padding:12px 25px;text-decoration:none;text-transform:capitalize}.btn-primary table td{background-color:#3498db}.btn-primary a{background-color:#3498db;border-color:#3498db;color:#fff}.last{margin-bottom:0}.first{margin-top:0}.align-center{text-align:center}.align-right{text-align:right}.align-left{text-align:left}.clear{clear:both}.mt0{margin-top:0}.mb0{margin-bottom:0}.preheader{color:transparent;display:none;height:0;max-height:0;max-width:0;opacity:0;overflow:hidden;mso-hide:all;visibility:hidden;width:0}.powered-by a{text-decoration:none}hr{border:0;border-bottom:1px solid #f6f6f6;margin:20px 0}@media only screen and (max-width: 620px){table[class=body] h1{font-size:28px!important;margin-bottom:10px!important}table[class=body] p,table[class=body] ul,table[class=body] ol,table[class=body] td,table[class=body] span,table[class=body] a{font-size:16px!important}table[class=body] .wrapper,table[class=body] .article{padding:10px!important}table[class=body] .content{padding:0!important}table[class=body] .container{padding:0!important;width:100%!important}table[class=body] .main{border-left-width:0!important;border-radius:0!important;border-right-width:0!important}table[class=body] .btn table{width:100%!important}table[class=body] .btn a{width:100%!important}table[class=body] .img-responsive{height:auto!important;max-width:100%!important;width:auto!important}}@media all{.ExternalClass{width:100%}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%}.apple-link a{color:inherit!important;font-family:inherit!important;font-size:inherit!important;font-weight:inherit!important;line-height:inherit!important;text-decoration:none!important}#MessageViewBody a{color:inherit;text-decoration:none;font-size:inherit;font-family:inherit;font-weight:inherit;line-height:inherit}.btn-primary table td:hover{background-color:#34495e!important}.btn-primary a:hover{background-color:#34495e!important;border-color:#34495e!important}}
.sub{font-size:22px;text-align:center;font-weight:600;color:green;margin-bottom:15px;text-transform:uppercase;}
.table-bordered{border: 1px solid #ddd;border-collapse:collapse;border-spacing:0;margin-bottom:15px;}
.table-bordered>tbody>tr>td{border: 1px solid #ddd;padding:8px}
.table-bordered a{text-decoration:none;}
@media screen and (max-width: 767px){
.table-responsive {width: 100%;margin-bottom: 15px;overflow-y: hidden;-ms-overflow-style: -ms-autohiding-scrollbar;border: 1px solid #ddd;min-height: .01%;overflow-x: auto;}
.table-responsive>tr>td {white-space: nowrap;}
}
</style>
</head>
<body class="">
<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
<tr>
<td>&nbsp;</td>
<td class="container">
<div class="content">
<table role="presentation" class="main">
<tr>
<td class="wrapper">
<h2 class="sub">Quick Enquiry</h2>
<table class="table-bordered table-responsive">
<tr>
<td>Name</td>
<td colspan="3">'.stripslashes(nl2br($name)).'</td>
</tr>
<tr>
<td>Phone</td>
<td>'.($phone).'</td>
</tr> 
<tr>
<td>Email</td>
<td>'.stripslashes(nl2br($emailid)).'</td>
<td>Subject</td>
<td>'.($subject).'</td>
</tr>
<tr>
<td>Message</td>
<td>'.$message.'</td>
</tr>
<tr>
<td>Enquired At</td>
<td>'.date("d-M-Y H:i",strtotime($time)).'</td>
<td>IP</td>
<td>'.$ip.'</td>
</tr>
</table>
</td>
</tr>
</table>
<div class="footer">
<table role="presentation" border="0" cellpadding="0" cellspacing="0">
<tr>
<td class="content-block powered-by">Powered by <a target="_blank" href="http://www.aayushholidays.in">North-East Car Rentals</a>.</td>
</tr>
</table>
</div>
</div>
</td>
<td>&nbsp;</td>
</tr>
</table>
</body>
</html>';
    require 'vendor/autoload.php';  
    require 'vendor/phpmailer/phpmailer/src/Exception.php';
    require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'vendor/phpmailer/phpmailer/src/SMTP.php';
    $mail = new PHPMailer\PHPMailer\PHPMailer();          
    try {
        $mail->SMTPDebug =0;                                 
        // $mail->isSMTP();                                    
        $mail->Host = 'mail.aayushholidays.in';                            
        $mail->SMTPAuth = false;                               
        $mail->Username = 'enquiry@aayushholidays.in';                 
        $mail->Password = "U2xYdF7Wt7^*";                           
        $mail->SMTPSecure = 'ssl';                            
        $mail->Port = 587;                                   
        $mail->setFrom('enquiry@aayushholidays.in', 'North-East Car Rentals');
        $mail->addAddress('aayushleisureholiday@gmail.com');
        //$mail->addAddress('aayushleisureholiday@gmail.com');                                    
        //$mail->addReplyTo($emailid, "North-East Car Rentals");
        $mail->isHTML(true);                                 
        $mail->Subject = 'Online Enquiry';
        $mail->Body    = $emailmsg;
        if(!$mail->Send()){} 
    } catch (Exception $e) {} 




$sql = "INSERT INTO enquiry SET
            enq_name           = :enq_name,
            enq_phone          = :enq_phone,
            enq_email          = :enq_email,
            enq_subject        = :enq_subject,
            enq_message        = :enq_message,
            enq_ip             = :enq_ip";
            $insert = $PDO->prepare($sql);
            $insert->bindParam(':enq_name',$name);
            $insert->bindParam(':enq_phone',$phone);
            $insert->bindParam(':enq_email',$emailid);
            $insert->bindParam(':enq_message',$message);
            $insert->bindParam(':enq_subject',$subject);
            $insert->bindParam(':enq_ip',$ip);
            $insert->execute();
            if($insert->rowCount() > 0){
                echo $response = json_encode(array(
                    "status" => true,
                    "msg"    => "Thank-You" 
            ));
            }
            else {
                echo $response = json_encode(array(
                    "status" => false,
                    "msg"    => "<div class='alert alert-danger'><strong>Something is wrong</strong></div>" 
            ));
            }