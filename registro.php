<?php
$host = "b5zxorozufkvpc4ggjo0-mysql.services.clever-cloud.com";
$port = "3306";
$dbname = "b5zxorozufkvpc4ggjo0";
$user = "uroaaosn6n5hrxrb";
$password = "SD9M32zTGdm5VDgG3zRZ";

try {
    $conexion = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    $msg = "Error: " . $e->getMessage() . " en la línea " . $e->getLine();
    header("Location: error.php?msg=" . urlencode($msg));
    exit;
}

$archivo = fopen("usuarios.txt", "r");
if (!$archivo) {
    die("❌ No se pudo abrir el archivo.");
}

$insertados = 0;
while (($linea = fgets($archivo)) !== false) {
    $linea = trim($linea);
    if (empty($linea) || strpos($linea, ",") === false) continue;

    list($email, $pass) = explode(",", $linea, 2);
    $email = trim($email);
    $pass = trim($pass);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) continue;

    try {
        $stmt = $conexion->prepare("INSERT INTO usuarios (usuario, contrasena) VALUES (:email, :pass)");
        $stmt->execute([
            ':email' => $email,
            ':pass' => $pass
        ]);
        $insertados++;
    } catch (PDOException $e) {
        // Puedes loguear errores específicos si lo deseas
        continue;
    }
}

fclose($archivo);
echo "✅ Se insertaron $insertados usuarios desde el archivo TXT.";
?>

