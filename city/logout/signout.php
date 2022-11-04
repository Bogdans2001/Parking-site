<?php
 session_start();
 $connection=new mysqli('127.0.0.2:3307','root','','site_database');
 if($connection->connect_error){
    die("Connection failed :" .$connection->connect_error);
   }
   else{ 
    $stmt=$connection->prepare("DELETE FROM city_account WHERE id=? limit 1");
    $stmt->bind_param("i",$_SESSION['idCity']);
    $stmt->execute();
    $stmt->close();
    $stmt=$connection->prepare("DROP TABLE ".$_SESSION['cityName']);
    $stmt->execute();
    $stmt->close();
   }

 session_destroy();
    $alert="<script>alert('Contul a fost șters');
    window.location.assign('../../meniu/meniu.php');</script>";
    echo $alert;
?>