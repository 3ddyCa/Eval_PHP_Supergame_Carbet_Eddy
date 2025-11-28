
<?php

    ///////////////////////////////////////////////
    ///==============DOCUMENTATION=============///
    /////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////////////////////////////
    //
    //      Le controller ici présent est le routeur du domaine.   
    //
    ////////////////////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////////////////////////////
    //Il dispose des propriétés suivantes:
    ///////////////////////////////////////////////////////////////////////////////////////////
    //*route* - arry - méthode get/set en camel case - 
    // -> à set à l'initialisation
    // ! Contiens une table d'association sous le format [url-client => routage-serveur] !
    //
    //*client* - string - méthode get/set en camel case - 
    // -> se set automatiquement à linitialisation
    // ! Contiens la destination sur l'URI client partie 'path' !
    //
    ////////////////////////////////////////////////////////////////////////////////////////////
    //Il dispose des méthodes suivantes:
    ///////////////////////////////////////////////////////////////////////////////////////////
    //
    //*get/set* get output le type de la propriété et set prend le type de la propriété en paramètre et output l'objet
    //
    //*render* prends null en input et output une string d'affichage

    session_start();
    include './model/model_players.php';
    include './utils/utils.php';

    //////////////////////////////////////////////
    ///================ROUTEUR================///
    //////////////////////////////////////////////  

    class Router{
        private array $route;
        private string $client;

        public function __construct(string $origin, string $destination){
            $client = parse_url($_SERVER['REQUEST_URI']);
            $this->route = [$origin => $destination];
            $this->client = $client['path'] ;
        }

        //////////////////////////////////////////////
        ///==============GETTERS-SETTERS===========///
        //////////////////////////////////////////////

        public function getClient():string{
            return $this->client ;
        }
        public function setClient(string $input):self{
            $this->client = $input;
            return $this;
        }

        public function setRoute(string $origin, string $destination):self{
            $this->route[$origin] = $destination;
            return $this;
            
        }
        public function getDestination(string $input):string{
            return $this->route[$input];

        }
        public function getRouteTable(string $choice=""){
            if($choice == "hr"){
                return print_r($this->getRouteTable());
            }else{
                return $this->route;
            }           
        }

        //////////////////////////////////////////////
        ///============METHODES COMPLEXES==========///
        //////////////////////////////////////////////

        public function renderRoute(){
            include $this->getDestination($this->getClient());            
        }
    }

    //////////////////////////////////////////////
    ///================RENDU===================///
    //////////////////////////////////////////////  

    $router = new Router('/supergame/Public/','./controller/controller_home.php');
    $router->setRoute('/supergame/Public/Deconnexion','./model/deconnexion.php');
    $router->renderRoute();
    include './view/footer.php';
?>