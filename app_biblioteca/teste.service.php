<?php
    class Livro_Service{
        private $conexao;
        private $atributo;
        public function __construct(Conexao $conexao, $atributo){
            $this->conexao = $conexao->conectar();
            $this->atributo = $atributo;
        }
        public function inserir($contexto, ...$atributo){
            $query = $contexto;
            $stmt = $this->conexao->prepare($query);
            foreach($atributo as $parametro){
                $stmt->bindValue(':'.$parametro, $this->atributo->__get($parametro));
            }
            $stmt->execute();
        }
        public function recuperar($contexto, $campos, $parametros = array()) {
            $camposSelecionados = implode(', ', $campos);
            $query = 'SELECT ' . $camposSelecionados . ' FROM ' . $contexto;
        
            if (!empty($parametros)) {
                $query .= ' WHERE titulo LIKE :consultaTitulo';
            }
        
            $stmt = $this->conexao->prepare($query);
        
            if (!empty($parametros)) {
                $stmt->bindParam(':consultaTitulo', $parametros[':consultaTitulo'], PDO::PARAM_STR);
            }
        
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        public function remover($contexto, $atributo){
            $query = 'DELETE FROM '.$contexto.' WHERE id = :id';
            $stmt = $this->conexao->prepare($query);
            $stmt->bindValue(':id', $atributo->__get('id'));
            $stmt->execute();
            
        }
        public function recuperar_livro($contexto, $campos = array(), $parametros = array()) {
            $camposSelecionados = empty($campos) ? '*' : implode(', ', $campos);
            $query = 'SELECT ' . $camposSelecionados . ' FROM ' . $contexto;
        
            if (!empty($parametros)) {
                $query .= ' WHERE titulo LIKE :consultaTitulo';
            }
        
            $stmt = $this->conexao->prepare($query);
        
            if (!empty($parametros)) {
                $stmt->bindParam(':consultaTitulo', $parametros[':consultaTitulo'], PDO::PARAM_STR);
            }
        
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        public function buscar_alunos($contexto, $campos, $parametros = array()) {
            $camposSelecionados = implode(', ', $campos);
            $query = 'SELECT ' . $camposSelecionados . ' FROM ' . $contexto;
        
            if (!empty($parametros)) {
                $query .= ' WHERE nome LIKE :consultaAluno OR cpf LIKE :consultaAluno';
            }
        
            $stmt = $this->conexao->prepare($query);
        
            if (!empty($parametros)) {
                $consultaAluno = '%' . $parametros[':consultaAluno'] . '%';
                $stmt->bindParam(':consultaAluno', $consultaAluno, PDO::PARAM_STR);
            }
        
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        public function verificaAluno($cpf, $nome) {
            $query = "SELECT COUNT(*) AS count FROM tb_aluno WHERE cpf = :cpf AND nome = :nome";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(':cpf', $cpf, PDO::PARAM_STR);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return ($resultado && $resultado['count'] > 0);
        }
        public function verificaLivro($titulo) {
            $query = "SELECT COUNT(*) AS count FROM tb_livro WHERE titulo = :titulo";
            $stmt = $this->conexao->prepare($query);
            $stmt->bindParam(':titulo', $titulo, PDO::PARAM_STR);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return ($resultado && $resultado['count'] > 0);
        }

    }
?>