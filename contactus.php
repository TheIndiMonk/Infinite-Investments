<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "infinitedb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 

extract($_POST);

$sql = "INSERT into contact(name,email,phone,message,trading_segment) VALUES('" . $name . "','" . $email . "','" . $phone . "' ,'" . $message . "', '" . $trading_segment . "')";

if ($conn->query($sql) === TRUE) {
    $toEmail = "mash.pro666@gmail.com";
	$mailHeaders = "From: " . $name . "<". $email .">\r\n";
    $subject = "Contact From" . $name . "Contact" . $phone;
    $content = "Name:" . $name . "\n Email:" . $email . "\n Phone:" . $phone . "\n Message:" . $message . "\n Trading Segment:" . $trading_segment;
	if(mail($toEmail, $subject, $content, $mailHeaders)) {
	    $message = "Your contact information is received successfully.";
	    $type = "success";
	}
    echo "<div style='margin: auto; width:50%; text-align:center; '>
            <p>Thanks for contacting us.</p>
             <a href='https://www.infiniteinvestments.co.in'>Home</a></div>";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>