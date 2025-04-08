<?php
require_once '../form/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta os dados do formulário
    $id = $_POST['id'] ?? '';
    $especialidade = $_POST['especialidade_id'] ?? '';
    $dataConsulta = $_POST['dataConsulta'] ?? '';
    $hora = $_POST['hora'] ?? '';
    $medico = $_POST['medico_id'] ?? '';
    $paciente = $_POST['paciente'] ?? '';
    $sexo = $_POST['sexo'] ?? '';

    try {
        // Atualiza no banco de dados
        $sql = "UPDATE agendamento SET consulta = :consulta, dataConsulta = :dataConsulta, hora = :hora, medico = :medico, paciente = :paciente, sexo = :sexo WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':consulta' => $especialidade,
            ':dataConsulta' => $dataConsulta,
            ':hora' => $hora,
            ':medico' => $medico,
            ':paciente' => $paciente,
            ':sexo' => $sexo,
            ':id' => $id
        ]);

        // Redireciona para a tela de pesquisa
        header("Location: ../pages_1/pesquisa.php");
        exit;
    } catch (PDOException $e) {
        echo "<p style='color:red;'>❌ Erro ao atualizar: " . $e->getMessage() . "</p>";
        exit;
    }
} else {
    // GET: carregar dados para edição
    $id = $_GET['id'] ?? '';

    $sql = "SELECT * FROM agendamento WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);
    $agendamento = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$agendamento) {
        echo "<p style='color:red;'>Agendamento não encontrado.</p>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<link rel="stylesheet" href="../css/style.css">
<head>
    <meta charset="UTF-8">
    <title>Editar Agendamento</title>
</head>

<body>
    <header class="headerConsulta">
        <button class="botaoVoltar" onclick="window.location.href='../index.php';">🏠 Início</button>
        <h1 class="h1Consulta">Editar Agendamento</h1>
    </header>
    <section class="form-section-update">
        <form method="POST">
            <input class="inputPesquisaupdate" type="hidden" name="id" value="<?= htmlspecialchars($agendamento['id']) ?>">

            <label class="labelcad" for="especialidade_id">Especialidade:</label><br>
            <select class='selectcadupdate' name="especialidade_id" required>
                <option value="">-- Selecione --</option>
                <?php
                $sql = "SELECT id, especialidade FROM consulta";
                $stmt = $conn->query($sql);
                foreach ($stmt as $row) {
                    $selected = ($row['especialidade'] === $agendamento['consulta']) ? "selected" : "";
                    echo "<option value='{$row['especialidade']}' $selected>" . htmlspecialchars($row['especialidade']) . "</option>";
                }
                ?>
            </select><br><br>

            <label class="labelcad" for="dataConsulta">Data:</label><br>
            <input class="inputPesquisaupdate" type="date" name="dataConsulta" value="<?= htmlspecialchars($agendamento['dataConsulta']) ?>"
                required><br><br>

            <label class="labelcad" for="hora">Hora:</label><br>
            <input class="inputPesquisaupdate" type="time" name="hora" value="<?= htmlspecialchars($agendamento['hora']) ?>" required><br><br>

            <label class="labelcad" for="medico_id">Médico:</label><br>
            <select class='selectcadupdate' name="medico_id" required>
                <option value="">-- Selecione --</option>
                <?php
                $sql = "SELECT id, medico FROM medico";
                $stmt = $conn->query($sql);
                foreach ($stmt as $row) {
                    $selected = ($row['medico'] === $agendamento['medico']) ? "selected" : "";
                    echo "<option value='{$row['medico']}' $selected>" . htmlspecialchars($row['medico']) . "</option>";
                }
                ?>
            </select><br><br>

            <label class="labelcad" for="paciente">Paciente:</label><br>
            <input class="inputPesquisaupdate" type="text" name="paciente" value="<?= htmlspecialchars($agendamento['paciente']) ?>"
                required><br><br>

            <label class="labelcad" for="sexo">Sexo:</label><br>
            <select class='selectcadupdate' name="sexo" required>
                <option value="">-- Selecione --</option>
                <option value="F" <?= $agendamento['sexo'] == 'F' ? 'selected' : '' ?>>Feminino</option>
                <option value="M" <?= $agendamento['sexo'] == 'M' ? 'selected' : '' ?>>Masculino</option>
            </select><br><br>

            <button class="menuBuscar" type="submit">Atualizar</button>
        </form>
    </section>
</body>

</html>