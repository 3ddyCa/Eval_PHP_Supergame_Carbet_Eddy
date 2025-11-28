<!-- VIEW DE LA PAGE D'ACCUEIL -->
<?php

    ////////////////////////////////////////////////////////////////////////////////////////////
    ///==============DOCUMENTATION=============///
    //////////////////////////////////////////////////////////////////////////////////////////// 

    ////////////////////////////////////////////////////////////////////////////////////////////
    //
    //      Le modèle ici-présent a pour objectif d'afficher la vue HTML sur le controller.   
    //
    ////////////////////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////////////////////////////
    //Il dispose des propriétés suivantes:
    ///////////////////////////////////////////////////////////////////////////////////////////
    //*isConnected* - string - méthode get/set en camel case - 
    // -> à set plus tard
    // ! Affichage conditionnel selon la présence ou non d'une session utilisateur !
    //
    //*message* - string - méthode get/set en camel case - 
    // -> à set plus tard
    // ! Message de log des opérations d'inscription/connexion et erreur !
    //
    //*playerFile* - string - méthode get/set en camel case - 
    // -> à set plus tard
    // ! Affichage de la scoreboard des joueurs !
    //
    //*session* - string - méthode get/set en camel case - 
    // -> à set plus tard
    // ! session actuelle utilisateur, vide si inexistante !
    //
    ////////////////////////////////////////////////////////////////////////////////////////////
    //Il dispose des méthodes suivantes:
    ///////////////////////////////////////////////////////////////////////////////////////////
    //
    //*get/set* get output le type de la propriété et set prend le type de la propriété en paramètre et output l'objet
    //
    //*render* prends null en input et output une string d'affichage


    class ViewHome{
    
        private string $isConnected ='';
        private string $message;
        private string $playerFile ='';
        private string $session ='';

        public function __construct(){
            $this->session = (isset($_SESSION['pseudo'])?$_SESSION['pseudo']:'');
        }

        //////////////////////////////////////////////
        ///==============GETTERS-SETTERS===========///
        //////////////////////////////////////////////

        public function getIsConnected():string{
            return $this->isConnected ;
        }
        public function setIsConnected(string $input):self{
            $this->isConnected = $input;
            return $this;
        }
        public function getSession():string{
            return $this->session ;
        }
        public function setSession(string $input):self{
            $this->session = $input;
            return $this;
        }
        public function getMessage():string{
            return $this->message ;
        }
        public function setMessage(string $input):self{
            $this->message = $input;
            return $this;
        }
        public function getPlayerFile():string{
            return $this->playerFile ;
        }
        public function setPlayerFile(string $input):self{
            $this->playerFile = $input;
            return $this;
        }

        public function renderHome(){
            try{
                if(!empty($this->session)){
                    $this->setIsConnected('<h2>Bonjour '.$this->getSession().' !</h2>
                    <button id="jouer" type="button">JOUER</button>
                    <a href="/supergame/Public/Deconnexion" >Déconnexion</a>');
                }else{
                    $this->setIsConnected('
                            <form action="" method="post">
                                <fieldset >
                                    <legend><h2>Connexion Utilisateur</h2></legend>
                                    <label for="email">Email</label><input type="text" id="email" name="email">
                                    <label for="password">Mot de Passe</label><input type="text" id="password" name="password">
                                    <input type="submit" name="signUp" value="Se connecter">
                                </fieldset>
                            </form>
                            <form action="" method="post">
                                <fieldset >
                                    <legend><h2>Inscription Utilisateur</h2></legend>
                                    <label for="pseudo">Pseudo</label><input type="text" id="pseudo" name="pseudo">
                                    <label for="email">Email</label><input type="text" id="email" name="email">
                                    <label for="password">Mot de Passe</label><input type="text" id="password" name="password">
                                    <label for="re_password">Retappez le Mot de Passe</label><input type="text" id="re_password" name="re_password">
                                    <input type="submit" name="signIn" value="S\'inscrire">
                                    <input type="reset" value="effacer">
                                </fieldset>
                            </form>');
                }
                echo '<header>
                        <h1>Bienvenue sur Super Game </h1>
                        <nav>
                            <ul>
                                <li><a href="#" alt="Accueil">Accueil</a></li>
                            </ul>
                        </nav>
                    </header>
                    <main>
                        <section id="main_Inscription">
                            '.$this->getIsConnected().'
                        </section>
                        <section id="main_Log">
                            <p>'.$this->getMessage().'
                        </section>
                        <section id="main_Display">
                            <article id="display_container">
                            <h2>Score board</h2>
                                '.$this->getPlayerFile().'
                            </article>
                        </section>
                        
                    </main>';

            
            }catch(EXCEPTION $error){
                die($error->getMessage());
            }
        }
    }
?>
    
