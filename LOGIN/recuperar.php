<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .input-group {
            max-width: 400px;
            margin: 10px auto;
        }
        .form-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center">Recuperar Contraseña</h2>
            <form id="recuperarForm" action="procesar_recuperacion.php" method="post">
                <div class="form-group">
                    <label for="email">Correo Electrónico:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="usuario">Nombre de Usuario:</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Recuperar Contraseña</button>
            </form>
            <div id="mensaje" class="mt-3"></div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#recuperarForm').on('submit', function(event) {
                event.preventDefault();
                var email = $('#email').val().trim();
                var usuario = $('#usuario').val().trim();

                if (email === "" || usuario === "") {
                    $('#mensaje').html("<div class='alert alert-danger'>Todos los campos son obligatorios.</div>");
                    return false;
                }

                $.ajax({
                    url: 'procesar_recuperacion.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#mensaje').html(response);
                    }
                });
            });
        });
    </script>
</body>
</html>
