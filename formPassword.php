<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>LOGIN</h1>
    <form method="POST">
        <label for="userName">Nombre de Usuario:</label>
        <input type="text" name="userName" placeholder="Usuario" required>
        <br>

        <label for="pwd">Contraseña:</label>
        <input type="password" name="pwd" placeholder="Contraseña" required>
        <br>

        <button type="submit">Enviar</button>
    </form>
    <br>
    <a href="crearRegistro.php">Crear Registro</a>

    <?php
    if (isset($_POST['userName']) && isset($_POST['pwd'])) {
        try {
            $userName = $_POST['userName'];
            $pwd = $_POST['pwd'];

            $dsn = "mysql:host=localhost;dbname=mylogin";
            $pdo = new PDO($dsn, 'tianleyin', 'Sinlove2004_');

            $query = $pdo->prepare("SELECT nom FROM users WHERE contrasenya = SHA2(:pwd, 512) AND nom = :userName");
            $query->bindParam(':userName', $userName, PDO::PARAM_STR);
            $query->bindParam(':pwd', $pwd, PDO::PARAM_STR);
            
            $query->execute();
            
            $row = $query->fetch();
            
            if ($row) {
                session_start();
                $_SESSION['usuario'] = $row['nom'];
                header("Location: DashBoard.php");
                exit();
            } else {
                echo "<h1>Login incorrecto</h1>";
            }

        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    ?>
</body>
</html>
