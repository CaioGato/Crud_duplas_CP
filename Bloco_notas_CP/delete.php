<?php
include 'include.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("DELETE FROM nota WHERE id = :id");
$stmt->execute(['id' => $id]);
header("Location: excluirnota.php");
?>