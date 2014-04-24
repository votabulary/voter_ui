<?php
 
if(isset($_POST['email'])) {
 
     
 
    // EDIT THE 2 LINES BELOW AS REQUIRED
 
    $email_to = "doug@votabulary.com";
 
    $email_subject = "Sign up";
 
     
 
     
 
    function died($error) {
 
        // your error code can go here
 
        echo "<!DOCTYPE html><html lang='en'><head><meta http-equiv='content-type' content='text/html; charset=UTF-8'><meta charset='utf-8'><meta http-equiv='X-UA-Compatible' content='IE=edge'><meta name='viewport' content='width=device-width, initial-scale=1'><meta name='description' content=''><meta name='author' content=''><link rel='shortcut icon' href='imgs/favicon.ico'><title>votabulary</title><link href='css/bootstrap.css' rel='stylesheet'><link href='css/navbar-static-top.css' rel='stylesheet'></head><body><div class='navbar navbar-inverse navbar-fixed-top' role='navigation'><div class='container'><div class='navbar-header'><button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-collapse'><span class='sr-only'>Toggle navigation</span><span class='icon-bar'></span><span class='icon-bar'></span><span class='icon-bar'></span></button><a class='navbar-brand' href='index.html'><span data-icon='a' class='icon'></span><img src='imgs/text-white.svg'></a></div> <div class='navbar-collapse collapse'><ul class='nav navbar-nav'><li><a href='index.html'>Home</a></li><li><a href='upcoming.html'>Upcoming elections</a></li><li><a href='about.html'>About</a></li><li><a href='faq.html'>Voting FAQ</a></li></ul><ul class='nav navbar-nav navbar-right'><li><a href='login.html'>Log in</a></li></ul></div></div></div><div class='container-fluid container'><div class='col-md-8 col-md-offset-2'><div class='formintro'><h1>Sign up</h1></div><form action='http://localhost:8080/voter/create' method='post'>Oops, looks like the form has some errors: ";
 
        echo "<br /><br />";
 
        echo $error."<br /><br />";
 
        echo "Please go back and fix these errors.<br /><br />";
 
        die();
 
    }
 
     
 
    // validation expected data exists
 
    if(!isset($_POST['first_name']) ||
 
        !isset($_POST['last_name']) ||
 
        !isset($_POST['email']) ||
 
        !isset($_POST['precinct']) ||
        
        !isset($_POST['contactemail']) ||

        !isset($_POST['alphacode']) ||
        
        !isset($_POST['contactsms'])) {
 
        died('We are sorry, but there appears to be a problem with the form you submitted.');      
 
    }
 
     
 
    $first_name = $_POST['first_name']; // required
 
    $last_name = $_POST['last_name']; // required
 
    $email_from = $_POST['email']; // required
 
    $precinct = $_POST['precinct']; // not required
    
    $contactemail = $_POST['contactemail']; // not required
    
    $alphacode = $_POST['alphacode']; // required    
 
    $contactsms = $_POST['contactsms']; // not required
 
     
 
    $error_message = "";
 
    $email_exp = '/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/';
 
  if(!preg_match($email_exp,$email_from)) {
 
    $error_message .= 'The Email Address you entered does not appear to be valid.<br />';
 
  }
 
    $string_exp = "/^[A-Za-z .'-]+$/";
 
  if(!preg_match($string_exp,$first_name)) {
 
    $error_message .= 'The First Name you entered does not appear to be valid.<br />';
 
  }
 
  if(!preg_match($string_exp,$last_name)) {
 
    $error_message .= 'The Last Name you entered does not appear to be valid.<br />';
 
  }
 
  if(strlen($alphacode) < 2) {
 
    $error_message .= 'The Alpha Code you entered does not appear to be valid.<br />';
 
  }
 
  if(strlen($error_message) > 0) {
 
    died($error_message);
 
  }
 
    $email_message = "Form details below.\n\n";
 
     
 
    function clean_string($string) {
 
      $bad = array("content-type","bcc:","to:","cc:","href");
 
      return str_replace($bad,"",$string);
 
    }
 
     
 
    $email_message .= "First Name: ".clean_string($first_name)."\n";
 
    $email_message .= "Last Name: ".clean_string($last_name)."\n";
 
    $email_message .= "Email: ".clean_string($email_from)."\n";
 
    $email_message .= "precinct: ".clean_string($precinct)."\n";

    $email_message .= "contactemail: ".clean_string($contactemail)."\n";

    $email_message .= "alphacode: ".clean_string($alphacode)."\n";
 
    $email_message .= "contactsms: ".clean_string($contactsms)."\n";
 
     
 
     
 
// create email headers
 
//$headers = 'From: '.$email_from."\r\n".
// 
//'Reply-To: '.$email_from."\r\n" .
// 
//'X-Mailer: PHP/' . phpversion();
//
//ini_set("SMTP", "smtp.mandrillapp.com");
//ini_set("smtp_port", "587");
//ini_set("user_name", "app18814430@heroku.com");
//ini_set("password ", "P3eKbD7xFBoKL-tb7IQf7g");
//ini_set("domain", "heroku.com");
// 
//@mail($email_to, $email_subject, $email_message, $headers); 

// config -- move up to if this works
$email_to_name = "Doug Wick";

// some variable work...
$email_from_name = clean_string($first_name)." ".clean_string($last_name);

// mailer magic
require 'PHPMailerAutoload.php'
$mail = new PHPMailer;

$mail->isSMTP();
$mail->Host = 'smtp.mandrillapp.com';
$mail->SMTPAuth = true;
$mail->Username = 'app18814430@heroku.com';
$mail->Password = 'P3eKbD7xFBoKL-tb7IQf7g';

$mail->From = $email_from;
$mail->FromName = $email_from_name;
$mail->addAddress($email_to, $email_to_name);
$mail->addReplyTo($email_from, $email_from_name);

$mail->Subject = $email_subject;
$mail->Body    = $email_message;

if(!$mail->send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}
 
echo 'Message has been sent';

?>
 
 
 
<!-- include your own success html here -->
 
 
 
<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="imgs/favicon.ico">

    <title>votabulary</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/navbar-static-top.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

  <body>

    <!-- Static navbar -->
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.html"><span data-icon="a" class="icon"></span><img src="imgs/text-white.svg"></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
	        <li><a href="index.html">Home</a></li>
            <li id="upcomingnav"><a href="upcoming.html">Upcoming elections</a></li>
            <li><a href="about.html">About</a></li>
            <li><a href="faq.html">Voting FAQ</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li><a href="login.html">Log in</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>


   	<div class="container-fluid container">
		<div class="col-md-8 col-md-offset-2">
	    <div class="formintro">
	        <h1>Success!</h1>
            <!-- <p class="help-block">Already have an account? <a href="login.html">Login here</a></p> -->
	    </div>
<p>You are now registered to receive voting update with Votabulary.</p>
		</div>
	</div>



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="https://code.jquery.com/jquery.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/transition.js"></script>
  

</body></html> 
 
 
<?php
 
}
 
?>
