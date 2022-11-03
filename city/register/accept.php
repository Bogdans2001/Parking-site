<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
include("accept.html");
session_start();
require ('C:\xampp\htdocs\Parking_site\PHPMailer\PHPMailer-master\src\Exception.php');
 require ('C:\xampp\htdocs\Parking_site\PHPMailer\PHPMailer-master\src\PHPMailer.php');
 require ('C:\xampp\htdocs\Parking_site\PHPMailer\PHPMailer-master\src\SMTP.php');
 function send_password_reset($get_email){
    $mail=new PHPMailer(true);                     //Enable verbose debug output
    $mail->isSMTP();
    $mail->SMTPAuth=true;                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through                                //Enable SMTP authentication
    $mail->Username   = 'stoinelb@gmail.com';                     //SMTP username
    $mail->Password   = 'ufnkdxxcmmstycgh';                               //SMTP password
    $mail->SMTPSecure = "tls";            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('stoinelb@gmail.com', $get_email);
    $mail->addAddress($get_email);
    $mail->isHTML(true);
    $mail->Subject="Resetare parola";
    $email_template="
      Cererea dumneavoastră a fost acceptată.
      Pentru a vă conecta, accesați următorul link: 
      <br><a href='http://localhost/Parking_site/city/register/login.php'>Conectare</a>
    ";
    $mail->Body=$email_template;
    $mail->send();

    /*$mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
    $mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    */
 }
 $connection=new mysqli('127.0.0.2:3307','root','','site_database');
 if($connection->connect_error){
    die("Connection failed :" .$connection->connect_error);
   }else if(isset($_POST['button'])){
      $cod=$_POST['cod'];
      $email=$_POST['email'];
      $username=$_POST['username'];
      if(empty(trim($cod))){
        echo "<script>
        var eroare=document.getElementById('eroareCod');
        var text=document.createTextNode('Introduceți id-ul primit');
        eroare.appendChild(text);
        eroare.style.display='block';
        </script>";
      }
      else if(empty(trim($email))){
        echo "<script>
        var eroare=document.getElementById('eroareCod');
        var text=document.createTextNode('Introduceți adresa de mail primită');
        eroare.appendChild(text);
        eroare.style.display='block';
        </script>";
      }
      else if(empty(trim($username))){
        echo "<script>
        var eroare=document.getElementById('eroareCod');
        var text=document.createTextNode('Introduceți numele orasului');
        eroare.appendChild(text);
        eroare.style.display='block';
        </script>";
      }
     else{
        $stmt=$connection->prepare("SELECT * FROM city_account WHERE email=? AND id=? limit 1");
        $stmt->bind_param("ss",$email,$cod);
        $stmt->execute();
        $result=$stmt->get_result();
      if(mysqli_num_rows($result)===1) {
        $stmt->close();
        $ok=1;
        $query = "CREATE TABLE IF NOT EXISTS ".$username." (id int primary KEY AUTO_INCREMENT, bank_account VARCHAR(100) NULL, zona int NULL, pret int NULL, rating int NULL, suma int NULL, contor int NULL); ";
        $result=$connection->query($query);
        $stmt=$connection->prepare("UPDATE `city_account` SET `ok`=? WHERE `id`=?");
        $stmt->bind_param("si",$ok,$cod);
        $stmt->execute();
        $stmt->close();
        session_destroy();
        send_password_reset($email);
        $alert="<script>alert('Cerere aprobată');
        window.location.assign('login.php');</script>";
        echo $alert;
   }
else echo "<script>
var eroare=document.getElementById('eroareCod');
var text=document.createTextNode('Datele nu corespund');
eroare.appendChild(text);
eroare.style.display='block';
</script>";}}
   
?>