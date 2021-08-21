<?php
    session_start();
    require_once("utils/jungle.php");
    require_once("utils/Registration.php");

    if(isset($_SESSION['connect'])){
        header("Location: accueil.php");
    }
    
    if(!empty($_POST['email']) && !empty($_POST['pass1'])){

        $email = htmlentities($_POST['email']);
        $pass1 = htmlentities($_POST['pass1']);
        $password = "21".sha1($pass1."2108")."08";

        $login = new Register($bdd,"",$email,$password);

        if(!$login->login()){
            echo "non";
            header('location: login.php?error=1');
            exit();
        }else{
            $_SESSION['connect'] = 1;
            $_SESSION['id'] = $login->id;
            $_SESSION['username'] = $login->usernameLogged;
            echo "oui";
            
            if(isset($_POST['stayConnect'])){
                setcookie('log',$user['secret'],time()+365*24*3600,"/",null,false,true);
            }

            header("location: index.php");
            exit();
        }
        

    }

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>
<body>
    <div class="containerAllReg">
        <div class="containerImg">
        <h1><span class="blue">Cloud</span> messenger</h1>
        </div>
        <div class="containerReg">
        <h2><span class="blue">Login</span> your Account</h2>

        <?php
        
        if(isset($_GET['error'])){
            echo "<p class='warning'>Email and/or password incorrect</p>";
        }
        
        ?>

            <form action="login.php" method="post">
                <div class="inputReg">
                    <!-- <label for="email">Email</label> -->
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="inputReg">
                    <!-- <label for="pass1">Password</label> -->
                    <input type="password" name="pass1" placeholder="Password" required>
                </div>
                <div class="check">
                <p><label><input type="checkbox" name="stayConnect" id="" checked>Connection automatique</label></p>
                </div>
                <div class="subReg">
                    <button type="submit">Login</button>
                </div>
            </form>
            <div class="subClick">
                    <p>Not registered yet? <a href="index.php"><span class="blue">Click here</span></a></p>
                </div>
        </div>
    </div>
</body>
</html>