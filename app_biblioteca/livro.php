<?php
    class Livro{
        private $id;
        private $titulo;
        private $autor;
        private $edicao;
        private $consultar;
    
        public function __get($atributo){
            return $this->$atributo;
        }

        public function __set($atributo, $valor){
            $this->$atributo = $valor;
        }

        public function getId(){
            return $this->id;
        }

        public function setId($id) {
            $this->id = $id;
        }
    }
?>