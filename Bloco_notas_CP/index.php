<?php
// Modificação da atividade crud em duplas Johann Paulo.



// Deve ser possível ver o quadro de horários com os dados da aula e tudo mais.

// Além disso, deve ser possível ir até uma página para inserir um professor ou aula.

// Ideia: no quadro de horário pode ser possível deletar o horário/aula.

// Ideia: no quadro de horário pode ser possível alterar o dado de uma aula


// nome Professor, ID do professor, dia da aula, sala da aula, ID da aula

// ============== READ ============== //

include 'db.php';

$sql = "SELECT u.nome_usuario, n.id_nota, n.titulo_nota, n.texto_nota 
        FROM notas AS n  
        INNER JOIN usuarios AS u ON n.fk_usuario = u.id_usuario";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Autor</th>
                <th>Titulo</th>
                <th>Conteúdo</th>
                <th>Ações</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['nome_usuario']}</td>
                <td>{$row['titulo_nota']}</td> 
                <td>{$row['texto_nota']}</td>
                <td>
                    <form method='POST' action=''>
                        <input type='hidden' name='id_nota' value='{$row['id_nota']}'>
                        <input type='submit' name='delete' value='Deletar Dados'>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Nenhum registro encontrado";
}

// Deletar após apertar o botão "Deletar Dados"
if (isset($_POST["delete"])) {
    if (isset($_POST['id_nota']) && !empty($_POST['id_nota'])) {
        $id_del = $_POST['id_nota']; // Obtém o ID da aula a ser deletada
        
        // Deletar da tabela `diario` e da tabela `aulas`
        $sql_delete_nota = "DELETE FROM notas WHERE id_nota = ?";
        
        // Preparar e executar a exclusão da tabela `aulas`
        $stmt_del_nota = $conn->prepare($sql_delete_nota);
        $stmt_del_nota->bind_param('i', $id_del);
        $stmt_del_nota->execute();

        if ($stmt_del_nota->affected_rows > 0) {
            echo "Registro deletado com sucesso!";
        } else {
            echo "Erro ao deletar o registro.";
        }
    } else {
        echo "ID da nota não encontrado.";
    }
    header ("Location: index.php");
    exit();
}

$conn -> close();
?>

<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud C. P.</title>
</head>
<body>
    
    <h3>Quadro de notas</h3>
    <h4>Ações:</h4>
    <a href="create_usuario.php"><button>Página dos Usuários</button></a>
    <a href="create_nota.php"><button>Criar Notas</button></a>
    <a href="update_nota.php"><button>Alterar Notas</button></a>
</body>
</html>
