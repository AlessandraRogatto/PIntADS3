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

    <header class="headerConsulta">
        <button class="botaoVoltar" onclick="window.location.href='../index.php';">🏠 Início</button>
        <h1 class="h1Consulta">Cadastramento de Profissional de Saúde</h1>
    </header>

    <section class="form-section-medico">
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" id="formInsert">
            <ul class="menu_section">
                <li>
                    <label class="labelcad" for="crm">CRM</label><br>
                    <input class="inputPesquisa" type="text" name="crm" id="crm">
                </li>
                <li>
                    <label class="labelcad" for="medico">Nome do Médico</label><br>
                    <input class="inputMedico" type="text" name="medico" id="medico">
                </li>
                <li>
                    <button class="menuBuscar" type="submit">Salvar</button>
                </li>
            </ul>
        </form>
    </section>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $crm = trim($_POST['crm'] ?? '');
        $medico = trim($_POST['medico'] ?? '');

        if (empty($crm) || empty($medico)) {
            echo "<div class='respauto'>⚠️ Por favor, preencha todos os campos.</div>";
        } else {
            try {
                // Verifica se já existe
                $sql_verifica = "SELECT id FROM medico WHERE crm = ?";
                $stmt = $conn->prepare($sql_verifica);
                $stmt->bindValue(1, $crm, PDO::PARAM_STR);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    echo "<div class='respauto'>❌ Esse CRM já está cadastrado!</div>";
                } else {
                    // Insere novo médico
                    $sql_inserir = "INSERT INTO medico (crm, medico) VALUES (?, ?)";
                    $stmt_inserir = $conn->prepare($sql_inserir);
                    $stmt_inserir->bindValue(1, $crm, PDO::PARAM_STR);
                    $stmt_inserir->bindValue(2, $medico, PDO::PARAM_STR);
                    $stmt_inserir->execute();

                    echo "<div class='respauto'>✅ Médico cadastrado com sucesso!</div>";
                }
            } catch (PDOException $e) {
                echo "<div class='respauto'>❌ Erro ao cadastrar: " . $e->getMessage() . "</div>";
            }
        }
    }
    ?>

</body>

</html>