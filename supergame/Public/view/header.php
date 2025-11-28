<?php

    ///////////////////////////////////////////////
    ///==============DOCUMENTATION=============///
    /////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////////////////////////////
    //
    //      Le modèle ici-présent a pour objectif d'afficher le header'.   
    //
    ////////////////////////////////////////////////////////////////////////////////////////////

    ////////////////////////////////////////////////////////////////////////////////////////////
    //Il dispose des propriétés suivantes:
    ///////////////////////////////////////////////////////////////////////////////////////////
    //*title* - string - méthode get/set en camel case - 
    // -> à set plus tard
    // ! Contiens le titre du head !
    //
    //*style* - string - méthode get/set en camel case - 
    // -> à set plus tard
    // ! Contiens le css de la balise style en début de body !
    //
    ////////////////////////////////////////////////////////////////////////////////////////////

    class Header{
        private string $title;
        private string $style;

        public function construct(){}

        //////////////////////////////////////////////
        ///==============GETTERS-SETTERS===========///
        //////////////////////////////////////////////

        public function getTitle():string{
            return $this->title;
        }
        public function setTitle($input):self{
            $this->title = $input;
            return $this;
        }
        public function getStyle():string{
            return $this->style;
        }
        public function setStyle($input):self{
            $this->style = $input;
            return $this;
        }
        public function renderHeader(){
            echo '<!DOCTYPE html>
                    <html lang="fr">
                    <head>
                        <meta charset="UTF-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1.0">
                        <title>'.$this->title.'</title>
                    </head>
                    <body>
                    <style>
                    '.$this->style.'
                    </style>';
        }




    }
 ?>