<?php
session_start();
$_SESSION['last_login']=time();
  $email_error = null;
  $password_error=null;
  $email=null;
  $password=null;
  $username=null;
 $connection=new mysqli('127.0.0.2:3307','root','','site_database');
 if($connection->connect_error){
  die("Connection failed :" .$connection->connect_error);
 }
 else
  if(isset($_POST['loginButton'])){
  $email = $_POST['email'];
  $password = $_POST['password'];
  if(empty(trim($email))){
    $email_error="Introduceți adresa de email";
  }
  else if(empty(trim($password))){
    $password_error = "Introduceți parola";
  }
  else {
  $query="SELECT * FROM user_account WHERE email='$email' AND password='$password' limit 1";
  $result=mysqli_query($connection, $query);
  if(mysqli_num_rows($result)===1){
            $row=mysqli_fetch_assoc($result);
            session_start();
            $username=$row['username'];
            $_SESSION['username']=$username;
            $_SESSION['email']=$email;
            $_SESSION['password']=$password;
            header("Location:../meniu/meniuConnect.php");
  }
  else $password_error = "Adresa de email sau parola invalidă";
}
 }
?>