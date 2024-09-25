<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
        /* Define a altura do navbar para corresponder à altura da imagem */
        .navbar {
            padding: 0;
            margin: 0;
            height: 118px; /* Ajusta a altura para igualar à da imagem */
            position: relative; /* Permite posicionamento absoluto do botão "hamburger" */
        }

        /* Garante que a imagem ocupe todo o espaço horizontal */
        .navbar-brand img {
            margin: 0;
            padding: 0;
            height: 100%; /* A imagem ocupará toda a altura do navbar */
            width: 100%; /* A imagem ocupará todo o espaço horizontal */
            object-fit: cover; /* Garante que a imagem se ajuste ao container sem distorção */
        }

        /* Ajusta o botão "hamburger" no lado direito e centraliza verticalmente */
        .navbar-toggler {
            position: absolute;
            right: 15px; /* Posição no lado direito */
            top: 50%;
            transform: translateY(-50%); /* Centraliza verticalmente */
            z-index: 10; /* Garante que o botão fique sobre a imagem */
        }

        /* Remove padding extra do container fluid */
        .container-fluid {
            padding: 0;
        }

        @media (max-width: 992px) {
    .navbar-collapse {
        background-color: #3a6da1; /* Mesmo fundo azul da barra de navegação */
    }
}


    </style>
</head>
<body>
    <?php include("menu.php");?>
</body>
</html>
