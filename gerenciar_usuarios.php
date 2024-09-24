<?php
include 'config/conexao.php';
include 'actions/funcoes.php';

$usuarioObj = new Usuario($pdo);

$usuarios = $usuarioObj->all();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gerenciamento de Usuários</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <link rel="stylesheet" href="styles.css">
  <style>
    .d-flex .btn {
      flex: 1;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-8">
        <h2 class="text-center mb-4">Gerenciamento de Usuários</h2>

        <div class="mb-3 text-center">
          <a href="index.php" class="btn btn-secondary">Voltar ao Cadastro</a>
        </div>

        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nome</th>
              <th>Email</th>
              <th>CPF</th>
              <th>Status</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody id="userTableBody">
            <?php foreach ($usuarios as $user): ?>
              <tr>
                <td><?= htmlspecialchars($user['id_usuario']) ?></td>
                <td><?= htmlspecialchars($user['nome']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['cpf']) ?></td>
                <td class="statusCell"><?= htmlspecialchars($user['status']) ?></td>
                <td>
                  <div class="d-flex justify-content-between">
                    <button class="btn btn-warning me-1 editBtn" 
                            data-id_usuario="<?= htmlspecialchars($user['id_usuario']); ?>" 
                            data-nome="<?= htmlspecialchars($user['nome']); ?>" 
                            data-email="<?= htmlspecialchars($user['email']); ?>" 
                            data-cpf="<?= htmlspecialchars($user['cpf']); ?>" 
                            data-bs-toggle="modal" 
                            data-bs-target="#editUserModal">
                      Editar
                    </button>

                    <button type="button" class="btn btn-danger btn-sm me-1 removeBtn" 
                            data-id_usuario="<?= htmlspecialchars($user['id_usuario']); ?>">
                      Remover
                    </button>

                    <button type="button" 
                            class="btn btn-secondary btn-sm toggleStatusBtn" 
                            data-id_usuario="<?= htmlspecialchars($user['id_usuario']); ?>"
                            data-status="<?= htmlspecialchars($user['status']) ?>">
                        <?= htmlspecialchars($user['status']) == 'ativo' ? 'Inativar' : 'Ativar' ?>
                    </button>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editUserModalLabel">Editar Usuário</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="editUserForm" method="POST">
              <input type="hidden" id="edit_id_usuario" name="id_usuario">
              <div class="mb-3">
                <label for="edit_nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="edit_nome" name="nome" required>
              </div>
              <div class="mb-3">
                <label for="edit_email" class="form-label">Email</label>
                <input type="email" class="form-control" id="edit_email" name="email" required>
              </div>
              <div class="mb-3">
                <label for="edit_cpf" class="form-label">CPF</label>
                <input type="text" class="form-control" id="edit_cpf" name="cpf" required>
              </div>
              <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
          </div>
        </div>
      </div>
    </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $('.editBtn').on('click', function() {
      var id_usuario = $(this).data('id_usuario');
      var nome = $(this).data('nome');
      var email = $(this).data('email');
      var cpf = $(this).data('cpf');

      $('#edit_id_usuario').val(id_usuario);
      $('#edit_nome').val(nome);
      $('#edit_email').val(email);
      $('#edit_cpf').val(cpf);
    });

    $('#editUserForm').on('submit', function(event) {
      event.preventDefault();
      var formData = $(this).serialize();

      $.ajax({
        url: 'actions/metodos.php',
        method: 'POST',
        data: formData + '&action=editar',
        success: function(response) {
          alert(response);
          location.reload();
        },
        error: function(xhr, status, error) {
          console.error("Erro ao editar o usuário: " + error);
        }
      });
    });

    $('.removeBtn').on('click', function() {
      var id_usuario = $(this).data('id_usuario');

      if (confirm("Tem certeza que deseja remover este usuário?")) {
        $.ajax({
          url: 'actions/metodos.php',
          method: 'POST',
          data: { action: 'remover', id_usuario: id_usuario },
          success: function(response) {
            alert(response);
            location.reload();
          },
          error: function(xhr, status, error) {
            console.error("Erro ao remover o usuário: " + error);
          }
        });
      }
    });

    $('.toggleStatusBtn').on('click', function() {
      var id_usuario = $(this).data('id_usuario');
      var $statusCell = $(this).closest('tr').find('.statusCell');

      $.ajax({
        type: 'POST',
        url: 'actions/metodos.php',
        data: {
          action: 'toggle_status',
          id_usuario: id_usuario
        },
        success: function(response) {
          location.reload();
        }.bind(this),
        error: function(xhr, status, error) {
          console.error("Erro ao alternar o status: " + error);
        }
      });
    });
  </script>
</body>
</html>
