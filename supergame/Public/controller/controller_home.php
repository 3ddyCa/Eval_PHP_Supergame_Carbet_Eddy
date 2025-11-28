<?php
    ///////////////////////////////////////////////
    ///==============DOCUMENTATION=============///
    /////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////////////////////////////
    //
    //      Le controller ici présent est le controlleur de /home.   
    //
    ////////////////////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////////////////////////////
    //Il dispose des propriétés suivantes:
    ///////////////////////////////////////////////////////////////////////////////////////////
    //*message* - string - méthode get/set en camel case - 
    // -> vide à l'initialisation
    // ! le log à afficher en fonction des évènements !
    //
    //*playerFIle* - array - méthode get/set en camel case - 
    // -> se set automatiquement à linitialisation
    // ! contiens le fetch de la liste des joueurs grâce à modelPlayer !
    //
    //*playerList* - string - méthode get/set en camel case - 
    // -> remplis lors de l'affichage
    // ! Contiens la destination sur l'URI client partie 'path' !
    //
    //*modelPlayer* - ModelPlayer/Objet - méthode get/set en camel case - 
    // -> se set automatiquement à linitialisation
    // ! contiens un objet de la classe ModelPlayer pour fetch des informations player sur la bdd !
    //
    ////////////////////////////////////////////////////////////////////////////////////////////
    //Il dispose des méthodes suivantes:
    ///////////////////////////////////////////////////////////////////////////////////////////
    //
    //*get/set* get output le type de la propriété et set prend le type de la propriété en paramètre et output l'objet
    //
    //*authLogic* prends null en input lance un algorithme d'authentification et remplis la propriété message
    //
    //*registerLogic* prends null en input lance un algorithme d'enregistrement et remplis la propriété message
    //
    //*displayPlayer* prends null en input et output null et remplis la propriété playerList
    //
    //*renderHome* prends null en input et output une string d'affichage

    //////////////////////////////////////////////
    ///================LOGIQUE================///
    //////////////////////////////////////////////  


class ControlHome{

    private string $message;
    private array $playerFile;
    private string $playerList;
    private ModelPlayer $modelPlayer;

    public function __construct(){
        $this->message = "";
        $this->modelPlayer = new ModelPlayer();
        $this->playerFile = $this->modelPlayer->getPlayers();
        $this->playerList = "";

    }

    //////////////////////////////////////////////
    ///==============GETTERS-SETTERS===========///
    //////////////////////////////////////////////

    public function getMessage():string{
        return $this->message;
    }
    public function setMessage($input):self{
        $this->message = $input;
        return $this;
    }
    public function getModelPlayer():ModelPlayer{
        return $this->modelPlayer;
    }
    public function setModelPlayer($input):self{
        $this->modelPlayer = $input;
        return $this;
    }

    public function getPlayerList():string{
        return $this->playerList;
    }
    public function setPlayerList($input):self{
        $this->playerList = $input;
        return $this;
    }
    public function getPlayerFile():array{
        return $this->playerFile;
    }
    public function setPlayerFile($input):self{
        $this->playerFile = $input;
        return $this;
    }

//////////////////////////////////////////////
///============METHODES COMPLEXES==========///
//////////////////////////////////////////////

////////////////////////////////////////////////////////////
//=================FORMULAIRE-CONNEXION================//
///////////////////////////////////////////////////////////

    public function authLogic(){
        try{
            if(isset($_POST['signUp'])){
                if(!empty($_POST['email']) && !empty($_POST['password'])) {
                    if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                        $email = sanitize($_POST['email']);
                        $mdp = sanitize($_POST['password']);
                        $user =  $this->getModelPlayer()->getPlayerByEmail($email);
                        $re_mdp = $user['password'];
                        $pseudo = $user['pseudo'];
                        if(password_verify($mdp, $re_mdp)){
                            
                            $_SESSION = [
                                'pseudo' => $pseudo,
                                'email' => $email,
                                'password' => $mdp,
                            ];
                            $this->setMessage("Utilisateur ".$_SESSION['pseudo']." authentifié !");
                        }

                    }else{
                    $this->setMessage('Veuillez entrer un email valide');
                }
                }else{
                    $this->setMessage('Veuillez renseigner tous les champs');
                }
            }
        }catch(EXCEPTION $error){
            die($error->getMessage());
        }
    }
