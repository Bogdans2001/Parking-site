<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="istoric.css">
        <title>Istoric</title>
    </head>
    <body>
        <table>
            <tr>
               <th>Zonă</th> 
               <th>Nota</th>
            </tr>
            <?php
            session_start();
            $connection=new mysqli('127.0.0.2:3307','root','','site_database');
            if($connection->connect_error){
             die("Connection failed :" .$connection->connect_error);
            }
            $query="SELECT zona, rating FROM ".$_SESSION['cityName'];
            $result=$connection->query($query);
            if($result-> num_rows > 0){
                while($row = $result->fetch_assoc()){
                    if($row['rating']==0) echo "<tr><td>".$row['zona']."</td><td>N/A</td></tr>";
                    else echo "<tr><td>".$row['zona']."</td><td>".$row['rating']."</td></tr>";
                }
                echo "</table>";
            }else{
                echo "Nu aveti nicio nota";
            }
            $connection->close();
            ?>
        </table>
    </body>
</html>