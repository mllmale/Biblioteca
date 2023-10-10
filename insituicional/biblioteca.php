<?php
    $acao = 'recuperar';
    require 'livro_controller.php';
    
    session_start();
    if (isset($_SESSION['variavel'])) {
        $variavel = $_SESSION['variavel'];
    }
    

    
    if (isset($_SESSION['resultados_pesquisa'])) {
        $resultados = $_SESSION['resultados_pesquisa'];
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sistema de Biblioteca - Biblioteca</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="css\biblioteca.css">
    <script>
        function excluir(id){
            location.href = 'biblioteca.php?acao=remover&id='+id
        }
    </script>
</head>
<body>
    <header>
        <h1>Sistema de Biblioteca - Biblioteca</h1>
    </header>
    <nav>
        <a class="m-5 p-2" href="index.php">Aluno</a>
        <a class="m-5 p-2" href="biblioteca.php">Biblioteca</a>
        <a class="m-5 p-2" href="emprestimo.php">Empréstimo</a>
    </nav>
    <div class="container">
        <h2>Cadastro de Livro</h2>
        <form method="post" action="livro_controller.php?acao=inserir">
            <div class="form-group">
                <label for="titulo">Título:</label>
                <input type="text" class="form-control" id="titulo" name="titulo">
            </div>
            <div class="form-group">
                <label for="autor">Autor:</label>
                <input type="text" class="form-control" id="autor" name="autor">
            </div>
            <div class="form-group">
                <label for="edicao">Edição:</label>
                <input type="text" class="form-control" id="edicao" name="edicao">
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>
        <h2>Lista de Livros</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Edição</th>
            <th>Ações</th>
        </tr>
    </thead>
    <?php foreach($livros as $indice => $livro) { ?>
        <tbody>
            <tr>
                <td id="titulo_<?= $livro->id ?>"><?= $livro->titulo?></td>
                <td id="autor_<?= $livro->id ?>"><?= $livro->autor?></td>
                <td id="edicao_<?= $livro->id ?>"><?= $livro->edicao?></td>
                <td class="d-flex justify-content-center align-items-center" style="display: flex; justify-content: center; align-items: center;" >
                <button class="btn btn-danger delete-button mr-2" onclick="excluir(<?=$livro->id?>)">Excluir</button>
                </td>
            </tr>
        </tbody>
    <?php } ?>
</table>
    <h2>Consulta de Livros</h2>
    <form action="livro_controller.php?acao=buscar" method="post">
        <div class="form-group">
            <label for="consultaTitulo">Consultar por Título:</label>
            <input type="text" class="form-control" id="consultaTitulo" name="consultaTitulo">
        </div>
        <button type="submit" class="btn btn-primary">Consultar</button>
    </form>
    <h2>Lista de Livros</h2>
    <table class="table table-bordered">
    <thead>
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Edição</th>
            <th>Ações</th>
            
        </tr>
    </thead>
    <?php
    //var_dump($resultados);
    if (!empty($resultados)) {
        //var_dump($resultados);
        foreach($resultados as $livro) { ?>
            <tbody>
                <tr>
                    <td id="titulo_<?= $livro->id ?>"><?php echo $livro->titulo?></td>
                    <td id="autor_<?= $livro->id ?>"><?php echo $livro->autor?></td>
                    <td id="edicao_<?= $livro->id ?>"><?php echo $livro->edicao?></td>
                    <td class="d-flex justify-content-center align-items-center" style="display: flex; justify-content: center; align-items: center;" >
                        <button class="btn btn-danger delete-button mr-2" onclick="excluir(<?=$livro->id?>)">Excluir</button>
                    </td>
                </tr>
            </tbody>
        <?php } ?>
    <?php } ?>
</table>
    </div>
</html>
