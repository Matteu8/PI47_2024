<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Area do Funcionarios</title>
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
            <h1>Area de Funcionarios</h1>
        </header>

        <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .menu {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }
        .menu h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .menu a {
            display: block;
            margin: 10px 0;
            padding: 10px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #007bff;
            border-radius: 4px;
            text-align: center;
        }
        .menu a:hover {
            background-color: #007bff;
            color: #fff;
        }
        .logout {
            text-align: center;
            margin-top: 20px;
        }
        .logout a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #dc3545;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        .logout a:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>
    <div class="menu">
        <h1>Bem-vindo, <?php  ?></h1> <!-- colocar_os_links_certos -->
        <a href="pedidos_do_dia.php">Pedidos Do Dia</a>
        <a href="cancelar_pedidos.php">candelar Pedidos</a>
        <a href="cadastrar_funcionario.php">Cadastrar Funcionario</a>
        <a href="adicionar_produtos.php">Adicionar Produtos</a>
        <a href="area_funcionario.php">Em Breve</a>
        <a href="area_funcionario.php">Em Breve</a>
        <div class="logout">
            <a href="logout.php">Sair</a>
        </div>

    </div>
        
</body>
</html>
