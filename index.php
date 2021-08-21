<?php
    session_start();
    if(isset($_SESSION['connect'])){
        header('location: accueil.php');
    }

    require_once("utils/jungle.php");
    require_once("utils/Registration.php");
    
    if(!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['pass1']) && !empty($_POST['pass2'])){

        $username = htmlentities($_POST['username']);
        $email = htmlentities($_POST['email']);
        $pass1 = htmlentities($_POST['pass1']);
        $pass2 = htmlentities($_POST['pass2']);
        $password = "21".sha1($pass1."2108")."08";

        $user = new Register($bdd,$username,$email,$password);

        // Verif PASSWORD
        if($pass1!=$pass2){

            header('location: index.php?error=1&pass=1');
            exit();
        }

        // VERIF USERNAME EXISTE
        if(!$user->verifUsername()){
            header('location: index.php?error=1&user=1');
            exit();
        }


        // VERIF MAIL EXISTE
        if(!$user->verifMail()){
            header('location: index.php?error=1&mail=1');
            exit();
        }
        
        $user->registration();
        header('location: login.php');
        exit();
    }

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Registration</title>
</head>
<body>
    <div class="containerAllReg">
        <div class="containerImg">
            <h1><span class="blue">Cloud</span> messenger</h1>
        </div>
        <div class="containerReg">
            <h2><span class="blue">Create</span> your Account</h2>
            <?php

            if(isset($_GET['error'])){
                if(isset($_GET['pass'])){
                    echo "<p class='warning'>Please confirm the same password.</p>";
                }
                if(isset($_GET['user'])){
                    echo "<p class='warning'>This username is already taken.</p>";
                }
                if(isset($_GET['mail'])){
                    echo "<p class='warning'>This email is already taken.</p>";
                }
            }
            
            ?>
            <form action="index.php" method="post">
                <div class="inputReg">
                    <input type="text" name="username" placeholder="Username" required>
                </div>
                <div class="inputReg">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="inputReg">
                    <input type="password" name="pass1" placeholder="Password" required>
                </div>
                <div class="inputReg">
                    <input type="password" name="pass2" placeholder="Confirm Password" required>
                </div>
                
                <div class="subReg">
                    <button type="submit">Registration</button>
                </div>
            </form>
                <div class="subClick">
                    <p>Already have an account? <a href="login.php"><span class="blue">Click here</span></a></p>
                </div>
        </div>
    </div>
</body>
</html>