<?php
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password=$_POST['password'];
  $confirmPassword=$_POST['confirmPassword'];
 $connection=new mysqli('127.0.0.2:3307','root','','site_database');
 if($connection->connect_error){
  die("Connection failed :" .$connection->connect_error);
 }
 else{
  $stmt=$connection->prepare("INSERT INTO user_account (username, email, password) values(?, ?, ?)");
  $stmt->bind_param("sss",$username,$email,$password);
  $stmt->execute();
  echo "registration complete...";
  $stmt->close();
  $connection->close();
 }
?>