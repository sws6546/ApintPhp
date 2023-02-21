<?php
    require_once('vars.php');
    session_start();

    if(isset($_POST['submit'])){
        $url = 'https://api.testmail.app/api/json?apikey='.$mailApiKey.'&namespace=vu6m5&tag=apint';
        $data = file_get_contents($url);
        $data = json_decode($data, true);

        for($i = 0; $i < count($data['emails']); $i++){
            if($data['emails'][$i]['from_parsed'][0]['address'] == $_COOKIE['email']){
                if(chop($data['emails'][$i]['text']) == $_COOKIE['verifyCode']){

                    $con = mysqli_connect($dbHost, $dbUsername, $dbPassword, $db);
                    $username = $_COOKIE['username'];
                    $email = $_COOKIE['email'];
                    $password = $_COOKIE['password'];
                    mysqli_query($con, "INSERT INTO users VALUES (NULL, '$username', '$password', '$email')");
                    mysqli_close($con);

                    if(isset($_SESSION['e_verify'])){
                        unset($_SESSION['e_verify']);
                    }
                    header('Location: witaj.php');
                    exit();

                }else{
                    $_SESSION['e_verify'] = "nie znaleziono";
                }
            }else{
                $_SESSION['e_verify'] = "nie znaleziono";
            }
        }
    }else{
        header("Location: index.php");
        exit();
    }
?>

<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Weryfikacja adresu email.</title>
    <link rel="stylesheet" href="register.css">
    <style>
        body{
            color: white;
        }
    </style>
</head>
<body>
    <form action="mailVerify.php" method="post" style="color: black;">
        <h2>Kod weryfikacyjny: <?php echo $_COOKIE['verifyCode']; ?></h2>
        <p>Należy go wysłać <strong>z</strong> maila <i><?php echo $_COOKIE['email']; ?></i> <strong>na</strong> mail <i>vu6m5.apint@inbox.testmail.app</i></p>
        <p>następnie kliknąć przycisk sprawdzający.</p>
        <p>Kod działa tylko przez 10 minut.</p>
        <input type="submit" value="Sprawdź" name="submit">
        <?php
            if(isset($_SESSION['e_verify'])){
                echo '<p style="color: red;">Nie znaleziono. Poczekaj kilka sekund lub wyślij maila ponownie.</p>';
                unset($_SESSION['e_verify']);
            }
        ?>
    </form>
</body>
</html>