////////////////////////////////////////////////////////////
//=================FORMULAIRE-INSCRIPTION================//
///////////////////////////////////////////////////////////
    public function registerLogic(){
        try{
            if(isset($_POST['signIn'])){
                if(!empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['re_password'])){
                    if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                        $pseudo = sanitize($_POST['pseudo']);
                        $email = sanitize($_POST['email']);
                        $mdp = sanitize($_POST['password']);
                        $re_mdp = sanitize($_POST['re_password']);
                        if($mdp === $re_mdp){
                            
                            $mdp = password_hash($mdp, PASSWORD_DEFAULT);
                            $this->getModelPlayer()->addPlayer($pseudo, $email, $mdp);
                            $this->setMessage("L'utilisateur ".$pseudo." a été enregistré avec succès !");

                        }

                    }else{
                    $this->setMessage('Veuillez entrer un email valide');
                }
                }else{
                    $this->setMessage('Veuillez renseigner tous les champs');
                }

            }
        }catch(EXCEPTION $error){
            die($error->getMessage());
        }
    }
////////////////////////////////////////////////////////////
//=================AFFICHAGE-JOUEURS======================//
///////////////////////////////////////////////////////////
    public function displayPlayers(){
        try{
            if(!empty($this->getPlayerFile())){
                //Début de la liste principale
                $count = 1;
                $playerList = "<ul>";
                foreach($this->getPlayerFile() as $player){
                    //On liste ses propriétés
                    $playerList = $playerList."<ul id='joueur_".$count."'class='scoreDivision'>
                    <li> Id :".$player['id']."</li> <!-- Optionnel -->
                    <li><h3> Pseudo : ".$player['pseudo']."</h3></li>
                    <li> Score : ".$player['score']."</li>
                    <li><em> Email : ".$player['email']."</em></li> <!-- Optionnel -->
                    <li><em> Password : ".$player['password']."</em></li> <!-- Optionnel -->          
                    </ul><br>";
                    $count++;
                }
                $playerList = $playerList."</ul>";

            }else{
                $playerList = "Aucun joueur à afficher";
            }
            $this->setPlayerList($playerList);
        }catch(EXCEPTION $error){
            die($error->getMessage());
        }
    }
    public function displayHome(){
        try{
            $this->authLogic();
            $this->registerLogic();
            $this->displayPlayers();
            include './view/view_home.php';
        }catch(EXCEPTION $error){
                die($error->getMessage());
        }
    }

}

//============================**




    //////////////////////////////////////////////
    ///================RENDU===================///
    ////////////////////////////////////////////// 

    $controller = new ControlHome();
    $controller->getModelPlayer();
    include './view/header.php';  
    $header = new Header();
    $header->setStyle('*{
        body{
            margin:0;
            header{
                display:flex;
                flex-direction:row;
                justify-content:space-around;
                align-items:center;
                background-color:tomato;
                *{
                    color:white;
                }
                ul{
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    list-style-type:none;
                    li{
                        a{
                            
                            font-size:1em;
                            font-decoration:none;
                            
                        }
                    }
                }

            }
            main{
                #main_Inscription{
                    display:flex;
                    flex-direction:column;
                    align-items:center;
                    & button{
                        margin:5%;
                    }
                    fieldset{
                        display:flex;
                        flex-direction:column;
                        height:fit-content;
                        justify-content: center;
                        align-items:center;
                        border-radius:1em;
                        margin: 5%;
                        padding:2em;
                        input{
                            width:30em;
                            margin:0.5%;
                            padding:0.5em;
                            border-radius:0.5em;
                        }

                    }

                    button{
                        border-style:solid;
                        font-size:1.2em;
                    }

                    #jouer{
                        border-style:solid;
                        border-radius:1em;
                        background-color:tomato;
                        color:white;
                        padding:2em;
                        font-size:1.5em;
                        font-weight:700;


                    }

                }
               
                
                #main_Display{
                    margin:5%;
                    display:flex;
                    justify-content:center;
                    .scoreDivision{
                    display:flex;
                    flex-direction:column;
                    justify-items:center;
                    padding:1%;
                    border-width:1px 0 0 0;
                    border-style:solid;
                    border-color:black;
                    list-style-type:none;
                    }
                    #joueur_1{
                        background-color:yellow;
                        width:100%;
                    }
                }
                #main_Log{
                    margin:5%;
                    p{
                        color:red;
                    }
                }
                
            }
            footer{
                position:fixed;
                bottom:0;
                width:100%;
                display:flex;
                flex-direction:row;
                justify-content:space-around;
                align-items:center;
                background-color:tomato;
                *{
                    color:white;
                }
                ul{
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    list-style-type:none;
                    li{
                        a{
                            
                            font-size:1em;
                            font-decoration:none;
                            color:black;
                        }
                    }
                }
            }
        }
        /*all*/ 
        font-family:helvetica;
    }')->setTitle('Evaluation_PHP_MVC_Objet_EddyCarbet')->renderHeader();
    $controller->displayHome();
    $rendering = new ViewHome();
    $rendering->setMessage($controller->getMessage())->setPlayerFile($controller->getPlayerList());
    $rendering->renderHome();
    

?>