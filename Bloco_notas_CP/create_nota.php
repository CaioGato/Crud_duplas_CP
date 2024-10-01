<?php
include 'db.php'; 

$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

// Exibindo a tabela de professores
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID do Usuario</th>
                <th>Nome do Usuário</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id_usuario']}</td>
                <td>{$row['nome_usuario']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum registro encontrado.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];
    $usuario_id = $_POST['fk_usuario']; 

    $stmt = $conn->prepare("INSERT INTO notas (titulo_nota, texto_nota, fk_usuario) VALUES (?, ?, ?)");
    $stmt->execute([$titulo, $conteudo, $usuario_id]);

    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Criar Nova Nota</title>
</head>
<body>
    <h1>Criar Nova Nota</h1>
    <form method="POST">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>

        <label for="conteudo">Conteúdo:</label>
        <textarea id="conteudo" name="conteudo" required></textarea>

        <label for="fk_usuario">Usuário id:</label>
        <input type="number" id="usuario" name="fk_usuario" required>

        <button type="submit">Salvar</button>
    </form>  

    <a href="index.php"><button>Voltar à página inicial</button></a>

</body>
</html>
