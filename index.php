<?php
    session_start();
    if(isset($_SESSION['username'])){
        header("Location: main.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Roksa 2</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <header>
        <h1>Roksa 2</h1>
        <div id="btns">
            <a href="register.php">
                <input type="button" value="Sign Up" class="signupBtn">
            </a>
        </div>
    </header>
    <section id="first">
        <div class="container">
            <div class="text">
                <h1>Witaj na stronie Roksa 2!</h1>
                <p>Jest to serwis umożliwiający wystawianie ofert na pogaduszki.</p><br>
                <p>Załóż darmowe konto, lub zaloguj się</p>
            </div>
                <form action="login.php" method="post">
                    <div>
                        <label for="login">Login</label>
                        <input type="text" name="login" id="login" placeholder="eg. k0walski123">
                        <label for="password">Hasło</label>
                        <input type="password" name="password" id="password" placeholder="eg. ********"><br>
                    </div>
                    <input type="submit" value="Log In" class="loginBtn">
                    <?php
                        if(isset($_SESSION['loginErr'])){
                            echo '<p style="color: red;">'.$_SESSION['loginErr'].'</p>';
                            unset($_SESSION['loginErr']);
                        }
                    ?>
                </form>
            </div>
    </section>
</body>
</html>