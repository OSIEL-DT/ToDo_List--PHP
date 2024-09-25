<?php
// Conectar ao banco de dados
$conn = new mysqli('localhost', 'root', '', 'todolist');

// Verificar a conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

// Função para obter todas as tarefas
function getTasks($conn) {
    $sql = "SELECT * FROM tasks ORDER BY created_at DESC";
    $result = $conn->query($sql);
    return $result;
}

// Verificar se o formulário de nova tarefa foi submetido
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task'])) {
    $task = $conn->real_escape_string($_POST['task']);

    // Inserir a nova tarefa no banco de dados
    $sql = "INSERT INTO tasks (task) VALUES ('$task')";
    if ($conn->query($sql) === TRUE) {
        echo "Nova tarefa adicionada com sucesso!";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }
}

// Obter todas as tarefas do banco de dados
$tasks = getTasks($conn);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciador de Tarefas</title>
    <link rel="stylesheet" href="styles.css"> <!-- Arquivo de estilos -->
</head>
<body>
    <div class="container">
        <h1>Lista de Tarefas</h1>

        <!-- Formulário para adicionar uma nova tarefa -->
        <form method="POST" action="index.php">
            <input type="text" name="task" placeholder="Digite uma nova tarefa" required>
            <button type="submit">Adicionar Tarefa</button>
        </form>

        <!-- Exibir todas as tarefas -->
        <ul>
            <?php
            if ($tasks->num_rows > 0) {
                while ($row = $tasks->fetch_assoc()) {
                    echo '<li>' . htmlspecialchars($row['task']) . ' 
                          <a href="delete.php?id=' . $row['id'] . '">Excluir</a></li>';
                }
            } else {
                echo "<li>Nenhuma tarefa encontrada!</li>";
            }
            ?>
        </ul>
    </div>
</body>
</html>

<?php
// Fechar a conexão com o banco de dados
$conn->close();
?>
