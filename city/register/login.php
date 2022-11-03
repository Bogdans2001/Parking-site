<?php
include("login.html");
session_start();
session_destroy();
session_start();
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
    echo "<script>
        var eroare=document.getElementById('eroare');
        var text=document.createTextNode('Introduceți adresa de email');
        eroare.appendChild(text);
        eroare.style.display='block';
        </script>";
  }
  else if(empty(trim($password))){
    echo "<script>
        var eroare=document.getElementById('eroare');
        var text=document.createTextNode('Introduceți parola');
        eroare.appendChild(text);
        eroare.style.display='block';
        </script>";
  }
  else {
    $ok=1;
    $stmt=$connection->prepare("SELECT * FROM city_account WHERE email=? AND password=? AND ok=? limit 1");
    $stmt->bind_param("ssi",$email,$password,$ok);
    $stmt->execute();
    $result=$stmt->get_result();
  if(mysqli_num_rows($result)===1){
            $_SESSION['last_login']=time();
            $row=mysqli_fetch_assoc($result);
            $id=$row['id'];
            $username=$row['username'];
            $_SESSION['idCity']=$id;
            $_SESSION['cityName']=$username;
            $_SESSION['emailCity']=$email;
            $_SESSION['cityPassword']=$password;
            header("Location:../meniu/meniuConnect.php");
  }
  else echo "<script>
  var eroare=document.getElementById('eroare');
  var text=document.createTextNode('Adresa de email sau parola invalidă');
  eroare.appendChild(text);
  eroare.style.display='block';
  </script>";
  $stmt->close();
}
 }}
?>