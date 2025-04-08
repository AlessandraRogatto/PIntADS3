<?php
require_once 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        $sql = "DELETE FROM agendamento WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Redireciona de volta para a página de pesquisa
        header("Location: ../index.php");
        exit;
    } catch (PDOException $e) {
        echo "Erro ao excluir agendamento: " . $e->getMessage();
    }
} else {
    echo "ID inválido ou requisição incorreta.";
}
?>
