<?php
    session_start();
    require_once('utils/jungle.php');

    if(!isset($_SESSION['connect'])){
        header("location: index.php");
    }

    if(isset($_GET['id'])){
        $idDestinataire = $_GET['id'];
        
    }
    
    $idUser = $_SESSION['id'];
    $participantArr = array();

    if(isset($_POST['text'])){
        $text = htmlentities($_POST['text']);
        $sql = "INSERT INTO messages(id_expediteur,id_destinataire,message) VALUES(?,?,?)";
        $query = $bdd->prepare($sql);
        $query->execute(array($idUser,$idDestinataire,$text));
        header("location: accueil.php?chat=1&id=$idDestinataire");
        exit();
    }

    //Chargement des destinataires.
    $sql = "SELECT id,username FROM users WHERE id!=? ORDER BY id ASC";
    $query = $bdd->prepare($sql);
    $query->execute(array($idUser));

    while($row = $query->fetch()){
       $idTemp = array($row['id'], $row['username']);
       array_push($participantArr,$idTemp);
       $idTemp=array();
    }



    // var_dump($participantArr);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Cloud Messenger</title>
</head>
<body>

    <div class="containerChat">
        <div class="participants">
            <div class="titreParticipants"><h2><span class="blue">P</span>articipants</h2></div>
            <?php
                for($i=0;$i<count($participantArr);$i++){
                    echo "<a href='accueil.php?chat=1&id=".$participantArr[$i][0]."'><div class='participant'>".$participantArr[$i][1]."</div></a>";
                };
                ?>
        </div>
        <div class="chat">
                <?php          
                        echo "<h1><span class='blue'>Hi</span> <span style='text-transform: capitalize;'>".$_SESSION['username']."</span></h1>";
                    ?>
            
                <?php

                    if(isset($_GET['chat'])){
                        $sql = "SELECT username FROM users where id=?";
                        $query=$bdd->prepare($sql);
                        $query->execute(array($_GET['id']));
                        ?>
                        <div class="header">
                        <?php
                        echo "<a class='btnHeader' href='accueil.php?chat=1&id=".$idDestinataire."'>Refresh</a>";
                        while($row = $query->fetch()){
                            echo "<div class='discutionUser'><span class='blue'>D</span>iscuss with ".$row['username']."</div>";
                            
                        }
                        ?>
                        <a class='btnHeader' href="disconnect.php">Disconnect</a>
                        </div>
                        <div class="messages">
                            <?php
                        $sql = "SELECT message,m.id_destinataire,date
                        FROM messages m 
                        INNER JOIN users u 
                        ON u.id=m.id_destinataire AND m.id_expediteur=?
                        OR m.id_destinataire=? AND m.id_expediteur=u.id
                        WHERE u.id=?
                        ORDER BY m.id ASC";
                        $query = $bdd->prepare($sql);
                        $query->execute(array($_GET['id'],$_GET['id'],$idUser));
                        while($row = $query->fetch()){
                            $heure = substr($row['date'],11,5);
                            if($row['id_destinataire']!=$idUser){
                                echo "<div class=textDroite><div class='inlineblockDroite'><p>".$row['message']."</p><p classe='heureTexte'>".$heure."</p></div></div><br>";
                            }else{
                                echo "<div class=textGauche><div class='inlineblockGauche'><p>".$row['message']."</p><p classe='heureTexte'>".$heure."</p></div></div><br>";
                            }
                        }
                    }
                ?>
            </div>
            <?php
            if(isset($_GET['chat'])){
                ?>
                <form class='text' action="accueil.php?chat=1&id=<?php echo $_GET['id']?>" method="post">
                        <textarea name="text" id="" maxlength="164" sentences style="resize:none;"></textarea>
                    <button type="submit">Envoyer</button>
                    </form>
                    <?php
            }
            ?>
            
        </div>
        
        
    </div>
</body>
</html>