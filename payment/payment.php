<?php
include("payment.html");
session_start();
function plateste($connection,$getBudget, $getPrice, $getBankAccount, $getCardNumber, $getUsername, $getCityName, $getZona,$getCarNumber){
    if($getBudget<$getPrice) {
        echo "<script>
        var eroare=document.getElementById('eroare');
        var text=document.createTextNode('Zona inexistentă');
        eroare.appendChild(text);
        eroare.style.display='block';
        </script>";
        return;
    }
    $stmt=$connection->prepare("SELECT * FROM bank_account WHERE bank_account=? limit 1");
    $stmt->bind_param("s",$getBankAccount);
    $stmt->execute();
    $result=$stmt->get_result();
    $row=mysqli_fetch_assoc($result);
    $cityBudget=$row['budget'];
    $cityBudget=$cityBudget+$getPrice;
    $getBudget=$getBudget-$getPrice;
    $stmt->close();
    $stmt=$connection->prepare("UPDATE bank_account SET budget=? WHERE bank_account=?");
    $stmt->bind_param("is",$cityBudget,$getBankAccount);
    $stmt->execute();
    $stmt->close();
    $stmt=$connection->prepare("UPDATE card_number SET `sum`=? WHERE card_number=?");
    $stmt->bind_param("is",$getBudget,$getCardNumber);
    $stmt->execute();
    $stmt->close();
    $timp=time();
    $date=date('Y-m-d H:i:s');
    $stmt=$connection->prepare("INSERT INTO payment (oras, zona, username, nr_inmatriculare, data, time) values(?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssi",$getCityName,$getZona,$getUsername,$getCarNumber,$date,$timp);
    $stmt->execute();
    $stmt->close();
    echo "<script>
    alert('Plată reușită!');
    window.location='../meniu/meniuConnect.php';
    </script>";
}

$connection=new mysqli('127.0.0.2:3307','root','','site_database');
if($connection->connect_error){
  die("Connection failed :" .$connection->connect_error);
}
if(isset($_POST['button'])){
$card_number=$_POST['card_number'];
$city=$_POST['city_name'];
$zona=$_POST['zona'];
$inm_number=$_POST['inm_number'];
$ok=1;
$stmt=$connection->prepare("SELECT * FROM city_account WHERE username=? AND ok=? limit 1");
$stmt->bind_param("si",$city,$ok);
$stmt->execute();
$result=$stmt->get_result();
if(mysqli_num_rows($result)==0){
    echo "<script>
        var eroare=document.getElementById('eroare');
        var text=document.createTextNode('Oraș invalid');
        eroare.appendChild(text);
        eroare.style.display='block';
        </script>";
    $stmt->close();
  }else {
    $stmt->close();
    $stmt=$connection->prepare("SELECT * FROM card_number WHERE card_number=? limit 1");
$stmt->bind_param("s",$card_number);
$stmt->execute();
$result=$stmt->get_result();
if(mysqli_num_rows($result)==0){
    echo "<script>
        var eroare=document.getElementById('eroare');
        var text=document.createTextNode('Card invalid');
        eroare.appendChild(text);
        eroare.style.display='block';
        </script>";
    $stmt->close();
  }
  else{
    $row=mysqli_fetch_assoc($result);
    $budget=$row['sum'];
    $stmt->close();
    $stmt=$connection->prepare("SELECT * FROM ".$city." WHERE zona=? limit 1");
$stmt->bind_param("i",$zona);
$stmt->execute();
$result=$stmt->get_result();
if(mysqli_num_rows($result)==0){
    echo "<script>
        var eroare=document.getElementById('eroare');
        var text=document.createTextNode('Zona inexistentă');
        eroare.appendChild(text);
        eroare.style.display='block';
        </script>";
    $stmt->close();
  }
  else {
    $row=mysqli_fetch_assoc($result);
    $price=$row['pret'];
    $bank_account=$row['bank_account'];
    $stmt->close();
    $stmt=$connection->prepare("SELECT * FROM payment WHERE nr_inmatriculare=? AND zona=? AND oras=? ORDER BY id DESC LIMIT 1;");
$stmt->bind_param("sis",$inm_number,$zona,$city);
$stmt->execute();
$result=$stmt->get_result(); 
if(mysqli_num_rows($result)!=0){
  $row=mysqli_fetch_assoc($result);
  $time=$row['time']; 
  if(time()-$row['time']<3600) {echo "<script>
        var eroare=document.getElementById('eroare');
        var text=document.createTextNode('Abonament valabil');
        eroare.appendChild(text);
        eroare.style.display='block';
        eroare.style.color='green';
        </script>";
       $stmt->close();}
       else{
         $stmt->close();
         plateste($connection,$budget,$price,$bank_account,$card_number,$_SESSION['username'],$city,$zona,$inm_number);
        }
  }
  else plateste($connection,$budget,$price,$bank_account,$card_number,$_SESSION['username'],$city,$zona,$inm_number);
}
}
}
}
?>