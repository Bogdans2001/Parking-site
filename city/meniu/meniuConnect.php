<?php
include("meniuConnect.html");
  session_start();
  $username=$_SESSION['cityName'];
  $time=time()-$_SESSION['last_login'];
  if($time>900)  {
    $_SESSION['inactivitate']=1;
    header("Location:../logout/logout.php");
  }
  else $_SESSION['last_login']=time();
  echo "<script>
  var button=document.getElementById('username');
  var text=document.createTextNode('$username');
  button.appendChild(text);
  </script>";
?>