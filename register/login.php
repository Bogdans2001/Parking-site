<?php
  $email = $_POST['email'];
  $password = $_POST['password'];
 $connection=new mysqli('127.0.0.2:3307','root','','site_database');
 if($connection->connect_error){
  die("Connection failed :" .$connection->connect_error);
 }
 else{
  $query="SELECT * FROM user_account WHERE email='$email' AND password='$password' limit 1";
  $result=mysqli_query($connection, $query);
  if(mysqli_num_rows($result)===1){
            $row=mysqli_fetch_assoc($result);
            print_r($row);
  }
 }
?>