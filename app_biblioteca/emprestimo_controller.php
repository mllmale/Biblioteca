<?php 
    require 'empresto.php';
    require 'teste.service.php';
    require 'conexao.php';

    function converterData($dataMySQL) {
        return date("d/m/Y", strtotime($dataMySQL));
    }
    $acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

    if (isset($_GET['acao']) && $_GET['acao'] == 'inserir') {
        $cpf = $_POST['cpf'];
        $nome = $_POST['nome'];
        $titulo = $_POST['titulo'];
        $data = $_POST["data"];

        $emprestimo = new Empresto();
        $emprestimo->__set('nome', $nome);
        $emprestimo->__set('cpf', $cpf);
        $emprestimo->__set('titulo', $titulo);
        $emprestimo->__set('data', $data);

        $conexao = new Conexao('db_library');
        $emprestimoService = new Livro_service($conexao, $emprestimo);
        
        if ($emprestimoService->verificaAluno($cpf, $nome) && $emprestimoService->verificaLivro($titulo)) {
            $emprestimoService->inserir(
                'insert into tb_emprestimo (nome, cpf, titulo, data) values (:nome, :cpf, :titulo, :data)',
                'nome',
                'cpf',
                'titulo', 
                'data'
            );
        
            header('Location: emprestimo.php?inclusao=1');

        } else {
            header('Location: emprestimo.php?inclusao=1');
            $mensagem = "O aluno com o CPF e nome fornecidos não existe no banco de dados.</br>";
        }

    } else if ($acao == 'recuperar') {
        $emprestimo = new Empresto();
        $conexao = new Conexao('db_library');
        $emprestimoService = new Livro_Service($conexao, $emprestimo);

        $campos = 'nome, cpf, titulo, data, id';

        $camposArray = explode(', ', $campos);

        $emprestimos = $emprestimoService->recuperar('tb_emprestimo', $camposArray);
        foreach ($emprestimos as &$emprestimo) {
            $emprestimo->data = converterData($emprestimo->data);

        }
    }else if ($acao == 'remover') {
        $emprestimo = new Empresto();
        $emprestimoId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($emprestimoId !== false) {
            $emprestimo->setId($_GET['id']);
            $conexao = new conexao('db_library');
            $emprestimoService = new Livro_service($conexao, $emprestimo);
            $emprestimoService->remover('tb_emprestimo', $emprestimo);
            header('Location: emprestimo.php?inclusao=1');
        } else {
            echo 'que pena';
        }
    }

?>
