<?php
    class Aluno{
        private $id;
        private $nome;
        private $cpf;
        private $curso;
        private $telefone;
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