<?php

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "bloco_notas_cp";


try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Conexão falhou: " . $e->getMessage());
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titulo = trim($_POST['titulo']);
    $conteudo = trim($_POST['conteudo']);
    $usuario_id = trim($_POST['usuario_id']); 

    
    if (empty($titulo) || empty($conteudo)) {
        die('Título e conteúdo são obrigatórios.');
    }

    
    $stmt = $conn->prepare("INSERT INTO notas (titulo, conteudo, usuario_id) VALUES (:titulo, :conteudo, :usuario_id)");
    $stmt->bindParam(':titulo', $titulo);
    $stmt->bindParam(':conteudo', $conteudo);
    $stmt->bindParam(':usuario_id', $usuario_id);

    if ($stmt->execute()) {
        echo "Nota criada com sucesso!";
    } else {
        echo "Erro ao criar a nota.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Nota</title>
</head>
<body>
    <h1>Criar Nova Nota</h1>
    <form method="POST" action="">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>
        <br>
        <label for="conteudo">Conteúdo:</label>
        <textarea id="conteudo" name="conteudo" required></textarea>
        <br>
        <input type="hidden" name="usuario_id" value="1"> 
        <button type="submit">Criar Nota</button>
    </form>
</body>
</html>
