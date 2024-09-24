<?php
include('../config/conexao.php');

include 'funcoes.php';

$usuarioObj = new Usuario($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action == 'inserir') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];

        if ($usuarioObj->create(['nome' => $nome, 'email' => $email, 'cpf' => $cpf])) {
            echo "Usuário cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar o usuário.";
        }
    } elseif ($action == 'remover') {
        $id_usuario = $_POST['id_usuario'];
        if ($usuarioObj->delete($id_usuario)) {
            echo "Usuário removido com sucesso!";
        } else {
            echo "Erro ao remover o usuário.";
        }
    } elseif ($_POST['action'] === 'toggle_status') {
        $id_usuario = $_POST['id_usuario'];
        $usuarioObj = new Usuario(pdo: $pdo);
    
        $novo_status = $usuarioObj->toggleStatus($id_usuario);
    
        echo json_encode(['status' => $novo_status]);
        exit;
    } elseif ($action == 'editar') {
        $id_usuario = $_POST['id_usuario'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $cpf = $_POST['cpf'];

        if ($usuarioObj->update($id_usuario, ['nome' => $nome, 'email' => $email, 'cpf' => $cpf])) {
            echo "Usuário editado com sucesso!";
        } else {
            echo "Erro ao editar o usuário.";
        }
    }
}
