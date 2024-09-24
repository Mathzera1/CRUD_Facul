<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro de Usuários</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <div class="container">
    <div class="row justify-content-center mt-5">
      <div class="col-md-6">
        <div class="form-container">
          <h2>Cadastro de Usuários</h2>
          <form id="addUserForm">
            <div class="mb-3">
              <label for="nome" class="form-label">Nome</label>
              <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome completo" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu email" required>
            </div>
            <div class="mb-3">
              <label for="cpf" class="form-label">CPF</label>
              <input type="text" class="form-control" id="cpf" name="cpf" placeholder="Digite seu CPF" required maxlength="11">
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-primary">Enviar</button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="row justify-content-center mt-5">
      <div class="col-md-6 text-center">
        <a href="gerenciar_usuarios.php" class="btn btn-secondary">Gerenciar Usuários</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#addUserForm').on('submit', function(e) {
        e.preventDefault();

        var nome = $('#nome').val();
        var email = $('#email').val();
        var cpf = $('#cpf').val();

        $.ajax({
          url: 'actions/metodos.php',
          method: 'POST',
          data: {
            action: 'inserir',
            nome: nome,
            email: email,
            cpf: cpf
          },
          success: function(response) {
            alert(response);
            location.reload();
          },
          error: function(xhr, status, error) {
            console.error(error);
            alert("Ocorreu um erro ao cadastrar o usuário.");
          }
        });
      });
    });
  </script>
</body>
</html>
