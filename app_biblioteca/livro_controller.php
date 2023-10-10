<?php 
    require 'livro.php';
    require 'teste.service.php';
    require 'conexao.php';

    $acao = isset($_GET['acao']) ? $_GET['acao'] : $acao;
    $variavel = isset($_GET['variavel']) ? $_GET['variavel'] : $acao;
    if(isset($_GET['acao']) && $_GET['acao'] =='inserir'){
        
        $livro = new Livro();
        $livro->__set('titulo', $_POST['titulo']);
        $livro->__set('autor', $_POST['autor']);
        $livro->__set('edicao', $_POST['edicao']);
    
        $conexao = new Conexao('db_library');
        
        $livroService = new Livro_service($conexao, $livro);
        $livroService->inserir('insert into tb_livro
        (titulo, autor,edicao, id)values
        (:titulo, :autor, :edicao, :id)','titulo', 'autor', 'edicao','id');
        header('Location: biblioteca.php?inclusao=1');
    } else if($acao == 'recuperar'){
        $livro = new Livro();
        $conexao = new conexao('db_library');
        $livroService = new Livro_service($conexao, $livro);

        // Defina os campos que deseja recuperar
        $campos = array('titulo', 'autor', 'id', 'edicao');

        // Chame a função recuperar com o contexto 'tb_livro' e os campos desejados
        $livros = $livroService->recuperar('tb_livro', $campos);
    } else if($acao == 'remover'){
        echo 'foi';
        $livro = new Livro();
        $livro->setId($_GET['id']); 
        $conexao = new conexao('db_library');
        $livroService = new Livro_service($conexao, $livro);
        $livroService->remover('tb_livro',$livro);
        header('Location: biblioteca.php');
        
    } else if($acao == 'buscar'){
        if (isset($_POST['consultaTitulo'])) {
            $valor_input = $_POST['consultaTitulo'];
            $livro = new Livro();
            $conexao = new Conexao('db_library');
            $livroService = new Livro_Service($conexao, $livro);
        
            $resultados = $livroService->recuperar_livro('tb_livro', [' * '], [':consultaTitulo' => '%' . $valor_input . '%']);
        
            if (!empty($resultados)) {
                foreach ($resultados as $livro) {
                    echo "Título: " . $livro->titulo;
                    echo " Autor: " . $livro->autor;
                    session_start();

                    $_SESSION['resultados_pesquisa'] = $resultados;

                    $_SESSION['variavel'] = 1;

                    header('Location: biblioteca.php');
                    //header('Location: biblioteca.php?variavel=1');
                }
            } else{
                echo "Elemento não encontrado no banco de dados";
                header('Location: biblioteca.php?variavel=0');
            }
            if(!$resultados){
                echo "Elemento não encontrado no banco de dados";
            }
        }
    }
    /*
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['consultaTitulo'])) {
        // Processar o formulário de consulta
        $consultaTitulo = '%' . $_POST['consultaTitulo'] . '%';
    
        $livro = new Livro();
        $conexao = new Conexao('db_library');
        $livroService = new Livro_service($conexao, $livro);
        
        // Defina os campos que deseja recuperar
        $campos = array('titulo', 'autor', 'id', 'edicao');
        
        $query = 'SELECT titulo, autor, id, edicao FROM tb_livro WHERE titulo LIKE :consultaTitulo';
        $parametros = array(':consultaTitulo' => $consultaTitulo);
        $livroPesquisado = $livroService->recuperar('tb_livro', $campos, $parametros);
        //var_dump($livroPesquisado);
        header('Location: biblioteca.php');
        exit;
    }
    */
    ?>
