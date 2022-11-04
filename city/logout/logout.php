<!DOCTYPE html>
<?php
 session_start();
 $inactivitate=0;
 if(isset($_SESSION['inactivitate']))
    $inactivitate=$_SESSION['inactivitate'];
 session_destroy();
 if($inactivitate){
    $alert="<script>alert('Ați fost deconectat din cauza inactivității');
    window.location.assign('../../meniu/meniu.php');</script>";
    echo $alert;
 }else{
    $alert="<script>alert('V-ați deconectat cu succes');
    window.location.assign('../../meniu/meniu.php');</script>";
    echo $alert;
 }
?>
</html>