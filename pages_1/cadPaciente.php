<?php require_once '../form/conexao.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Projeto Integrador ADS</title>
</head>

<body>
    <?php
        $cpf = $_POST['cpf'] ?? '';
        $nome = $_POST['nome'] ?? '';
    ?>
    <header class="headerConsulta">
        <button class="botaoVoltar" onclick="window.location.href='../index.php';">🏠 Início</button>
        <h1 class="h1Consulta">Cadastramento de Pacientes</h1>
    </header>

    <section class="form-section-medico">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" id="formInsert">
            <ul class="menu_section">
                <li>
                    <label class="labelcad" for="cpf">CPF</label><br>
                    <input class="inputPesquisa" type="text" name="cpf" id="cpf" value="<?=$cpf?>">
                </li>
                <li>
                    <label class="labelcad" for="nome">Nome do Paciente</label><br>
                    <input class="inputMedico" type="text" name="nome" id="nome" value="<?=$nome?>">
                </li>
                <li>
                    <button class="menuBuscar" type="submit">Salvar</button>
                </li>
            </ul>
        </form>
    </section>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cpf = trim($_POST['cpf'] ?? '');
        $nome = trim($_POST['nome'] ?? '');

        if (empty($cpf) || empty($nome)) {
            echo "<div class='respauto'>⚠️ Por favor, preencha todos os campos.</div>";
        } else {
            try {
                // Verifica se já existe
                $sql_verifica = "SELECT id FROM paciente WHERE cpf = ?";
                $stmt = $conn->prepare($sql_verifica);
                $stmt->bindValue(1, $cpf, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    echo "<div class='respauto'>❌ Esse CPF já está cadastrado!</div>";
                } else {
                    // Insere novo médico
                    $sql_inserir = "INSERT INTO paciente (cpf, nome) VALUES (?, ?)";
                    $stmt_inserir = $conn->prepare($sql_inserir);
                    $stmt_inserir->bindValue(1, $cpf, PDO::PARAM_STR);
                    $stmt_inserir->bindValue(2, $nome, PDO::PARAM_STR);
                    $stmt_inserir->execute();

                    echo "<div class='respauto'>✅ Paciente cadastrado com sucesso!</div>";
                }
            } catch (PDOException $e) {
                echo "<div class='respauto'>❌ Erro ao cadastrar: " . $e->getMessage() . "</div>";
            }
        }
    }
    ?>
</body>

</html>