<!DOCTYPE html>
<?php require("../register/login.php") ?>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
        <title>Meniu</title>
        <meta content="" name="description"/>
        <meta content="" name="keywords"/>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <script src="https://kit.fontawesome.com/6f0d43d3cc.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="meniuStyle.css"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.0/css/fontawesome.min.css" integrity="sha384-z4tVnCr80ZcL0iufVdGQSUzNvJsKjEtqYZjiQrrYKlpGow+btDHDfQWkFjoaz/Zr" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css"/>
    </head>
<body>
    <section class="header" id="header">
        <div class="nav-bar">
            <div class="menu">
                <ul>
                    <li><a href="../register/register.php" class="active">Conectează-te</a></li>
                    <li><a href="#" class="plata" id="plata">Plătește</a></li>
                    <li><a href="#" class="rating" id="rating">Istoricul meu</a></li>
                    <li><a href="#" class="nota" id="nota">Notează parcarea</a></li>
                </ul>
            </div>
        </div>
        <div class="hero">
            <div class="row">
                <div class="left-sec">
                    <div class="content">
                        <h2><span>Parchează</span><br>fără stres!</h2>
                        <p>Site-ul nostru poate fi folosit în cele mai mari orașe din țară. Plătește rapid, evită amenda și accesează oricând istoricul parcărilor tale!</p>
                    </div>
                </div>
                <div class="my-car">
                    <div><img src="../images/bucuresti.jpg"/></div>
                    <div><img src="../images/timisoara.jpg"/></div>
                    <div><img src="../images/cluj.jpg"/></div>
                    <div><img src="../images/iasi.jpg"/></div>
                    <div><img src="../images/constanta.JPG"/></div>
                </div>
            </div>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $(".my-car").slick({
                autoplay: true,
                dots: true,
                speed: 1000,

            })
        });
    </script>
    <script src="meniu.js"></script>
</body>    
</html>