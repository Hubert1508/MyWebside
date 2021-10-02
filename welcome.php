<?php

  session_start();

  if(!isset($_SESSION['SuccessfulUseRregistration'])){
    header('Location: index.php');
    exit();
  }
  else{
    unset($_SESSION['SuccessfulUseRregistration']);
  }

  if(isset($_SESSION['rf_nick'])) unset($_SESSION['rf_nick']);
  if(isset($_SESSION['rf_email'])) unset($_SESSION['rf_email']);
  if(isset($_SESSION['rf_password1'])) unset($_SESSION['rf_password1']);
  if(isset($_SESSION['rf_password2'])) unset($_SESSION['rf_password2']);
  if(isset($_SESSION['rf_regulations'])) unset($_SESSION['rf_regulations']);

  if(isset($_SESSION['e_nick'])) unset($_SESSION['e_nick']);
  if(isset($_SESSION['e_email'])) unset($_SESSION['e_email']);
  if(isset($_SESSION['e_password1'])) unset($_SESSION['e_password1']);
  if(isset($_SESSION['e_password2'])) unset($_SESSION['e_password2']);
  if(isset($_SESSION['e_regulations'])) unset($_SESSION['e_regulations']);
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
    <script>
      function login(){
    			document.location.href = "/logowanie/HomePage/index.php";
    		}
      </script>
  </head>
  <body>
    <br></br>
    <br></br>
    <br></br>
    <br></br>
    <h1>Thank you for registering on the site! You can now log in to your account.</h1>
    <input onclick='login()' class="logowanie" VALUE="Sign in"/>
  </body>
</head>
