<?php
include("unpaid.html");
session_start();
 $connection=new mysqli('127.0.0.2:3307','root','','site_database');
 if($connection->connect_error){
    die("Connection failed :" .$connection->connect_error);
   }
   else if(isset($_POST['button'])) {
   if(empty(trim($_POST['nr_inm']))){
      echo "<script>
      var eroare=document.getElementById('eroare');
      var text=document.createTextNode('Introduceți un număr de înmatriculare');
      eroare.appendChild(text);
      eroare.style.display='block';
      </script>";
   }
   else
   {
        $zona = $_POST['zona'];
        $table = $_SESSION['cityName'];
        $nr_inm= $_POST['nr_inm'];
        $ok=1;
        $stmt=$connection->prepare("SELECT * FROM ".$table." WHERE zona=?");
        $stmt->bind_param("i",$zona);
        $stmt->execute();
        $result=$stmt->get_result();
        $stmt->close();
        if(mysqli_num_rows($result)==0) 
        echo "<script>
        var eroare=document.getElementById('eroare');
        var text=document.createTextNode('Zonă inexistentă');
        eroare.appendChild(text);
        eroare.style.display='block';
        </script>";
        else{
        $stmt=$connection->prepare("SELECT * FROM payment WHERE nr_inmatriculare=? AND zona=? AND oras=? ORDER BY id DESC LIMIT 1;");
        $stmt->bind_param("sis",$nr_inm,$zona,$table);
        $stmt->execute();
        $result=$stmt->get_result();
        $stmt->close();
        if(mysqli_num_rows($result)==0) 
        echo "<script>
        var eroare=document.getElementById('eroare');
        var text=document.createTextNode('Neplătit');
        eroare.appendChild(text);
        eroare.style.display='block';
        </script>";
        else {
            $row=mysqli_fetch_assoc($result);
            $data=$row['data'];
            if(time()-$row['time']>3600)
            echo "<script>
            var eroare=document.getElementById('eroare');
            var text=document.createTextNode('Neplătit. Ultima înregistrare: $data');
            eroare.appendChild(text);
            eroare.style.display='block';
            </script>";
            else echo "<script>
            var eroare=document.getElementById('eroare');
            var text=document.createTextNode('Plătit');
            eroare.appendChild(text);
            eroare.style.display='block';
            eroare.style.color='green';
            </script>";
        } 
        }}}
?>