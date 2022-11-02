<?php
session_start();
session_destroy();
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
 else{
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
    $stmt=$connection->prepare("SELECT * FROM user_account WHERE email=? AND password=? limit 1");
    $stmt->bind_param("ss",$email,$password);
    $stmt->execute();
    $result=$stmt->get_result();
  if(mysqli_num_rows($result)===1){
            $row=mysqli_fetch_assoc($result);
            $id=$row['id'];
            $username=$row['username'];
            $_SESSION['id']=$id;
            $_SESSION['username']=$username;
            $_SESSION['email']=$email;
            $_SESSION['password']=$password;
            header("Location:../meniu/meniuConnect.php");
  }
  else $password_error = "Adresa de email sau parola invalidă";
  $stmt->close();
}
 }}
?>