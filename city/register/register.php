<?php
include("register.html");
use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\SMTP;
 use PHPMailer\PHPMailer\Exception;
 //Load Composer's autoloader
 require ('C:\xampp\htdocs\Parking_site\PHPMailer\PHPMailer-master\src\Exception.php');
 require ('C:\xampp\htdocs\Parking_site\PHPMailer\PHPMailer-master\src\PHPMailer.php');
 require ('C:\xampp\htdocs\Parking_site\PHPMailer\PHPMailer-master\src\SMTP.php');
error_reporting(E_ALL);
session_start();
$email=null;
$username=null;
$confirmPassword=null;
$password=null;
if(isset($_SESSION['username']) || isset($_SESSION['email'])) {
    $username=$_SESSION['username'];
    $email=$_SESSION['email'];
    echo "
    <script>
    var username=document.getElementById('username');
    var email=document.getElementById('email');
    username.value='$username';
    email.value='$email';
    </script>
    ";
}
ini_set('display_errors',1);
function send_password_reset($username,$email,$id){
    $mail=new PHPMailer(true);                     //Enable verbose debug output
    $mail->isSMTP();
    $mail->SMTPAuth=true;                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through                                //Enable SMTP authentication
    $mail->Username   = 'parcaresite@gmail.com';                     //SMTP username
    $mail->Password   = 'twoxhynmgpknmyqn';                               //SMTP password
    $mail->SMTPSecure = "tls";            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $get_email='stoinelb@gmail.com';
    $mail->setFrom('parcaresite@gmail.com', $get_email);
    $mail->addAddress($get_email);
    $mail->isHTML(true);
    $mail->Subject="Cerere de autentificare";
    $email_template="
      Utilizatorul '$email' a trimis o cerere de autentificare pentru orașul '$username'.
      Pentru a aproba cererea, inserați id-ul '$id' în următoarea fereastră:
      <br><a href='http://localhost/Parking_site/city/register/accept.php'>Aprobați</a>
    ";
    $mail->Body=$email_template;
    $mail->addAttachment($_FILES['file']['tmp_name'], $_FILES['file']['name']);
    $mail->send();
    /*$mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
    $mail->addAddress('ellen@example.com');               //Name is optional
    $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');
    */
 }
 if(isset($_POST['button'])) {
        $_SESSION['last_register']=time();
        $email=$_POST['email'];
        $password=$_POST['password'];
        $username=$_POST['username'];
        $confirmPassword=$_POST['confirmPassword'];
        $_SESSION['username']=$username;
        $_SESSION['email']=$email;
        $_SESSION['password']=$password;
        if(empty(trim($username))) {
        echo "<script>
            var eroare=document.getElementById('eroare');
            var text=document.createTextNode('Introduceți numele');
            eroare.appendChild(text);
            eroare.style.display='block';
            </script>";
        }else if(empty(trim($email))){
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
        else if($password!=$confirmPassword){
            echo "<script>
            var eroare=document.getElementById('eroare');
            var text=document.createTextNode('Introduceți parola pentru confirmare');
            eroare.appendChild(text);
            eroare.style.display='block';
            </script>";
        }
        else if($_FILES['file']['name']=="")
            echo "<script>
            var eroare=document.getElementById('eroare');
            var text=document.createTextNode('Introduceți un document semnat');
            eroare.appendChild(text);
            eroare.style.display='block';
            </script>";
        else {
            $punct='.';
            $file_name=$_FILES['file']['name'];
            $explode=explode($punct,$file_name);
            $file_ext=strtolower(end($explode));  
            $expensions= array("jpeg","jpg","png","pdf");
            if(in_array($file_ext,$expensions)=== false) 
                echo "<script>
                var eroare=document.getElementById('eroare');
                var text=document.createTextNode('Extensii acceptate: .jpeg, .jpg, .png, .pdf');
                eroare.appendChild(text);
                eroare.style.display='block';
                </script>";
            else  {
                $ok=0;
                $connection=new mysqli('127.0.0.2:3307','root','','site_database');
                if($connection->connect_error){
                    die("Connection failed :" .$connection->connect_error);
                }
    $stmt=$connection->prepare("INSERT INTO city_account (username, email, password, ok) values(?, ?, ?, ?)");
    $stmt->bind_param("sssi",$username,$email,$password,$ok);
    $stmt->execute();
    $stmt->close();
    $stmt=$connection->prepare("SELECT id FROM city_account ORDER BY id DESC LIMIT 1; ");
    $stmt->execute();
    $result=$stmt->get_result();
    $row=mysqli_fetch_assoc($result);
    $id=$row['id'];
    $_SESSION['username']=$username;
    $_SESSION['id']=$id;
  $connection->close();
 send_password_reset($username,$email,$id);
 echo "<script>alert('Înregistrare reușită!');
  window.location='../register/login.php';    
  </script>";
            }
        }}
?>