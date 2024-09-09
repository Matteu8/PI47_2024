
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <div><h1>Área de pedidos</h1>
    
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0; 
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .button-container {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
        }
        .bottom-button {
            margin-top: 10px; 
            
        }
    </style>
</head>
<body>

    <form method="post">
        <div class="container">
            <div class="button-container">
                <button type="submit" name="button1">faça o seu pedido</button>
                <button type="submit" name="button2">Consultar seus pedidos</button>
                <button type="submit" name="button3">cancelar pedidos</button>
            </div>
            <button type="submit" name="button4" class="bottom-button">sair da conta</button>
        </div>
    </form>
</body>
</html>

