<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];

    $stmt = $conn->prepare("UPDATE nota SET titulo = ?, conteudo = ? WHERE id = ?");
    $stmt->execute([$titulo, $conteudo, $id]);

    header('Location: index.php');
    exit;
} else if (isset($_GET['id'])) {
    $id = $_GET['id'];


    $stmt = $conn->prepare("SELECT * FROM nota WHERE id = ?");
    $stmt->execute([$id]);
    $nota = $stmt->fetch();
} else {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Nota</title>
</head>
<body>
    <?php if (isset($nota)): ?>
        <h1>Editar Nota</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($nota['id']) ?>">
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" value="<?= htmlspecialchars($nota['titulo']) ?>" required>

            <label for="conteudo">Conteúdo:</label>
            <textarea id="conteudo" name="conteudo" required><?= htmlspecialchars($nota['conteudo']) ?></textarea>

            <button type="submit">Salvar</button>
        </form>
    <?php else: ?>
        <p>Nota não encontrada.</p>
    <?php endif; ?>
</body>
</html>