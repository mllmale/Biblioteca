<?php
    $acao = 'recuperar';
    require 'aluno_controller.php';

    session_start();
    if (isset($_SESSION['variavel'])) {
        $variavel = $_SESSION['variavel'];
    }
        
    if (isset($_SESSION['resultados_pesquisa_aluno'])) {
        $resultados = $_SESSION['resultados_pesquisa_aluno'];
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sistema de Biblioteca - Aluno</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css\index.css">
    <script>
        function excluir(id){
            location.href = 'index.php?acao=remover&id='+id
        }
        function teste(){
            alert(<?= $acao?>)
        }

    </script>
</head>
<body>
    <div class="cabeca ">
        <header>
            <h1>Sistema de Biblioteca - Aluno</h1>
        </header>
        <nav>
            <a class="m-5 p-2" href="index.php">Aluno</a>
            <a class="m-5 p-2" href="biblioteca.php">Biblioteca</a>
            <a class="m-5 p-2" href="emprestimo.php">Empréstimo</a>
        </nav>
    </div>
    <div class="container">
        <h2>Cadastro de Aluno</h2>
        <form method="post" action="aluno_controller.php?acao=inserir">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome">
            </div>
            <div class="form-group">
                <label for="nascimento">Data de Nascimento:</label>
                <input type="date" class="form-control" id="dataNascimento">
            </div>
            <div class="form-group">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" id="cpf" name="cpf">
            </div>
            <div class="form-group">
                <label for="telefone">Telefone:</label>
                <input type="text" class="form-control" id="telefone" name="telefone">
            </div>
            <div class="form-group">
                <label for="curso">Curso:</label>
                <input type="text" class="form-control" id="curso" name="curso">
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
        <h2>Lista de Alunos</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th>Curso</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <?php 
            
            foreach($alunos as $indice => $aluno) { 
                ?>
                <tbody>
                    <tr>
                        <td id="nome_<?=$aluno->id?>"><?= $aluno->nome?></td>
                        <td id="cpf_<?=$aluno->id?>"><?= $aluno->cpf?></td>
                        <td id="telefone_<?=$aluno->id?>"><?= $aluno->telefone?></td>
                        <td id="curso_<?=$aluno->id?>"><?= $aluno->curso?></td>
                        <td class="d-flex justify-content-center align-items-center" style="display: flex; justify-content: center; align-items: center;">
                            <button class="btn btn-danger delete-button mr-2" onclick="excluir(<?= $aluno->id?>)">Excluir</button>
                        </td>

                    </tr>    
                </tbody>
            <?php   
                    } ?>
        </table>
    </div>
    <div class="container">
        <h2>Consulta de Alunos</h2>
        <form action="aluno_controller.php?acao=buscar" method="post">
            <div class="form-group">
                <label for="consultaAluno">Consultar por Nome ou CPF:</label>
                <input type="text" class="form-control" id="consultaAluno" name="consultaAluno">
            </div>
            <button type="submit" class="btn btn-primary" onclick="teste()">Consultar</button>
        </form>
        <h2>Resultado da Pesquisa</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>Telefone</th>
                    <th>Curso</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!empty($resultados)) {

                    foreach ($resultados as $aluno) {

                        //echo $aluno->id;
                ?>
                            <td id="nome_<?=$aluno->id?>"><?php echo $aluno->nome; ?></td>
                            <td id="cpf_<?=$aluno->id?>"><?php echo $aluno->cpf; ?></td>
                            <td id="telefone_<?=$aluno->id?>"><?php echo $aluno->telefone; ?></td>
                            <td id="curso_<?=$aluno->id?>"><?php echo $aluno->curso; ?></td>
                            <td class="d-flex justify-content-center align-items-center" style="display: flex; justify-content: center; align-items: center;">
                            <button class="btn btn-danger delete-button mr-2" onclick="excluir(<?php echo $aluno->id?>)">Excluir</button>
                            </td>
                        </tr> 
                       
                <?php
                    }
                } else {
                    // Exibir mensagem se não houver resultados
                    echo '<tr><td colspan="5">Nenhum resultado encontrado.</td></tr>';
                }
                ?>
            </tbody>

        </table>
    </div>
            
</body>
</html>
