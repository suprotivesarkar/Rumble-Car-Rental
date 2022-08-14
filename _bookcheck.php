<?php require_once("_top.php");
require_once("admin/config/config.php");  
require_once("admin/config/function.php");  
$fromloc  = (!empty($_POST['fromloc']))?FilterInput(strval($_POST['fromloc'])):null; 
//$fid     = (!empty($_POST['fid']))?FilterInput(strval($_POST['fid'])):null; 
$toloc    = (!empty($_POST['toloc']))?FilterInput(strval($_POST['toloc'])):null; 
//$eid     = (!empty($_POST['eid']))?FilterInput(strval($_POST['eid'])):null; 
$date    = (!empty($_POST['date']))?FilterInput(strval($_POST['date'])):null; 
$people  = (!empty($_POST['people']))?FilterInput(strval($_POST['people'])):null; 
$vehical = (!empty($_POST['vehical']))?FilterInput(strval($_POST['vehical'])):null; 
$service = (!empty($_POST['service']))?FilterInput(strval($_POST['service'])):null; 
$name     = (!empty($_POST['name']))?FilterInput(strval($_POST['name'])):null; 
$phone    = (!empty($_POST['phone']))?FilterInput(strval($_POST['phone'])):null; 
$emailid  = (!empty($_POST['emailid']))?FilterInput(strval($_POST['emailid'])):null; 
$address  = (!empty($_POST['address']))?FilterInput(strval($_POST['address'])):null; 
$altphone = (!empty($_POST['altphone']))?FilterInput($_POST['altphone']):null; 
$message  = (!empty($_POST['message']))?FilterInput(strval($_POST['message'])):null; 
$pickpoint = (!empty($_POST['pickpoint']))?FilterInput(strval($_POST['pickpoint'])):null; 
$picktime  = (!empty($_POST['picktime']))?FilterInput(strval($_POST['picktime'])):null; 



if (empty($fromloc) OR empty($toloc)) {
    echo $response = json_encode(array(
            "status" => false,
            "msg"    => "<div class='alert alert-danger'><strong>Enter Contact Details!</strong></div>" 
    ));
    die();
}



if(!preg_match('/^(?:0[1-9]|1[0-9]):[0-5][0-9]$/',$picktime)) {
    echo $response = json_encode(array(
            "status" => false,
            "msg"    => "<div class='alert alert-danger'><strong>Check Pick Up Time Format!</strong></div>" 
    ));
    die();
}

if (empty($pickpoint)) {
    echo $response = json_encode(array(
            "status" => false,
            "msg"    => "<div class='alert alert-danger'><strong>Enter Pickup Point!</strong></div>" 
    ));
    die();
}
if (empty($service) OR !ctype_digit($service)) {
    echo $response = json_encode(array(
            "status" => false,
            "msg"    => "<div class='alert alert-danger'><strong>Select Service</strong></div>" 
    ));
    die();
}
$servicename = ServiceList($service);
if (empty($servicename)) {
    echo $response = json_encode(array(
            "status" => false,
            "msg"    => "<div class='alert alert-danger'><strong>Select a Service Type</strong></div>" 
    ));
    die();
}
// if (empty($fromloc) OR empty($fid) OR !ctype_digit($fid)) {
//     echo $response = json_encode(array(
//             "status" => false,
//             "msg"    => "<div class='alert alert-danger'><strong>Form Point Not Found!</strong></div>" 
//     ));
//     die();
// }
// $chk_exists = CheckExists("locations","loc_id = '$fid' AND loc_status=1 AND loc_name='$fromloc'");
// if (empty($chk_exists)) {

//     $chk_exists = CheckExists("location_aliases","loc_id_ref_la = '$fid' AND la_status=1 AND la_name='$fromloc'");
//     if (empty($chk_exists)) {
//         echo $response = json_encode(array(
//                 "status" => false,
//                 "msg"    => "<div class='alert alert-danger'><strong>Pickup Point Not Found!</strong></div>" 
//         ));
//         die();
//     }
//     $sname = $chk_exists['la_name'];
// }else{
//     $sname = $chk_exists['loc_name'];
// }

// if (empty($toloc) OR empty($eid) OR !ctype_digit($eid)) {
//     echo $response = json_encode(array(
//             "status" => false,
//             "msg"    => "<div class='alert alert-danger'><strong>Drop Location Not Found!</strong></div>" 
//     ));
//     die();
// }
// $chk_exists = CheckExists("locations","loc_id = '$eid' AND loc_status=1 AND loc_name='$toloc'");
// if (empty($chk_exists)) {
//     $chk_exists = CheckExists("location_aliases","loc_id_ref_la = '$eid' AND la_status=1 AND la_name='$toloc'");
//     if (empty($chk_exists)) {
//         echo $response = json_encode(array(
//                 "status" => false,
//                 "msg"    => "<div class='alert alert-danger'><strong>End Point Not Found!</strong></div>" 
//         ));
//         die();
//     }
//     $ename  = $chk_exists['la_name'];
// }else{
//     $ename  = $chk_exists['loc_name'];
// }

