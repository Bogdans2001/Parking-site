<?php
include("rating.html");
$connection=new mysqli('127.0.0.2:3307','root','','site_database');
 if($connection->connect_error){
  die("Connection failed :" .$connection->connect_error);
 }
 else{
    if(isset($_POST['button'])){
    $city = $_POST['city'];
    $zona = $_POST['zona'];
    if(empty(trim($city))){
      echo "<script>
          var eroare=document.getElementById('eroare');
          var text=document.createTextNode('Introduceți numele orașului');
          eroare.appendChild(text);
          eroare.style.display='block';
          </script>";
    }
    else {
    $ok=1;
      $stmt=$connection->prepare("SELECT * FROM city_account WHERE username=? AND ok=? limit 1");
      $stmt->bind_param("si",$city,$ok);
      $stmt->execute();
      $result=$stmt->get_result();
    if(mysqli_num_rows($result)===0){
        echo "<script>
        var eroare=document.getElementById('eroare');
        var text=document.createTextNode('Oraș invalid');
        eroare.appendChild(text);
        eroare.style.display='block';
        </script>";
        $stmt->close(); 
    }
    else {
        $stmt->close();
        $stmt=$connection->prepare("SELECT * FROM ".$city." WHERE zona=? limit 1");
      $stmt->bind_param("i",$zona);
      $stmt->execute();
      $result=$stmt->get_result();
    if(mysqli_num_rows($result)===0){
        echo "<script>
        var eroare=document.getElementById('eroare');
        var text=document.createTextNode('Zonă invalidă');
        eroare.appendChild(text);
        eroare.style.display='block';
        </script>";
        $stmt->close(); 
    }
    else{
        $row=mysqli_fetch_assoc($result);
        $suma=$row['suma'];
        $contor=$row['contor'];
        $suma=$suma+$_POST['nota'];
        $contor=$contor+1;
        $rating=$suma/$contor;
        $stmt->close();
        $stmt=$connection->prepare("UPDATE ".$city." SET `suma`=?, contor=?, rating=? WHERE `zona`=?");
        $stmt->bind_param("iiii",$suma,$contor,$rating,$zona);
        $stmt->execute();
        $result=$stmt->get_result();
        echo "
        <script>
        alert('Nota a fost înregistrată');
        window.location='../meniu/meniuConnect.php';
        </script>";
    }
    }
  }
   }}
?>