<?php
    require 'aluno2.php';
    require 'teste.service.php';
    require 'conexao.php';

    $acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;

    if (isset($_GET['acao']) && $_GET['acao'] == 'inserir') {
        $aluno = new Aluno();
        $aluno->__set('nome', $_POST['nome']);
        $aluno->__set('cpf', $_POST['cpf']);
        $aluno->__set('telefone', $_POST['telefone']);
        $aluno->__set('curso', $_POST['curso']);

        $conexao = new Conexao('db_library');

        $alunoService = new Livro_service($conexao, $aluno);
        $alunoService->inserir(
            'insert into tb_aluno (nome, cpf, telefone, curso, id) values (:nome, :cpf, :telefone, :curso, :id)',
            'nome',
            'cpf',
            'telefone',
            'curso',
            'id'
        );

        header('Location: index.php?inclusao=1');
    } else if ($acao == 'recuperar') {
        $aluno = new Aluno();
        $conexao = new Conexao('db_library');
        $alunoService = new Livro_Service($conexao, $aluno);

        $campos = 'nome, id, cpf, telefone, curso';

        $camposArray = explode(', ', $campos);

        $alunos = $alunoService->recuperar('tb_aluno', $camposArray);

    } else if ($acao == 'remover') {
        $aluno = new Aluno();
        $alunoId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($alunoId !== false) {
            $aluno->setId($_GET['id']);
            $conexao = new conexao('db_library');
            $alunoService = new Livro_service($conexao, $aluno);
            $alunoService->remover('tb_aluno', $aluno);
            header('Location: index.php?inclusao=1');
        } else {
            echo 'que pena';
        }

    } else if ($acao == 'buscar') {
        if (isset($_POST['consultaAluno'])) {
            $valor_input = $_POST['consultaAluno'];
            $aluno = new Aluno();
            $conexao = new Conexao('db_library');
            $alunoService = new Livro_Service($conexao, $aluno);
    
            $resultados = $alunoService->buscar_alunos('tb_aluno', ['nome', 'cpf', 'telefone','id', 'curso'], [':consultaAluno' => '%' . $valor_input . '%']);
    
            if (!empty($resultados)) {
                $alunosEncontrados = []; // Inicialize um array para armazenar os resultados
    
                foreach ($resultados as $aluno) {
                    echo "Nome: " . $aluno->nome;
                    echo " CPF: " . $aluno->cpf;
    
                    // Adicione cada aluno ao array
                    $alunosEncontrados[] = $aluno;
                }
    
                session_start();
                $_SESSION['resultados_pesquisa_aluno'] = $alunosEncontrados; // Atribua o array à sessão
                $_SESSION['variavel'] = 1;
    
                header('Location: index.php');
                //header('Location: index.php?variavel=1');
            } else {
                echo "Nenhum resultado encontrado.";
                header('Location: index.php');
            }
        }
    }
?>
