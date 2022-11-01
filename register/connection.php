<?php
  $usernameRegister = null;
  $emailRegister = null;
  $passwordRegister=null;
  $confirmPassword=null;
  $confirmPassword_error=null;
  $error_Register=null;
 $connection=new mysqli('127.0.0.2:3307','root','','site_database');
 if($connection->connect_error){
  die("Connection failed :" .$connection->connect_error);
 }
 else
 if(isset($_POST['signupButton'])){
  $usernameRegister = $_POST['username'];
  $emailRegister = $_POST['email'];
  $passwordRegister=$_POST['password'];
  $confirmPassword=$_POST['confirmPassword'];
  if(empty(trim($emailRegister))){
    $error_Register="Introduceți adresa de email";
  }
  else if(empty(trim($passwordRegister))){
    $error_Register = "Introduceți parola";
  }
  else if($passwordRegister!=$confirmPassword){
    $confirmPassword_error = "Ați introdus două parole diferite!";
  }
 else{
  $stmt=$connection->prepare("SELECT * FROM user_account WHERE email=? limit 1");
    $stmt->bind_param("s",$emailRegister);
    $stmt->execute();
    $result=$stmt->get_result();
  if(mysqli_num_rows($result)===1){
            $error_Register="Există deja un cont pentru această adresă de email";
            $stmt->close();
  }else{
  $stmt->close();
  $stmt=$connection->prepare("INSERT INTO user_account (username, email, password) values(?, ?, ?)");
  $stmt->bind_param("sss",$usernameRegister,$emailRegister,$passwordRegister);
  $stmt->execute();
  echo "<script>alert('Înregistrare reușită!');
  window.location='../register/register.php';    
  </script>";
  $stmt->close();
  $connection->close();
 }}}
?>