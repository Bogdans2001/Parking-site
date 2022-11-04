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
               <th>Număr înmatriculare</th>
               <th>Oraș</th>
               <th>Zonă</th> 
               <th>Data</th>
            </tr>
            <?php
            $connection=new mysqli('127.0.0.2:3307','root','','site_database');
            if($connection->connect_error){
             die("Connection failed :" .$connection->connect_error);
            }
            $query="SELECT nr_inmatriculare, oras, zona, data FROM payment";
            $result=$connection->query($query);
            if($result-> num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<tr><td>".$row['nr_inmatriculare']."</td><td>".$row['oras']."</td><td>".$row['zona']."</td><td>".$row['data']."</td></tr>";
                }
                echo "</table>";
            }else{
                echo "Nu aveti nicio plata";
            }
            $connection->close();
            ?>
        </table>
    </body>
</html>