<?php
    ////////////////////////////////////////////////////////////////////////////////////////////
    ///==============DOCUMENTATION=============///
    //////////////////////////////////////////////////////////////////////////////////////////// 

    ////////////////////////////////////////////////////////////////////////////////////////////
    //
    //      Le modèle ici-présent a pour objectif de manipulerles données de 
    //      la tables players de la db supergame.   
    //
    ////////////////////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////////////////////////////
    //Il dispose des propriétés suivantes:
    ///////////////////////////////////////////////////////////////////////////////////////////
    //*id* - integer - méthode get/set en camel case - 
    // -> peut être fournis à l'initialisation de la classe
    // ! Contiens l'id utilisateur selectionné en bdd !
    //
    //*pseudo* - string - méthode get/set en camel case - 
    // -> à set plus tard
    // ! Contiens le pseudo utilisateur selectionné en bdd !
    //
    //*email* - string - méthode get/set en camel case - 
    // -> à set plus tard
    // ! Contiens l'email utilisateur selectionné en bdd !
    //
    //*password* - string - méthode get/set en camel case - 
    // -> à set plus tard
    // ! Contiens le mode de passe utilisateur selectionné en bdd !
    //
    //*bdd* - PDO - méthode get/set en camel case - 
    // -> auto-initialisation à la création de l'objet
    // ! Contiens l'objet PDO de connexion à la bdd superame !
    //
    ////////////////////////////////////////////////////////////////////////////////////////////

    class ModelPlayer{

    //////////////////////////////////////////////
    ///==============INITIALISATION===========///
    //////////////////////////////////////////////        

        private int $id = 1;
        private string $pseudo;
        private string $email;
        private int $score;
        private string $password;
        private PDO $bdd;     

        public function __construct(?int $id = 1){
            $this->id = $id;
            $this->bdd = new PDO('mysql:host=localhost;dbname=supergame','root','',array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }

    //////////////////////////////////////////////
    ///==============GETTERS-SETTERS===========///
    //////////////////////////////////////////////

        public function getId():int{
            return $this->id ;
        }
        public function setId(int $input):self{
            $this->id = $input;
            return $this;
        }
        public function getPseudo():string{
            return $this->pseudo ;
        }
        public function setPseudo(string $input):self{
            $this->pseudo = $input;
            return $this;
        }
        public function getEmail():string{
            return $this->email ;
        }
        public function setEmail(string $input):self{
            $this->email = $input;
            return $this;
        }
        public function getScore():int{
            return $this->score ;
        }
        public function setScore(int $input):self{
            $this->score = $input;
            return $this;
        }
        public function getPassword():string{
            return $this->password ;
        }
        public function setPassword(string $input):self{
            $this->password = $input;
            return $this;
        }
        public function getBdd():PDO{
            return $this->bdd ;
        }
        public function setBdd(PDO $input):self{
            $this->bdd = $input;
            return $this;
        }

        //////////////////////////////////////////////
        ///============METHODES COMPLEXES==========///
        //////////////////////////////////////////////

        public function addPlayer(string $pseudo, string $email, string $password):string{
            try{
                $request = $this->getBdd()->prepare('INSERT INTO players(pseudo , email, score, psswrd) VALUE(?,?,0,?)');
                $request->bindParam(1,$pseudo,PDO::PARAM_STR);
                $request->bindParam(2,$email,PDO::PARAM_STR);
                $request->bindParam(3,$password,PDO::PARAM_STR);
        
                $request->execute();

                return "Le joueur".$pseudo."a bien été enregistré !";

            }catch(EXCEPTION $error){
                die($error->getMessage());
            }
        }

        public function getPlayers():array{
            try{

                $request = $this->getBdd()->prepare('SELECT p.id id, p.pseudo pseudo,p.email email , p.score, score, p.psswrd `password` FROM players p ORDER BY p.score DESC');

                $request->execute();

                 $playerFile = $request->fetchAll();

                return $playerFile;

            }catch(EXCEPTION $error){
                die($error->getMessage());
            }
        }
        public function getPlayerByEmail(string $email):array{
            try{
                $request = $this->getBdd()->prepare('SELECT p.id id, p.pseudo pseudo,p.email email, p.score, score, p.psswrd `password` FROM players p WHERE p.email = ?');
                $request->bindParam(1,$email,PDO::PARAM_STR);

                $request->execute();

                $playerFile = $request->fetch();

                return $playerFile;
            }catch(EXCEPTION $error){
                die($error->getMessage());
            }
        }
    }
?>