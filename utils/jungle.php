<?php

    $servername = "localhost"; 
    $username = "JoAms"; 
    $password = "DT4nlhcQUwIJX2dA";
    $dbname = "webschool_chat";


    try {
       $bdd = new PDO('mysql:host='.$servername.';dbname='.$dbname.';charset=utf8',$username,$password);
        // echo "OK";
    } catch (Exception $e) {
        die("Erreur: ".$e->getMessage());
    }

?>