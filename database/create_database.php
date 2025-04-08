<?php
$host = 'localhost'; // substitua pelo nome correto do host, aqui foi usado o nome do container docker
$dbname = 'PIntegral'; // substitua pelo nome correto do banco
$user = 'root';                // ajuste conforme seu ambiente
$pass = 'V3t3ran0*';                    // ajuste conforme seu ambiente

// Função para criar conexão PDO
function conectarPDO($host, $user, $pass, $dbname = null) {
    $dsn = is_null($dbname) 
        ? "mysql:host=$host;charset=utf8mb4" 
        : "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

// Criar banco de dados se não existir
try {
    $pdo = conectarPDO($host, $user, $pass);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` 
                CHARACTER SET utf8mb4 
                COLLATE utf8mb4_unicode_ci;");
    echo "✅ Banco de dados '$dbname' criado ou já existente.<br>";
} catch (PDOException $e) {
    die("❌ Erro ao criar o banco: " . $e->getMessage());
}

// Conectar ao banco criado
try {
    $pdo = conectarPDO($host, $user, $pass, $dbname);
} catch (PDOException $e) {
    die("❌ Erro ao conectar ao banco '$dbname': " . $e->getMessage());
}

// Lista de tabelas a criar
$tabelas = [
    'consulta' => "
        CREATE TABLE IF NOT EXISTS consulta (
            id INT AUTO_INCREMENT PRIMARY KEY,
            especialidade VARCHAR(100)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;",
    
    'agendamento' => "
        CREATE TABLE IF NOT EXISTS agendamento (
            id INT AUTO_INCREMENT PRIMARY KEY,
            consulta VARCHAR(255) NOT NULL,
            dataConsulta DATE NOT NULL,
            hora TIME NOT NULL,
            medico VARCHAR(255) NOT NULL,
            paciente VARCHAR(255),
            sexo ENUM('F','M') NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
    'medico' => "
        CREATE TABLE IF NOT EXISTS medico (
            id INT AUTO_INCREMENT PRIMARY KEY,
            medico VARCHAR(100) NOT NULL,
            crm int NOT NULL UNIQUE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
    'paciente' => "
        CREATE TABLE IF NOT EXISTS paciente (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            cpf VARCHAR(11) NOT NULL UNIQUE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
];

// Criar tabelas
foreach ($tabelas as $paciente => $sql) {
    try {
        $pdo->exec($sql);
        echo "✅ Tabela '$paciente' verificada ou criada com sucesso.<br>";
    } catch (PDOException $e) {
        echo "❌ Erro ao criar tabela '$paciente': " . $e->getMessage() . "<br>";
    }
}
?>