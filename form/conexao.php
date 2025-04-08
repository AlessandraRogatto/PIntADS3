<?php
$servername = 'localhost';
$username = 'root';
$password = 'V3t3ran0*'; // Lembrar de colocar a senha antes de rodar
$dbname = 'PIntegral';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}
?>