<?php
require_once 'includes/config.php';
checkAuth();

// Carregar dados do banco
$usersData = loadData('users');

// Definir header para JSON
header('Content-Type: application/json; charset=utf-8');

// Exibir JSON formatado
echo json_encode($usersData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
?>
