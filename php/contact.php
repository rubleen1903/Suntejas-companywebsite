<?php 
$responseArray = array(                         
    "status"  => "error",
    "msg" => "Something went wrong!"                        
);
$errors = array();
       
if(isset( $_POST['name']) && $_POST['name'] == "" || isset($_POST['email']) && $_POST['email'] == "" || isset( $_POST['subject']) && $_POST['subject'] == "") {             
    $errors[] =  "Please fill all the required fields";                                         
} elseif(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){                
    $errors[] =  "Please enter valid email address";                
} else {

    $subject = (isset($_POST['subject']) && !empty($_POST['subject']))?$_POST['subject']:'';
    // Always set content-type when sending HTML email
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    
    // More headers
    //$headers .= 'From: <'.$_POST['email'].'>' . "\r\n";
    $headers .= 'From: '.$_POST['firstname']. "\r\n";    
    
    $message = '';
    $message .= (isset($_POST['name']) && !empty($_POST['name']))? $_POST['name'].',<br><br>' : '';
    $message .= (isset($_POST['firstname']) && !empty($_POST['firstname']))? $_POST['firstname'].',<br><br>' : '';
    $message .= (isset($_POST['lastname']) && !empty($_POST['lastname']))? $_POST['lastname'].',<br><br>' : '';
    $message .= (isset($_POST['email']) && !empty($_POST['email']))? $_POST['email'].',<br><br>' : '';
    $message .= (isset($_POST['phone']) && !empty($_POST['phone']))? $_POST['phone'].',<br><br>' : '';            
    
    $message .= (isset($_POST['message']) && !empty($_POST['message']) ? $_POST['message']: "");

    $body = $message."<br><br>";
    $body .= "This e-mail was sent from a contact form on SunTejasFarm"."\r\n";                
    if(mail('#', $subject, $body,$headers )){
        $responseArray = array(                         
                "status"  => "success",
                "msg" => '<div class="alert alert-success">Contact form successfully submitted. Thank you, I will get back to you soon!</div>'                     
        );
    } else {                        
        $errors[] = "Sorry there was an error sending your message. Please try again later.";    
    }
                                
}

if(!empty($errors)){
    $err="";
    foreach($errors as $error){
        $err.="<p>".$error.'</p>';        
    }
    $responseArray = array(                         
        "status"  => "error",
        "msg" => '<div class="alert alert-danger">'.$err.'</div>'                       
    );
}            
header('Content-Type: application/json');   
echo json_encode($responseArray);
exit();?>