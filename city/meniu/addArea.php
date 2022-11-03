<?php
include('addArea.html');
 session_start();
 $connection=new mysqli('127.0.0.2:3307','root','','site_database');
 if($connection->connect_error){
    die("Connection failed :" .$connection->connect_error);
   }
   else if(isset($_POST['button']))
   if(($_POST['zona']>100) || ($_POST['pret']>100) || ($_POST['zona']<0) || ($_POST['pret']<1))
   echo "<script>
   var eroare=document.getElementById('eroare');
   var text=document.createTextNode('Valori invalide');
   eroare.appendChild(text);
   eroare.style.display='block';
   </script>";
   else if(empty(trim($_POST['bank_account']))){
      echo "<script>
      var eroare=document.getElementById('eroare');
      var text=document.createTextNode('Introduceți un cont bancar');
      eroare.appendChild(text);
      eroare.style.display='block';
      </script>";
   }
   else
   {
        $zona = $_POST['zona'];
        $pret = $_POST['pret'];
        $table = $_SESSION['cityName'];
        $bank_account=$_POST['bank_account'];
        $rating=0;
        $stmt=$connection->prepare("SELECT * FROM bank_account WHERE bank_account=? limit 1");
        $stmt->bind_param("s",$bank_account);
        $stmt->execute();
        $result=$stmt->get_result();
        $stmt->close();
        if(mysqli_num_rows($result)==0) 
        echo "<script>
        var eroare=document.getElementById('eroare');
        var text=document.createTextNode('Cont invalid');
        eroare.appendChild(text);
        eroare.style.display='block';
        </script>";
        else {
        $query = "CREATE TABLE IF NOT EXISTS ".$table." (id int primary KEY AUTO_INCREMENT, bank_account VARCHAR(100) NULL, zona int NULL, pret int NULL, rating int NULL, suma int NULL, contor int NULL); ";
        $result=$connection->query($query);
        $query="SELECT * FROM ".$table." WHERE zona=? limit 1";
        $stmt=$connection->prepare($query);
        $stmt->bind_param("i",$zona);
        $stmt->execute();
        $result=$stmt->get_result();
        $stmt->close();
        if(mysqli_num_rows($result)>0) echo
        "<script>
        alert('Zona existenta');
        window.location='addArea.php'
       </script>";
        else{
        $stmt=$connection->prepare("INSERT INTO $table (bank_account,zona, pret, rating, suma, contor) values(?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("siiiii",$bank_account,$zona,$pret, $rating,$rating,$rating);
        $stmt->execute();
        $stmt->close();
        echo "<script>
              alert('Datele au fost salvate cu succes');
              window.location='meniuConnect.php'
             </script>";
}}}
?>