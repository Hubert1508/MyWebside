<?php

  session_start();

  if (isset($_POST['email'])){

    $everyIs_ok = true;

    //check Nickname
    $nick = $_POST['nick'];

    //check length Nickname
    if((strlen($nick)<3) || (strlen($nick)>12)){
      $everyIs_ok = false;
      $_SESSION['e_nick']='Nickname must be between 3 and 12 characters';
    }

    if(ctype_alnum($nick)==false){
      $everyIs_ok=false;
      $_SESSION['e_nick']='Nickname can only consist of letters and numbers';
    }

    //check e-mail
    $email = $_POST['email'];
    $emailS = filter_var($email, FILTER_SANITIZE_EMAIL);
    if($email==""){
      $everyIs_ok=false;
      $_SESSION['e_email'] = 'Enter your email address';
    }


    //check password

    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];

    if((strlen($password1)<8)||(strlen($password1)>20)){
      $everyIs_ok=false;
      $_SESSION['e_password1'] = 'The password must have between 8 and 20 characters';
    }

    if($password1!=$password2){
      $everyIs_ok = false;
      $_SESSION['e_password1'] = 'The passwords you have entered do not match';
    }

    //$password_hash = $password1;

    /*********HASH PASSWORDS bcrypt!!!**********/
    $password_hash = password_hash($password1, PASSWORD_DEFAULT);

    /*****HASH MD5*********/
    //$password_hash = md5($password1);

    //*****echo $password_hash; exit();*****//

      //Have the regulations been accepted?
      if(!isset($_POST['regulations'])){
        $everyIs_ok = false;
        $_SESSION['e_regulations']='Confirm acceptance of the regulations';
      }

      //Remember entered data
      $_SESSION['rf_nick']=$nick;
      $_SESSION['rf_email']=$email;
      $_SESSION['rf_password1']=$password1;
      $_SESSION['rf_password2']=$password2;
      if(isset($_POST['regulations']))$_SESSION['rf_regulations'] = true;

      require_once "connect.php";
      mysqli_report(MYSQLI_REPORT_STRICT);

      try{
        $polaczenie = @new mysqli($host,$db_user,$db_paswword,$db_name);
        if($polaczenie->connect_errno!=0){
          throw new Exception(mysqli_connect_errno());
        }
        else{

          //Is there an nick in the database?
          $rezultat = $polaczenie->query("SELECT id FROM daneuzytkownikow WHERE user = '$nick'");
          if(!$rezultat) throw new Exception($polaczenie->error);

          $how_many_such_users = $rezultat->num_rows;
          if($how_many_such_users>0){
            $everyIs_ok=false;
            $_SESSION['e_nick']="There is already such a user";
          }

          //Is there an email in the database?
          $rezultat = $polaczenie->query("SELECT id FROM daneuzytkownikow WHERE address_email = '$email'");
          if(!$rezultat) throw new Exception($polaczenie->error);

          $how_many_such_email = $rezultat->num_rows;
          if($how_many_such_email>0){
            $everyIs_ok = false;
            $_SESSION['e_email'] = "There is already such a email";
          }

          if($everyIs_ok==true){
            if($polaczenie->query("INSERT INTO daneuzytkownikow VALUES (NULL, '$nick', '$password_hash', '$email')")){
              $_SESSION['SuccessfulUseRregistration'] = true;
              header('Location:welcome.php');
            }
            else{
              throw new Exception($polaczenie->error);
            }
          }

          $polaczenie->close();
        }
      }
      catch(Exception $e){
        //echo '<div class = "error">Błąd serwera</div>';
        //echo'</br> Informacja developerska:'.$e;
      }

  }

 ?>

<!DOCTYPE html>
<html>
  <head>
    <title>New account</title>
    <link rel="stylesheet" href="style.css" type="text/css"/>
  </head>
  <body>
  </br>
    <H1>Create your account</H1>

    <div style = 'text-align:center;'>

    <form action = '' method="post">
      User: </br><input type = 'text' name = 'nick'
        value = '<?php if(isset($_SESSION['rf_nick'])){
          echo $_SESSION['rf_nick'];
          unset($_SESSION['rf_nick']);
        }?>'></input></br></br>

        <?php
          if(isset($_SESSION['e_nick'])){
            echo '<div class = "error">'.$_SESSION['e_nick'].'</div>';
            unset($_SESSION['e_nick']);
          }
          ?>

      E-mail: </br><input type = 'email' name = 'email'
        value = '<?php if(isset($_SESSION['rf_email'])){
          echo $_SESSION['rf_email'];
          unset($_SESSION['rf_email']);
        }?>'></input></br></br>

        <?php
          if(isset($_SESSION['e_email'])){
            echo '<div class = "error">'.$_SESSION['e_email'].'</div>';
            unset($_SESSION['e_email']);
          }
          ?>
      Password: </br><input type = 'password' name = 'password1'
        value = '<?php if(isset($_SESSION['rf_password1'])){
          echo $_SESSION['rf_password1'];
          unset($_SESSION['rf_password1']);
        }?>'></input></br></br>
        <?php
          if(isset($_SESSION['e_password1'])){
            echo '<div class = "error">'.$_SESSION['e_password1'].'</div>';
            unset($_SESSION['e_password1']);
          }
          ?>
      Repeat password: </br><input type = 'password' name = 'password2'
       value = '<?php if(isset($_SESSION['rf_password2'])){
        echo $_SESSION['rf_password2'];
        unset($_SESSION['rf_password2']);
      }?>'></input></br></br>

      <label>
        <input type = 'checkbox' name = 'regulations'
          <?php if(isset($_SESSION['rf_regulations'])){
            echo 'checked';
            unset($_SESSION['rf_regulations']);
          }
          ?>
         style = 'cursor:pointer;'>I accept</input>
        <a href='regulations.html' target="_blank">regulations</a>
          <?php
            if(isset($_SESSION['e_regulations'])){
              echo '<div class = "error">'.$_SESSION['e_regulations'].'</div>';
              unset($_SESSION['e_regulations']);
            }
            ?>
      </label></br></br>

      <input type = 'submit' class = 'CreateAccount'
      style = 'transition: 0.5s;
    	font-size: 25px;
    	border-radius:15px;
    	text-shadow: 3px 3px 15px aqua;
    	background-color: black;' value = 'Create account'></input>
    </form>
  </br>
    <form action = '/logowanie/index.php'>
      <input type = 'submit' class = 'CreateAccount'
      style = 'transition: 0.5s;
    	font-size: 25px;
    	border-radius:15px;
    	text-shadow: 3px 3px 15px aqua;
    	background-color: black;' value = 'Back'></input>
    </form>

  </div>
  </body>
