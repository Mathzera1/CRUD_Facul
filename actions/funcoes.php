<?php

class Usuario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function all() {
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO usuarios (nome, email, cpf, status) VALUES (:nome, :email, :cpf, 'ativo')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nome', $data['nome']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':cpf', $data['cpf']);
        return $stmt->execute();
    }

    public function update($id_usuario, $data) {
        $sql = "UPDATE usuarios SET nome = :nome, email = :email, cpf = :cpf WHERE id_usuario = :id_usuario";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':nome', $data['nome']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':cpf', $data['cpf']);
        $stmt->bindValue(':id_usuario', $id_usuario);
        return $stmt->execute();
    }
    

    public function delete($id_usuario) {
        $sql = "DELETE FROM usuarios WHERE id_usuario = :id_usuario";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id_usuario', $id_usuario);
        return $stmt->execute();
    }


    public function toggleStatus($id_usuario) {
        $sql = "UPDATE usuarios SET status = CASE 
                    WHEN status = 'ativo' THEN 'inativo' 
                    ELSE 'ativo' 
                END WHERE id_usuario = :id_usuario";
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->execute();
    
        $usuario = $this->find($id_usuario);
        return $usuario['status'];
    }    

}