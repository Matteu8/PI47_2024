<?php 
    require("conexao.php");

    if(isset($_POST["bt_nome"])){
        $nome = $_POST["bt_nome"];
        $ingredientes = $_POST["bt_ingredientes"];
        $quantidade = $_POST["bt_quantidade"];
        $preco = $_POST["bt_preco"];

        $mysqli->query("INSERT INTO lanches (nome, ingredientes, preco, quantidade) values('$nome', '$ingredientes', '$preco', '$quantidade')") or
                    die($mysqlierrno);

        
    }

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cadastro de Lanches</title>
</head>
<body>
    <!-- ####################################################################################### -->
    <div class="row visible-md visible-lg" style="background-color:#3a6da1;" >     
        <div class="col-md-5" style="background-color:#3a6da1; margin-right:0px; margin-left:0px">
            <a href="/principal/"><img src="img/topo_site_bl1_2018.png" class="img img-responsive"></a>
        </div>
    </div>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        header {
            background-color: #f7941d;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }
        h1 {
            margin: 0;
        }
        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .product {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 15px;
            flex: 1 1 calc(33.333% - 20px);
            box-sizing: border-box;
            text-align: center;
        }
        .product img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }
        .product h2 {
            margin: 10px 0;
            font-size: 1.5em;
        }
        .product p {
            font-size: 1em;
            color: #666;
        }
        .product .price {
            font-size: 1.2em;
            color: #333;
            margin-top: 10px;
        }
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Cadastro de Lanches</h1>
    </header>
    
    <div class="container">
        <form action="" method="post">

            <label for="">Nome Do Lanche</label>
            <input class="form-control"  type="text" name="bt_nome">
            
            <label for="">Ingredientes</label>
            <input class="form-control" type="text" name="bt_ingredientes">

            <label for="">Preço</label>
            <input class="form-control" type="text" name="bt_preco" >

            <label for="">Quantidade</label>
            <input class="form-control" type="text" name="bt_quantidade" >

            <input class="btn btn-success "  type="submit" value="Cadastrar">
            <input class="btn btn-danger " type="reset" value="Voltar">

        </form>
</body>
</html>


