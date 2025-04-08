<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../css/style.css">
	<title>Projeto Integrador ADS</title>
</head>

<body>
	<?php require_once '../form/conexao.php' ?>
	<header class="headerConsulta">
		<button class="botaoVoltar" onclick="window.location.href='../index.php';">🏠 Início</button>
		<h1 class="h1Consulta">Sistema de agendamento de consultas médicas</h1>
	</header>
	<section class="form-section">
		<form action="../form/formulario.php" method="post" id="formInsert">
			<ul class="menu_section">
				<li>
					<label class="labelcad" for="consulta">Selecione a Consulta:</label><br>
					<?php
					// Mostra todos os erros (para debug)
					ini_set('display_errors', 1);
					error_reporting(E_ALL);

					require_once '../form/conexao.php';

					try {
						$sql = "SELECT id, especialidade FROM consulta";
						$stmt = $conn->prepare($sql);
						$stmt->execute();
						$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

						if (count($dados) > 0) {
							echo "<select class='selectcad' name='especialidade_id' id='especialidade'>";
							echo "<option value=''>-- Selecione --</option>"; // opção padrão
							foreach ($dados as $linha) {
								echo "<option value='{$linha['id']}'>" . htmlspecialchars($linha['especialidade']) . "</option>";
							}
							echo "</select>";
						} else {
							echo "<p style='color: red;'>Nenhuma especialidade cadastrada.</p>";
						}
					} catch (PDOException $e) {
						echo "<p style='color: red;'>Erro: " . $e->getMessage() . "</p>";
					}

					?>

					<!-- <label for="consulta">Consulta</label><br>-->
				</li>
				<li>
					<label class="labelcad" for="dataConsulta">Data</label><br>
					<input class="inputPesquisa" type="date" name="dataConsulta" id="">
				</li>
				<li>
					<label class="labelcad" for="hora">Horário</label><br>
					<input class="inputPesquisa" class="datetime" type="time" name="hora" id="">
				</li>
				<li>
					<!-- <label for="medico">Médico</label><br>
					<input class="datetime" type="text" name="medico" id=""> -->

					<label class="labelcad" for="medico">Selecione o Médico:</label><br>
					<?php
					// Mostra todos os erros (para debug)
					ini_set('display_errors', 1);
					error_reporting(E_ALL);

					require_once '../form/conexao.php';
					try {
						$sql = "SELECT id, medico FROM medico";
						$stmt = $conn->prepare($sql);
						$stmt->execute();
						$dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

						if (count($dados) > 0) {
							echo "<select class='selectcad' name='medico_id' id='medico'>";
							echo "<option value=''>-- Selecione --</option>"; // primeira opção padrão
							foreach ($dados as $linha) {
								echo "<option value='{$linha['id']}'>" . htmlspecialchars($linha['medico']) . "</option>";
							}
							echo "</select>";
						} else {
							echo "<p style='color: red;'>Nenhum médico cadastrado.</p>";
						}
					} catch (PDOException $e) {
						echo "<p style='color: red;'>Erro: " . $e->getMessage() . "</p>";
					}

					?>
				</li>
				<li>
					<label class="labelcad" for="paciente">Paciente</label><br>
					<input class="inputPesquisa" type="text" name="paciente" id="">
				</li>
				<li>
					<label class="labelcad" for="sexo">Sexo:</label><br>
					<select class='selectcad' name="sexo" required>
						<option value="">-- Selecione --</option>
						<option value="M">Masculino</option>
						<option value="F">Feminino</option>
					</select>

				</li>
				<li>
					<button class="menuBuscar" type="submit">Salvar</button>
				</li>
			</ul>
		</form>
	</section>
</body>

</html>