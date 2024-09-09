<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
</head>
<body>
    <!-- ####################################################################################### -->
        <div class="row visible-md visible-lg" style="background-color:#3a6da1;" >     
            <div class="col-md-5" style="background-color:#3a6da1; margin-right:0px; margin-left:0px">
                <a href="/principal/"><img src="img/topo_site_bl1_2018.png" class="img img-responsive"></a>
            </div>
        </div>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Feedback</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group textarea {
            resize: vertical;
            height: 150px;
        }
        .form-group button {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            background-color: #5cb85c;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        .form-group button:hover {
            background-color: #4cae4c;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Formulario de Feedback</h1>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $feedback = htmlspecialchars($_POST['feedback']);
        
        $to = "tu-email@example.com"; // Cambia esto a tu dirección de correo electrónico
        $subject = "Nuevo Feedback de $name";
        $message = "Nombre: $name\nCorreo: $email\n\nComentarios:\n$feedback";
        $headers = "From: $email\r\n";
        
        if (mail($to, $subject, $message, $headers)) {
            echo '<div class="message success">Gracias por tu feedback. ¡Lo hemos recibido con éxito!</div>';
        } else {
            echo '<div class="message error">Hubo un problema al enviar tu feedback. Por favor, intenta nuevamente más tarde.</div>';
        }
    }
    ?>
    <form action="feedback.php" method="post">
        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" id="name" name="name">
        </div>
        <div class="form-group">
            <label for="email">email:</label>
            <input type="email" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="feedback">Comentarios:</label>
            <textarea id="feedback" name="feedback" required></textarea>
        </div>
        <div class="form-group">
            <button type="submit">Enviar Feedback</button>
        </div>
    </form>
</div>

</body>
</html>