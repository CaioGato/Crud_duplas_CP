<?php
include "db.php";

// Consulta SQL para exibir os registros do diário
$sql = "SELECT  n.id_nota, n.titulo_nota, n.texto_nota, n.fk_usuario, u.nome_usuario 
        FROM notas AS n 
        INNER JOIN usuarios AS u ON n.fk_usuario = u.id_usuario";
$result = $conn->query($sql);

// Exibindo a tabela de aulas
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Id da nota</th>
                <th>Titulo da Nota</th>
                <th>Conteudo</th>
                <th>Id Autor</th>
                <th>Autor</th>
                <th>Ações</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id_nota']}</td>
                <td>{$row['titulo_nota']}</td> 
                <td>{$row['texto_nota']}</td>
                <td>{$row['fk_usuario']}</td>
                <td>{$row['nome_usuario']}</td>
                <td>
                    <form method='POST' action=''>
                        <input type='hidden' name='id_nota' value='{$row['id_nota']}'>
                        <input type='submit' name='alterar' value='Alterar Dados'>
                    </form>
                    </td>
              </tr>";
    }
    echo "</table>";
    $conteudo = $row['texto_nota'];
} else {
    echo "Nenhum registro encontrado";
}

// Consulta SQL para buscar os professores
$sql_usuarios = "SELECT id_usuario, nome_usuario FROM usuarios";
$stmt = $conn->prepare($sql_usuarios);
$stmt->execute();
$result_usuarios = $stmt->get_result();

// Verificando se o botão "alterar" foi clicado
if (isset($_POST["alterar"])) {
    $id_update = $_POST["id_nota"]; // Obtendo o ID da aula selecionada

    echo "ID da nota a ser alterada: $id_update
    <br>Valores a serem alterados:
    <br>
    <form method='POST' action=''>
        <input type='hidden' name='id_nota' value='$id_update'>
        <label for='titulo'>Titulo: </label>
        <input type='text' name='titulo' required><br>

        <label for='texto'>conteudo: </label>
        <input type='text' name='texto' value='$conteudo' required><br>

        <label for='id_usuario'>Id Usuário: </label>
        <input type='number' name='id_usuario' required><br>

        <input type='submit' name='salvar' value='Salvar Alterações'>
    </form>";
}

// Verificando se os novos valores foram enviados
if (isset($_POST["salvar"])) {
    $id_update = $_POST['id_nota'];
    $titulo = $_POST['titulo'];
    $texto = $_POST['conteudo'];
    $id_usuario = $_POST['id_usuario'];

    // Atualizando os dados da aula na tabela 'aulas'
    $sql_update = "UPDATE notas 
                   SET titulo_nota = ?, texto_nota = ?, fk_usuario
                   WHERE id_nota = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('sssi', $titulo, $texto, $fk_usuario, $id_update);
    $stmt_update->execute();

    echo "Dados da nota atualizados com sucesso!";
    header ("Location: update_nota.php");
    exit();
}

$conn->close();
?>


<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
</head>
<body>
<br>



    </form>
    <a href="index.php"><button>Voltar a página inicial</button></a>
    <a href="createusuario.php"><button>Página dos usuários</button></a>

</body>
</html>