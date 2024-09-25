<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página - Inicial</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        header {
            background-color: orange;
            color: white;
            padding: 20px;
            text-align: center;
        }

        main {
            padding: 20px;
        }

        h2 {
            color: #343a40;
        }

        .card {
            background-color: white;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin: 15px 0;
            text-align: center;
        }

        .card img {
            max-width: 20%;
            /* Ajusta a largura das imagens dos cards */
            height: auto;
            /* Mantém a proporção da imagem */
            border-radius: 5px;
            display: block;
            /* Torna a imagem um bloco */
            margin: 0 auto;
            /* Centraliza a imagem */
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #004a8d;
            color: white;
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>

<body>
    
    <main>
        <section id="lanches">
            <h2>Lanches</h2>
            <div class="card">
                <img src="img/lanche.jfif" alt="Lanche 1">
                <h3>Hambúrguer Clássico</h3>
                <p>Delicioso hambúrguer com queijo, alface e tomate.</p>
                <span>R$ 15,00</span>
            </div>
            <div class="card">
                <img src="img/lanche.jfif" alt="Lanche 2">
                <h3>Sanduíche Natural</h3>
                <p>Sanduíche saudável com peito de frango e verduras.</p>
                <span>R$ 12,00</span>
            </div>
        </section>

        <section id="bebidas">
            <h2>Bebidas</h2>
            <div class="card">
                <img src="img/bebida.jfif" alt="Bebida 1">
                <h3>Suco Natural</h3>
                <p>Suco fresco de laranja, sem conservantes.</p>
                <span>R$ 5,00</span>
            </div>
            <div class="card">
                <img src="img/bebida.jfif" alt="Bebida 2">
                <h3>Refrigerante</h3>
                <p>Refrigerante gelado, perfeito para acompanhar.</p>
                <span>R$ 4,00</span>
            </div>
        </section>

        <section id="sobremesas">
            <h2>Sobremesas</h2>
            <div class="card">
                <img src="img/sobremesa.jfif" alt="Sobremesa 1">
                <h3>Brownie de Chocolate</h3>
                <p>Brownie cremoso com pedaços de chocolate.</p>
                <span>R$ 8,00</span>
            </div>
            <div class="card">
                <img src="img/sobremesa.jfif" alt="Sobremesa 2">
                <h3>Pavê de Morango</h3>
                <p>Delicioso pavê de morango com creme.</p>
                <span>R$ 7,00</span>
            </div>
        </section>
    </main>

    <footer class="text-center mt-4">
        <div class="footer-links">
            <a href="#sobre">Sobre Nós</a>
        </div>
        <p>&copy; 2024 Senac-PR. Todos os direitos reservados.</p>
    </footer>
</body>

</html>