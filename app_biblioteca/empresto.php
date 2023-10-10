<?php
    class Empresto{
        private $nome;
        private $titulo;
        private $id;
        private $cpf;
        private $data;

        public function __get($atributo){
            return $this->$atributo;
        }

        public function __set($atributo, $valor){
            $this->$atributo = $valor;
        }

        public function setId($id) {
            $this->id = $id;
        }
    }
?>