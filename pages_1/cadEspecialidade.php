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
		<h1 class="h1Consulta">Cadastro de Especialidade</h1>
	</header>

	<section class="form-section-especialidade">
		<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" id="formInsert">
			<ul class="menu_section">
				<li>
					<label class="labelcad" for="especialidade">Especialidade</label><br>
					<input class="inputPesquisa" type="text" name="especialidade" id="especialidade">
				</li>
				<li>
					<button class="menuBuscar" type="submit">Salvar</button>
				</li>
			</ul>
		</form>
	</section>

	<?php 
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['especialidade'])) {
		$especialidade = trim($_POST['especialidade'] ?? '');
		

		if (empty($especialidade)) {
			echo "<div class='respauto'>⚠️ Por favor, preencha o campo especialidade.</div>";
		} else {
			try {
				// Verifica se já existe
				$sql_verifica = "SELECT id FROM consulta WHERE especialidade = ?";
				$stmt = $conn->prepare($sql_verifica);
				$stmt->bindValue(1, $especialidade, PDO::PARAM_STR);
				$stmt->execute();

				if ($stmt->rowCount() > 0) {
					echo "<div class='respauto'>❌ Essa especialidade já está cadastrada!</div>";
				} else {
					// Insere nova especialidade
					$sql_inserir = "INSERT INTO consulta (especialidade) VALUES (?)";
					$stmt_inserir = $conn->prepare($sql_inserir);
					$stmt_inserir->bindValue(1, $especialidade, PDO::PARAM_STR);
					$stmt_inserir->execute();

					echo "<div class='respauto'>✅ Especialidade cadastrada com sucesso!</div>";
				}
			} catch (PDOException $e) {
				//echo "<div class='respauto'>❌ Erro ao cadastrar: " . $e->getMessage() . "</div>";
			}
		}
	}
	?>

</body>
</html>