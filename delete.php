<?php
// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'todolist');

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Verificar se o ID foi passado via GET
if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);

    // Deletar a tarefa com o ID fornecido
    $sql = "DELETE FROM tasks WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "Tarefa excluída com sucesso!";
    } else {
        echo "Erro ao excluir a tarefa: " . $conn->error;
    }
}

// Redirecionar de volta para a página principal
header("Location: index.php");

// Fechar a conexão com o banco de dados
$conn->close();
?>
