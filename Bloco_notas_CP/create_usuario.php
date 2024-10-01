<?php

include 'db.php';

// Adicionar novo professor
if (isset($_POST["adicionar"])) {
    $nome = $_POST['nome_usuario'];

    $sql = "INSERT INTO usuarios (nome_usuario) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $nome);

    if ($stmt->execute()) {
        echo "Novo usuário registrado com sucesso!";
    } else {
        echo "Erro ao registrar.";
    }
}

// Exibir todos os professores
$sql = "SELECT * FROM usuarios";
$result = $conn->query($sql);

// Exibindo a tabela de professores
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID do Usuário</th>
                <th>Nome do Usuário</th>
                <th>Ações</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id_usuario']}</td>
                <td>{$row['nome_usuario']}</td>
                <td>
                    <form method='POST' action=''>
                        <input type='hidden' name='id_usuario' value='{$row['id_usuario']}'>
                        <input type='submit' name='delete' value='Deletar Dados'>
                    </form>
                    <form method='POST' action=''>
                        <input type='hidden' name='id_usuario' value='{$row['id_usuario']}'>
                        <input type='submit' name='alterar' value='Alterar Dados'>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum registro encontrado.";
}

// Deletar professor
if (isset($_POST["delete"])) {
    $id_usuario = $_POST['id_usuario'];

    $sql_delete = "DELETE FROM usuarios WHERE id_usuario = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param('i', $id_usuario);

    if ($stmt_delete->execute()) {
        echo "Registro deletado com sucesso!";
    } else {
        echo "Erro ao deletar o registro.";
    }

    header("Location: create_usuario.php");
    exit();
}

// Alterar professor (exibir formulário)
if (isset($_POST["alterar"])) {
    echo "<br>
    <br>===/ALTERANDO VALORES\===
    <br>
    <br>";
    $id_update = $_POST["id_usuario"]; // Obtendo o ID do professor

    $sql_select = "SELECT * FROM usuarios WHERE id_usuario = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param('i', $id_update);
    $stmt_select->execute();
    $result_select = $stmt_select->get_result();

    if ($row = $result_select->fetch_assoc()) {
        echo "
        <form method='POST' action=''>
            <input type='hidden' name='id_usuario' value='{$row['id_usuario']}'>
            <label for='nome'>Nome do Usuário: </label>
            <input type='text' name='nome' value='{$row['nome_usuario']}' required><br>

            <input type='submit' name='salvar_alteracoes' value='Salvar Alterações'>
        </form>";
        
        echo "<br>
        <br>
        <br>
        ===/INSERINDO VALORES NOVOS\===
        <br>
        <br>
        <br>";
    }
}

// Salvar alterações do professor
if (isset($_POST["salvar_alteracoes"])) {
    $id_usuario = $_POST['id_usuario'];
    $nome = $_POST['nome'];

    $sql_update = "UPDATE usuarios SET nome_usuario = ? WHERE id_usuario = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('si', $nome, $id_professor);

    if ($stmt_update->execute()) {
        echo "Dados do usuário atualizados com sucesso!";
    } else {
        echo "Erro ao atualizar os dados.";
    }

    header("Location: create_usuario.php");
    exit();
}

$conn->close();

?>

<form method="POST" action="create_usuario.php">
    Nome: <input type="text" name="nome_usuario" required>
   
    <input type="submit" name="adicionar">
</form>

    <a href="index.php"><button>Voltar à página inicial</button></a>
    <a href="create_nota.php"><button>Criar nota</button></a>