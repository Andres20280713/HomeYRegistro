<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Contraseña</title>
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
            <h2 class="text-center">Actualizar Contraseña</h2>
            <form id="actualizarForm" action="procesar_actualizacion.php" method="post">
                <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
                <input type="hidden" name="usuario" value="<?php echo $_GET['usuario']; ?>">
                <div class="form-group">
                    <label for="new_password">Nueva Contraseña:</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="confirm_password">Confirmar Contraseña:</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Actualizar Contraseña</button>
            </form>
            <div id="mensaje" class="mt-3"></div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#actualizarForm').on('submit', function(event) {
                event.preventDefault();
                var newPassword = $('#new_password').val().trim();
                var confirmPassword = $('#confirm_password').val().trim();

                if (newPassword === "" || confirmPassword === "") {
                    $('#mensaje').html("<div class='alert alert-danger'>Todos los campos son obligatorios.</div>");
                    return false;
                }

                if (newPassword !== confirmPassword) {
                    $('#mensaje').html("<div class='alert alert-danger'>Las contraseñas no coinciden.</div>");
                    return false;
                }

                $.ajax({
                    url: 'procesar_actualizacion.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#mensaje').html(response);
                    }
                });
            });

            $('#toggleNewPassword').click(function() {
                var passwordField = $('#new_password');
                var passwordFieldType = passwordField.attr('type');
                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).html('<i class="fas fa-eye-slash"></i>');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).html('<i class="fas fa-eye"></i>');
                }
            });

            $('#toggleConfirmPassword').click(function() {
                var passwordField = $('#confirm_password');
                var passwordFieldType = passwordField.attr('type');
                if (passwordFieldType === 'password') {
                    passwordField.attr('type', 'text');
                    $(this).html('<i class="fas fa-eye-slash"></i>');
                } else {
                    passwordField.attr('type', 'password');
                    $(this).html('<i class="fas fa-eye"></i>');
                }
            });
        });
    </script>
</body>
</html>