$date  = date("Y-m-d",strtotime($date)); 
$today = Date('Y-m-d');
$today = date('Y-m-d', strtotime($today . ' +2 day'));
if (!($date >= $today)) {
    echo $response = json_encode(array(
            "status" => false,
            "msg"    => "<div class='alert alert-danger'><strong>Date Must Be greater than equal to today!</strong></div>" 
    ));
    die();
}
if (empty($people) OR !ctype_digit($people) OR $people<=0) {
    echo $response = json_encode(array(
            "status" => false,
            "msg"    => "<div class='alert alert-danger'><strong>Enter total Number of people in Numerical form ex. 5</strong></div>" 
    ));
    die();
}

if (empty($name) OR empty($phone) OR empty($emailid) OR empty($address)) {
    echo $response = json_encode(array(
            "status" => false,
            "msg"    => "<div class='alert alert-danger'><strong>Enter Contact Details!</strong></div>" 
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

if (empty($vehical) OR !ctype_digit($vehical)) {
    echo $response = json_encode(array(
            "status" => false,
            "msg"    => "<div class='alert alert-danger'><strong>Select a Vehical Type</strong></div>" 
    ));
    die();
}
$vehicalname = VehicalList($vehical);
if (empty($vehicalname)) {
    echo $response = json_encode(array(
            "status" => false,
            "msg"    => "<div class='alert alert-danger'><strong>Select a Vehical Type</strong></div>" 
    ));
    die();
}

$wantsightseeing  = (!empty($_POST['wantsightseeing']))?FilterInput(strval($_POST['wantsightseeing'])):null; 
$sighttxt = null;
if ($wantsightseeing==1){
    $sightseeing=$_POST['sightseeing'];
    foreach($sightseeing as $k) {
        if (!empty($k['jdate']) AND !empty($k['visitloc'])){
            $sighttxt.=$k['jdate'].'|'.$k['visitloc'].'~@~';
        }
    }
}
if (!empty($sighttxt)){
    $sighttxt = rtrim(trim($sighttxt),"~@~");
}
 
$sighttxtemail = null;
if(!empty($sighttxt)){ 
$sightarr = explode('~@~',$sighttxt); 
    $sighttxtemail .= '<td colspan="4" align="center" style="text-align:center">Sightseeing</td>
                  </tr>';
    foreach ($sightarr as $sights){ 
        $now= explode('|',$sights);
        $sighttxtemail .=    '<tr>
            <td>Date</td>
            <td>'.date('d-M-Y', strtotime($now[0])).'</td>
            <td>Location</td>
            <td>'.$now[1].'</td>
            </tr>';
    }
}

$subject = 'New Car Enquiry From North-East Car Rentals';
$emailmsg = '<!doctype html>
<html>
<head>
<meta name="viewport" content="width=device-width" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>New Car Enquiry From North-East Car Rentals</title>
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
<h2 class="sub">New Car Enquiry</h2>
<table class="table-bordered table-responsive">
<tr>
<td>Contact Person</td>
<td colspan="3">'.stripslashes(nl2br($name)).'</td>
</tr>
<tr>
<td>Email</td>
<td>'.stripslashes(nl2br($emailid)).'</td>
<td>Phone</td>
<td>'.($phone.(!empty($altphone)?'/'.$altphone:null)).'</td>
</tr> 
<tr>
<td>Pickup</td>
<td>'.$fromloc.'</td>
<td>Drop</td>
<td>'.$toloc.'</td>
</tr>
<tr>
<td>Journey Date</td>
<td>'.date("d-M-Y",strtotime($date)).'</td>
<td>People</td>
<td>'.$people.'</td>
</tr>
<tr>
<td>Vehicle</td>
<td>'.$vehicalname.'</td>
<td>Service</td>
<td>'.$servicename.'</td>
</tr>
<tr>
<td>Message</td>
<td colspan="3">'.$message.'</td>
</tr>
<tr>
<td>Address</td>
<td colspan="3">'.$address.'</td>
<tr>
<td>Pickup Location</td>
<td>'.$pickpoint.'</td>
<td>Pickup Time</td>
<td>'.$picktime.'</td>
</tr>
</tr>
'.$sighttxtemail.'
<tr> 
<td>Time</td>
<td>'.date("d-M-Y H:s").'</td>
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

            enq_pickup_loc     = :enq_pickup_loc,
            enq_drop_loc       = :enq_drop_loc,
            enq_journey_date   = :enq_journey_date,
            enq_total_people   = :enq_total_people,
            enq_vehical_type   = :enq_vehical_type,
            enq_service        = :enq_service,
            enq_sightseeing    = :enq_sightseeing,
            enq_name           = :enq_name,
            enq_phone          = :enq_phone,
            enq_email          = :enq_email,
            enq_address        = :enq_address,
            enq_alt_phone      = :enq_alt_phone,
            enq_message        = :enq_message,
            enq_pickuplocation = :enq_pickuplocation,
            enq_pickuptime     = :enq_pickuptime,
            enq_ip             = :enq_ip";
            $insert = $PDO->prepare($sql);

            $insert->bindParam(':enq_pickup_loc',$fromloc);
            $insert->bindParam(':enq_drop_loc',$toloc);
            $insert->bindParam(':enq_journey_date',$date);
            $insert->bindParam(':enq_total_people',$people);
            $insert->bindParam(':enq_vehical_type',$vehicalname);
            $insert->bindParam(':enq_service',$servicename);
            $insert->bindParam(':enq_sightseeing',$sighttxt);
            $insert->bindParam(':enq_name',$name);
            $insert->bindParam(':enq_phone',$phone);
            $insert->bindParam(':enq_email',$emailid);
            $insert->bindParam(':enq_address',$address);
            $insert->bindParam(':enq_alt_phone',$altphone);
            $insert->bindParam(':enq_message',$message);
            $insert->bindParam(':enq_pickuplocation',$pickpoint);
            $insert->bindParam(':enq_pickuptime',$picktime);
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




        //     if($insert->rowCount() > 0){
        //         unset($_SESSION['remember']);

        // $sighttxtemail = null;
        // if(!empty($sighttxt)){ 
        // $sightarr = explode('~@~',$sighttxt); 
        //     $sighttxtemail .= '<td colspan="4" align="center" style="text-align:center">Sightseeing</td>
        //                   </tr>';
        //     foreach ($sightarr as $sights){ 
        //         $now= explode('|',$sights);
        //         $sighttxtemail .=    '<tr>
        //             <td>Pickup</td>
        //             <td>'.date('d-M-Y', strtotime($now[0])).'</td>
        //             <td>Drop</td>
        //             <td>'.$now[1].'</td>
        //             </tr>';
        //     }
        // }
        // $subject = 'Inquiry from Himalayan Wheels';
        // $message = '<html lang="en">
        // <head>
        // <title>Booking Inquiry</title>
        // <style type="text/css">
        //             th,td{padding:5px;border-right:1px solid #ccc;border-bottom:1px solid #ccc;text-align:left;}
        //             table{border-left:1px solid #ccc;border-top:1px solid #ccc;margin:10px auto;width:100%;}
        // </style>
        // </head>
        // <body style="background:#eee;">
        // <div style="width:80%;background:#fff;padding:10px;margin:10px auto;">
        //           <table border="1" cellpadding="0" cellspacing="0">
        //           <tr>
        //             <td>Contact Person</td>
        //             <td colspan="3">'.stripslashes(nl2br($name)).'</td>
        //           </tr>
        //           <tr>
        //             <td>Email</td>
        //             <td>'.stripslashes(nl2br($emailid)).'</td>
        //             <td>Phone</td>
        //             <td>'.($phone.(!empty($altphone)?'/'.$altphone:null)).'</td>
        //           </tr> 
        //           <tr>
        //             <td>Pickup</td>
        //             <td>'.$sname.'</td>
        //             <td>Drop</td>
        //             <td>'.$ename.'</td>
        //           </tr>
        //           <tr>
        //             <td>Journey Date</td>
        //             <td>'.date("d-M-Y",strtotime($date)).'</td>
        //             <td>Vehical</td>
        //             <td>'.$people." | ".$vehicalname.'</td>
        //           </tr>
        //           <tr>
        //           <td>Message</td>
        //           <td colspan="3">'.$message.'</td>
        //           <tr>
        //             <td>Pickup Location</td>
        //             <td>'.$pickpoint.'</td>
        //             <td>Pickup Time</td>
        //             <td>'.$picktime.'</td>
        //           </tr>
        //           </tr>
        //           '.$sighttxtemail.'
        //           <tr> 
        //             <td>Time</td>
        //             <td>'.date("d-M-Y H:s").'</td>
        //             <td>IP</td>
        //             <td>'.$ip.'</td>
        //           </tr>
        //         </table>
        //         </div>
        //         </body>
        //         </html>';
        //         $headers  = 'MIME-Version: 1.0' . "\r\n";
        //         $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        //         $headers .= 'From: '.$name.' <'.$emailid.'>' . "\r\n";
        //         $to = 'Himalayan Wheels<info@himalayanwheels.com>';
        //         @mail($to, $subject, $message, $headers);
        //         echo $response = json_encode(array(
        //             "status" => true, 
        //             "msg"    => "thank-you"
        //         ));
        //     }else {
        //         echo $response = json_encode(array(
        //             "status" =>false,
        //             "msg"    =>"Something Wrong"
        //         ));
        //     }

 