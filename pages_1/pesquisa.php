<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="">
    <link rel="stylesheet" href="../css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Consultas</title>
</head>

<body>
    <header class="headerConsulta">
        <button class="botaoVoltar" onclick="window.location.href='../index.php';">🏠 Início</button>
        <h1 class="h1titulo">Sistema de Agendamento de Consultas</h1>
    </header>

    <?php
    $nome = $_POST['termoPesquisa'] ?? '';
    ?>

    <section class="form-section-pesquisa">
        <form method="POST" action="">
            <label class="labelPesquisa" for="termoPesquisa">Pesquisar</label><br>
            <input class="inputPesquisa" type="text" name="termoPesquisa" required value="<?= $nome ?>">
            <select class="selectPesquisa" name="tipoPesquisa">
                <option value="">-- Selecione --</option>
                <option value="medico">Médico</option>
                <option value="paciente">Paciente</option>
            </select><br>
            <button class="menuBuscar" type="submit" name="pesquisar">Buscar</button>
        </form>
    </section>

    <?php
    require_once '../form/conexao.php';

    $resultados = [];

    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["pesquisar"])) {
        $termoPesquisa = $_POST["termoPesquisa"] ?? '';
        $tipoPesquisa = $_POST["tipoPesquisa"] ?? 'medico';

        // Mapeia os valores do select para os nomes reais das colunas do banco
        $mapaColunas = [
            'medico' => 'medico',
            'paciente' => 'paciente' // Altere aqui se o nome da coluna for diferente
        ];

        $colunaPesquisa = $mapaColunas[$tipoPesquisa] ?? null;

        if (!$colunaPesquisa) {
            echo "<p style='color:red;'>Tipo de pesquisa inválido.</p>";
            exit;
        }

        try {
            $sqlPesquisa = "SELECT * FROM agendamento WHERE $colunaPesquisa LIKE :termoPesquisa";
            $stmtPesquisa = $conn->prepare($sqlPesquisa);
            $stmtPesquisa->execute([':termoPesquisa' => "%$termoPesquisa%"]);
            $resultados = $stmtPesquisa->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "<p style='color:red;'>Erro na pesquisa: " . $e->getMessage() . "</p>";
        }
    }
    ?>

    <br><br>

    <div class="display-pesquisa-resultado">
        <?php if (!empty($resultados)): ?>
            <table class="resultadoPesquisa">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Consulta</th>
                        <th>Data</th>
                        <th>Hora</th>
                        <th>Médico</th>
                        <th>Paciente</th>
                        <th>Sexo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($resultados as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['id']) ?></td>
                            <td><?= htmlspecialchars($row['consulta']) ?></td>
                            <td><?= htmlspecialchars($row['dataConsulta']) ?></td>
                            <td><?= htmlspecialchars($row['hora']) ?></td>
                            <td><?= htmlspecialchars($row['medico']) ?></td>
                            <td><?= htmlspecialchars($row['paciente']) ?></td>
                            <td><?= htmlspecialchars($row['sexo']) ?></td>
                            <td>
                                <!-- Botão de Excluir -->
                                <form action="../form/excluirUsuario.php" method="post" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button class="menuAcoes" type="submit"
                                        onclick="return confirm('Tem certeza que deseja excluir?')">🗑️</button>
                                </form>

                                <!-- Botão de Editar -->
                                <form action="../form/update.php" method="get" style="display:inline;">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button class="menuAcoes" type="submit">✏️</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php elseif ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
            <p style="color:red;">Nenhum resultado encontrado para sua busca.</p>
        <?php endif; ?>
    </div>

</body>

</html>