<?php
 $url = 'https://api.sendgrid.com/';
 $user = getenv("sendgrid_username");
 $pass = getenv("sendgrid_pass");

 $myemail = getenv("myemail");//<-----Put Your email address here.

$name = $_POST['name']; 
$email_address = $_POST['email']; 
$message = $_POST['message']; 
$guest = $_POST['guest'];

if(empty($_POST['name'])  || 
   empty($_POST['email']) || 
   empty($_POST['guest']) ||
   empty($_POST['message']))
{
    $errors .= "\n Error: all fields are required , $name, $email_address, $message, $guest";
}



if (!preg_match(
"/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", 
$email_address))
{
    $errors .= "\n Error: Invalid email address";
}

if(empty($errors))//1==1)
{
	
	$email_body = "A mai confirmat cineva. ---------- \n Nume: $name \n attending with $guest guests, ----- Email: $email_address ---------\n Mesaj: \n $message, "; 
	$subject= "Wedding confirmation from $name";
 $params = array(
      'api_user' => $user,
      'api_key' => $pass,
      'to' => $myemail,
      'subject' => $subject,
      'html' => $email_body,
      'text' => $email_body,
      'from' => $email_address,
   );

 $request = $url.'api/mail.send.json';

 // Generate curl request
 $session = curl_init($request);

 // Tell curl to use HTTP POST
 curl_setopt ($session, CURLOPT_POST, true);

 // Tell curl that this is the body of the POST
 curl_setopt ($session, CURLOPT_POSTFIELDS, $params);

 // Tell curl not to return headers, but do return the response
 curl_setopt($session, CURLOPT_HEADER, false);
 curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

 // obtain response
 $response = curl_exec($session);
 curl_close($session);

 // print everything out
 print_r($response);
 header('Location: contact-form-thank-you.html');
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"> 
<html>
<head>
	<title>Contact form handler</title>
</head>

<body>
<!-- This page is displayed only if there is some error -->
<?php
echo nl2br($errors);
?>


</body>
</html>
