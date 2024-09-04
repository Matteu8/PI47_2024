
<?php 

    

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lanches do Senac</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="Gabriel.css">
</head>
<body>
   <!-- ####################################################################################### -->
   <div class="row visible-md visible-lg" style="background-color:#3a6da1;" >     
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
        <div class="product">
            <img src="img/arepascolombianas.jpg" alt="">
            <h2>Arepas Colombianas</h2>
            <p></p>
            <div class="price">R$ 10,00</div>
            
        </div>
        <div class="product">
            <img src="img/esfihadebacon.jpg.jpg" alt="">
           
            <h2>Esfiha de bacon</h2>
            <p></p>
            <div class="price">R$ 15,00</div>
        </div>
        <div class="product">
            <img src="img/pizzadesushi.jpg" alt="">
            <h2>Pizza de sushi</h2>
            <p></p>
            <div class="price">R$ 15,00</div>
        </div>
        <div class="product">
            <img src="img/sopademandioca.jpg" alt="">
            <h2>Sopa de mandioca</h2>
            <p></p>
            <div class="price">R$ 20,00</div>
        </div>
        <div class="product">
            <img src="img/tacaca.jpg" alt="">
            <h2>Tacaca</h2>
            <p></p>
            <div class="price">R$ 30,00</div>
        </div>
        <div class="product">
            <img src="img/bolinhadequeijo.jpg" alt="">
            <h2>Bolinha de queijo</h2>
            <p></p>
            <div class="price">R$ 5,00</div>
        </div>
        <div class="product">
            <img src="img/bolinhodemandioca.jpg" alt="">
            <h2>Bolinha de queijo</h2>
            <p></p>
            <div class="price">R$ 10,00</div>
        </div>
        <div class="product">
            <img src="img/almondegas.jpg" alt="">
            <h2>Almondegas </h2>
            <p></p>
            <div class="price">R$ 15,00</div>
        </div>
        <div class="product">
            <img src="img/frangoxadrez.jpg" alt="">
            <h2>Frango Xadrez</h2>
            <p></p>
            <div class="price">R$ 25,00</div>
        </div>
        <div class="product">
            <img src="img/esfihadequeijo.jpg" alt="">
            <h2>esfiha de queijo</h2>
            <p></p>
            <div class="price">R$ 15,00</div>
        </div>
        <div class="product">
            <img src="img/hotroll.jpg" alt="">
            <h2>Hot Roll</h2>
            <p></p>
            <div class="price">R$ 25,00</div>
        </div>
        <div class="product">
            <img src="img/frangoempanado.jpg" alt="">
            <h2>Frango empanado</h2>
            <p></p>
            <div class="price">R$ 30,00</div>
        </div>

        <?php 
            if(isset($caminhoFinal)){
                $funcionou = $consulta = "SELECT * FROM lanches WHERE id_lanches";
                $div = ""
            }

            if(isset($funcionou)){
                echo = "$div";
            }

        ?>
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