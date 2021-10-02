<?php
session_start();

require_once "connect.php";

$polaczenie = @new mysqli($host,$db_user,$db_paswword,$db_name);

if($polaczenie->connect_errno!=0)
{
  echo "Error: ".$polaczenie->connect_errno;
}
else{

  $login=$_POST['user'];
  $haslo=$_POST['pass'];

  $sql ="SELECT*FROM daneuzytkownikow WHERE user='%s'";

  $sql = sprintf($sql, mysqli_real_escape_string($polaczenie,$login));

  if($rezultat= @$polaczenie->query($sql)){
    $ilu_userow = $rezultat->num_rows;

    if($ilu_userow>0){
      $wiersz=$rezultat->fetch_assoc();
      //echo '<pre>'; var_dump ([$haslo, $wiersz, password_verify($haslo, $wiersz['pass'])]); exit();

      if(password_verify($haslo, $wiersz['pass'])){
        $_SESSION['user']=$wiersz;
        unset($_SESSION['blad']);
        $rezultat->free_result();
        header('Location:loading.html');
      }

      else{
          $_SESSION['blad']='</br></br></br></br></br></br>
          <span style="color: red; text-shadow: 3px 3px 15px;">
          Incorrect login or password</span></br></p>
          <strike style="color: red; text-shadow: 3px 3px 15px;"
          >ACCESS DENIED</strike>';
          header('Location:index.php');
      }

    }
    else{
        $_SESSION['blad']='</br></br></br></br></br></br>
        <span style="color: red; text-shadow: 3px 3px 15px;">
        Incorrect login or password</span></br></p>
        <strike style="color: red; text-shadow: 3px 3px 15px;"
        >ACCESS DENIED</strike>';
        header('Location:index.php');
    }
  }
  $polaczenie->close();
}
 ?>
