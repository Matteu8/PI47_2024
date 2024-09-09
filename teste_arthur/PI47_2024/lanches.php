<?php 
    require "conexao.php";



        $funcionou = "SELECT * FROM lanches ";
    
        $sql_exec = $mysqli->query($funcionou) or die ($mysqli->error);
        //$usuario = $sql_exec->fetch_assoc();
    
           
                    
   

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lanches do Senac</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="gabriel.css">
</head>

<body>
    <!-- ####################################################################################### -->
    <div class="row visible-md visible-lg" style="background-color:#3a6da1;">
        <div class="col-md-5" style="background-color:#3a6da1; margin-right:0px; margin-left:0px">
            <a href="/principal/"><img src="img/topo_site_bl1_2018.png" class="img img-responsive"></a>
        </div>
    </div>

    </head>

    <body>
        <header>
            <h1>Menu de lanches</h1>
        </header>

        <div class="container">
            <div class="product-list">

            
            <?php while ($lanche = $sql_exec->fetch_assoc()) { ?>
            
                <div class="product">
                    <img src="<?php echo $lanche['foto']  ?>"   >
                    <h2><?php echo $lanche['nome']?></h2>
                    <p><?php echo $lanche['ingredientes']?></p> 
                    <div class="price"><?php echo $lanche['preco']?></div>
                </div>
            <?php } ?>
        
               
            </div>
        </div>
        <br>
        <br>
        <br>

        <footer>
            <p>© Direitos reservados - Turma de programação web t202400047 Senac PR 2024</p>
        </footer>
    </body>

</html>