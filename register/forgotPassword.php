<?php
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\SMTP;
 use PHPMailer\PHPMailer\Exception;
 include("forgotPassword.html");
 //Load Composer's autoloader
 require ('C:\xampp\htdocs\Parking_site\PHPMailer\PHPMailer-master\src\Exception.php');
 require ('C:\xampp\htdocs\Parking_site\PHPMailer\PHPMailer-master\src\PHPMailer.php');
 require ('C:\xampp\htdocs\Parking_site\PHPMailer\PHPMailer-master\src\SMTP.php');
 function send_password_reset($string,$get_email){
    $mail=new PHPMailer(true);                     //Enable verbose debug output
    $mail->isSMTP();
    $mail->SMTPAuth=true;                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through                                //Enable SMTP authentication
    $mail->Username   = 'stoinelb@gmail.com';                     //SMTP username
    $mail->Password   = 'ldqjmhfkzepiprls';                               //SMTP password
    $mail->SMTPSecure = "tls";            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('stoinelb@gmail.com', $get_email);
    $mail->addAddress($get_email);
    $mail->isHTML(true);
    $mail->Subject="Resetare parola";
    $email_template="
      Codul dumneavoastră este '$string'.
      Pentru a reseta parola, accesați următorul link: 
      <br><a href='http://localhost/Parking_site/register/updatePassword.php'>Resetare</a>
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

 $email=null;
  $password=null;
  $confirmPassword=null;
  $token=null;
  $success=null;
  $connection=new mysqli('127.0.0.2:3307','root','','site_database');
 if($connection->connect_error){
  die("Connection failed :" .$connection->connect_error);
 }
 else
 if(isset($_POST['button'])){
  $email = $_POST['email'];
  $password=$_POST['password'];
  $confirmPassword=$_POST['confirmPassword'];
  if(empty(trim($email))){
    echo "<script>
    var eroare=document.getElementById('eroare');
    var text=document.createTextNode('Introduceți adresa de email pentru recuperare');
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
  else if($password!=$confirmPassword){
   echo "<script>
   var confirm=document.getElementById('confirm');
   var text=document.createTextNode('Ați introdus două parole diferite!');
   confirm.appendChild(text);
   confirm.style.display='block';
   </script>";
 }
 else{
  $stmt=$connection->prepare("SELECT * FROM user_account WHERE email=? limit 1");
    $stmt->bind_param("s",$email);
    $stmt->execute();
    $result=$stmt->get_result();
  if(mysqli_num_rows($result)===0){
   echo "<script>
   var eroare=document.getElementById('eroare');
   var text=document.createTextNode('Adresă de email invalidă');
   eroare.appendChild(text);
   eroare.style.display='block';
   </script>";
            $stmt->close();
  }else{
   $row=mysqli_fetch_assoc($result);
   session_start();
   $_SESSION['id']=$row['id'];
   $_SESSION['password']=$password;
   echo "<script>
   var eroare=document.getElementById('eroare');
   var text=document.createTextNode('Linkul a fost trimis');
   eroare.appendChild(text);
   eroare.style.display='block';
   eroare.style.color='green';
   </script>";
   $string_ch='0123456789';
   $length=6;
   $string='';
   while(strlen($string)<$length){
    $string.=$string_ch[random_int(0,strlen($string_ch))];
   }
   $_SESSION['cod']=$string;
   send_password_reset($string,$email);
  $connection->close();
  }}}
?>