<?php 
    $acao = 'recuperar';
    require 'emprestimo_controller.php'; 
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sistema de Biblioteca - Empréstimo</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css\emprestimo.css">
    <script>
        function excluir(id){
                location.href = 'emprestimo.php?acao=remover&id='+id
            }
    </script>
</head>
<body>
    <header>
        <h1>Sistema de Biblioteca - Empréstimo</h1>
    </header>
    <nav>
        <a class="m-5 p-2" href="index.php">Aluno</a>
        <a class="m-5 p-2" href="biblioteca.php">Biblioteca</a>
        <a class="m-5 p-2" href="emprestimo.php">Empréstimo</a>
    </nav>
    <div class="container">
        <h2>Novo Empréstimo</h2>
        <form id="novoEmprestimoForm" method="post" action="emprestimo_controller.php?acao=inserir">
            <div class="form-group">
                <label for="emprestimoAluno">Nome do Aluno:</label>
                <input type="text" class="form-control" id="emprestimoAluno" name="nome">
            </div>
            <div class="form-group">
                <label for="emprestimoAluno">CPF do Aluno:</label>
                <input type="text" class="form-control" id="emprestimoAluno" name="cpf">
            </div>
            <div class="form-group">
                <label for="emprestimoLivro">Título do Livro:</label>
                <input type="text" class="form-control" id="emprestimoLivro" name="titulo">
            </div>
            <div class="form-group">
                <label for="dataEmprestimo">Data do Empréstimo:</label>
                <input type="date" class="form-control" id="dataEmprestimo" name="data">
            </div>
            <!-- Adicione mais campos conforme necessário para multa, data de devolução, etc. -->
            <button type="submit" class="btn btn-primary">Registrar Empréstimo</button>
        </form>
        <h2>Empréstimos Realizados</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nome do Aluno</th>
                    <th>Título do Livro</th>
                    <th>Data de Emprestimo</th>
                    <th>Multa (R$)</th>
                    <th>Ações</th>
                </tr>
            </thead>
            
            <?php 
            if (!empty($emprestimos)) {
            foreach ($emprestimos as $emprestimo) { 
                
        
        $emprestimoData = $emprestimo->data; // Substitua isso pela sua data real

        // Primeiro, você precisa converter a data para o formato "aaaa-mm-dd"
        $dataFormatada = DateTime::createFromFormat('d/m/Y', $emprestimoData);
        
        if ($dataFormatada) {
            $dataEmprestimo = $dataFormatada;
            $dataAtual = new DateTime();
        
            // Calcula a diferença em dias
            $interval = $dataAtual->diff($dataEmprestimo);
            $diferenca = $interval->days;
        
            $valorMultaPorDia = 2;
        
            if ($diferenca >= 7) {
                $multa = 'R$ '.($diferenca-8) + $valorMultaPorDia. ',00 ';
            } else {
                $multa = 'R$ 0,00';
            }
        }
        //echo $emprestimo->id;
            ?>
    <tr>
        <td><?= $emprestimo->nome ?></td>
        <td><?= $emprestimo->titulo ?></td>
        <td><?= $emprestimo->data ?></td>
        <td><?= $multa ?></td>
        <td class="d-flex justify-content-center align-items-center" style="display: flex; justify-content: center; align-items: center;" >
            <button class="btn btn-danger delete-button mr-2" onclick="excluir(<?=$emprestimo->id?>)">Excluir</button>
        </td>
    </tr>
    <?php }
        } else {
            // Exibir mensagem se não houver resultados
            echo '<tr><td colspan="5">Nenhum resultado encontrado.</td></tr>';
        }
    ?>
        </table>
    </div>
</body>
</html>
