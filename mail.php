<?php
$name = $_POST['name1'];
$email = $_POST['email2'];
$phone = $_POST['phone3'];
$city = $_POST['city4'];
$message = $_POST['message5'];
$formcontent=" From: $name \n Phone: $phone \n Call Back: $call \n City: $city \n Message: $message";
$recipient = "aditya@newvisiondigital.co";
$subject = "Contact Form";
$mailheader = "From: $email \r\n";
mail($recipient, $subject, $formcontent, $mailheader) or die("Error!");
echo "Thank You!"
?>
