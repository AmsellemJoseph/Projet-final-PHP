<?php

    class Register{
        public $username="";
        private $email="";
        private $password="";
        private $bdd="";
        public $usernameLogged="";
        public $id="";

        public function __construct($bdd,$username,$email,$password){
            $this->bdd = $bdd;
            $this->username = $username;
            $this->email = $email;
            $this->password = $password;
        }

        public function verifUsername(){
            $sql = "SELECT COUNT(*) as x FROM users WHERE username=?";
            $query = $this->bdd->prepare($sql);
            $query->execute(array($this->username));

            while($row = $query->fetch()){
                if($row['x'] !=0){
                    return false;
                }
            }
            return true;
        }

        public function verifMail(){
            $sql = "SELECT COUNT(*) as mail FROM users WHERE email=?";
            $query = $this->bdd->prepare($sql);
            $query->execute(array($this->email));

            while($row = $query->fetch()){
                if($row['mail'] !=0){
                    return false;
                }
            }
            return true;
        }
        public function registration(){
            $sql = "INSERT INTO users(username,email,password) VALUES(?,?,?)";
            $query = $this->bdd->prepare($sql);
            $query->execute(array($this->username, $this->email, $this->password));
        }

        public function login(){
            $sql = "SELECT * FROM users WHERE email=?";
            $query = $this->bdd->prepare($sql);
            $query->execute(array($this->email));

            while($row = $query->fetch()){
                if($row['password']==$this->password){
                    $this->id=$row['id'];
                    $this->usernameLogged = $row['username'];
                    return true;
                }
            }

            return false;

        }

    }


?>