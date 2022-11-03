<?php
include("updatePassword.html");
session_start();
 $connection=new mysqli('127.0.0.2:3307','root','','site_database');
 if($connection->connect_error){
    die("Connection failed :" .$connection->connect_error);
   }else if(isset($_POST['button'])){
      $cod=$_POST['cod'];
      if(empty(trim($cod))){
        echo "<script>
        var eroare=document.getElementById('eroareCod');
        var text=document.createTextNode('Introduceți codul primit');
        eroare.appendChild(text);
        eroare.style.display='block';
        </script>";
      }
      else if($cod!=$_SESSION['cod']){
       echo "<script>
       var eroare=document.getElementById('eroareCod');
       var text=document.createTextNode('Cod invalid');
       eroare.appendChild(text);
       eroare.style.display='block';
       </script>";
     }
     else{
    $stmt=$connection->prepare("UPDATE `city_account` SET `password`=? WHERE `id`=?");
    $stmt->bind_param("si",$_SESSION['password'],$_SESSION['id']);
    $stmt->execute();
    $stmt->close();
    session_destroy();
    $alert="<script>alert('Parola a fost resetată');
    window.location.assign('login.php');</script>";
    echo $alert;
   }}
   
?>