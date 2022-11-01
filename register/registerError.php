<?php require("login.php") ?>
<?php require("connection.php") ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset = "UTF-8">
        <title>Autentificare</title>
        <link rel="stylesheet" href="styleRegister.css"/>
        <?php
        if($email_error != null){
            ?> <style>.errorEmailLogin{display: block} </style> <?php
        }
        if($password_error != null){
            ?> <style>.errorPasswordLogin{display: block} </style> <?php
        }
        if($confirmPassword_error != null){
            ?> <style>.errorConfirmPassword{display: block} </style> <?php
        }
        if($error_Register != null){
            ?> <style>.errorRegister{display: block} </style> <?php
        }
        ?>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <script src="https://kit.fontawesome.com/6f0d43d3cc.js" crossorigin="anonymous"></script>
    </head>

    <body>
        <section class="container forms">
            <div class="form signup">
                <div class="form-content">
                    <header>Înregistrează-te</header>
                    <form action="" method="post" autocomplete="off">
                        <div class="field input-field">
                            <i class="fas fa-user"></i>
                            <input type="text" placeholder="Nume" class="input" name="username"
                            value="<?php echo $usernameRegister;?>"/>
                        </div>
                        <div class="field input-field">
                            <i class="fas fa-envelope"></i>
                            <input type="email" placeholder="Email" class="input" name="email"
                            value="<?php echo $emailRegister;?>"/>
                        </div>
                        <div class="field input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" placeholder="Parolă" class="password" name="password"/>
                            <i class='bx bx-hide eye-icon' ></i>
                            <p class="errorConfirmPassword">
                            <?php echo $confirmPassword_error; ?></p>
                        </div>
                        <div class="field input-field">
                            <i class="fas fa-lock"></i>
                            <input type="password" placeholder="Confirmă parola" class="password" name="confirmPassword"/>
                            <i class='bx bx-hide eye-icon' ></i>
                            <p class="errorRegister">
                            <?php echo $error_Register; ?></p>
                        </div>
                        <div class="signupButton-field">
                            <button type="submit" name="signupButton">Înregistrează-te</button>
                        </div>
                        <div class="signupForm-link">
                            <span> Ai deja un cont? <a href="../register/register.php" class="link login-link">Conectează-te</a></span>
                        </div>
                    </form>
                </div>
                <div class="line"></div>
                <div class="adminLink">
                    <span><a href="#" class="admin-link">Conectează-te ca reprezentant al unui oraș</a></span>
                </div>
            </div>
            </section>
        </section>

        <script src="registerError.js"></script>
    </body>
</html>