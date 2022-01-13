<?php

include_once '../../models/User.php';

class UserDAO implements IUserDAO {

  private $conn;

  public function __construct($conn) {
    $this->conn = $conn;
  }
  
  public function create(User $user) {

    $stmt = $this->conn;

    $st = $stmt->prepare("INSERT INTO users_users (document, password, person, hash) VALUES (:document, :password, :person, :hash)");

    $st->bindValue(":document", $user->getDocument());
    $st->bindValue(":password", $user->getPassword());
    $st->bindValue(":person", $user->getPerson());
    $st->bindValue(":hash", hash('sha256', $user->getDocument()));

    $st->execute();

    $result = $stmt->lastInsertId();
    
    return $this->findById($result);

  }

  public function read($id) {

    $stmt = $this->conn;

    $st = $stmt->prepare("SELECT * FROM users_users WHERE id = :id");

    $st->bindValue(":id", $id);

    $st->execute();

    $result = $st->fetch(PDO::FETCH_ASSOC);

    $user = new User();

    $user->setId($result['id']);
    $user->setDocument($result['document']);
    $user->setPassword($result['password']);
    $user->setPerson($result['person']);
    $user->setActive($result['active']);
    $user->setHash($result['hash']);

    return json_decode(json_encode($user), true);

  }

  public function findAll() {

    $stmt = $this->conn;
    $users = [];

    $st = $stmt->query("SELECT * FROM users_users");

    $data = $st->fetchAll();

    foreach ($data as $key => $value) {

      $id = $value['id'];
      $document = $value['document'];
      $password = $value['password'];
      $person = $value['person'];
      $active = $value['active'];
      $hash = $value['hash'];
      
      $user = new User();

      $user->setId($id);
      $user->setDocument($document);
      $user->setPassword($password);
      $user->setPerson($person);
      $user->setActive($active);
      $user->setHash($hash);

      $transformObjInArray = json_decode(json_encode($user), true);

      array_push($users, $transformObjInArray);

    }

    return $users;
  }

  public function findById($id) {

    $stmt = $this->conn;

    $st = $stmt->prepare("SELECT * FROM users_users WHERE id = :id");

    $st->bindValue(":id", $id);

    $st->execute();

    $data = $st->fetch(PDO::FETCH_ASSOC);

    $id = $data['id'];
    $document = $data['document'];
    $password = $data['password'];
    $person = $data['person'];
    $active = $data['active'];
    $hash = $data['hash'];
    
    $newUser = new User();

    $newUser->setId($id);
    $newUser->setDocument($document);
    $newUser->setPassword($password);
    $newUser->setPerson($person);
    $newUser->setActive($active);
    $newUser->setHash($hash);

    $transformObjInArray = json_decode(json_encode($newUser), true);

    return $transformObjInArray;
  }

  public function findByDocument($document) {

    $stmt = $this->conn;

    $st = $stmt->prepare("SELECT * FROM users_users WHERE document = :document");

    $st->bindValue(":document", $document);

    $st->execute();

    $data = $st->fetch(PDO::FETCH_ASSOC);

    if ($data) {

      return array(

        "message" => "Usuário já existe, faça login para alterar suas informações",
        "data" => [],
        "code" => 400

      );

    } else {

      return array(

        "message" => "",
        "data" => [],
        "code" => 200

      );

    }
  }

  public function findByHash($hash) {

    $stmt = $this->conn;

    $st = $stmt->prepare("SELECT * FROM users_users WHERE hash = :hash");

    $st->bindValue(":hash", $hash);

    $st->execute();

    $data = $st->fetch(PDO::FETCH_ASSOC);

    $id = $data['id'];
    $document = $data['document'];
    $password = $data['password'];
    $person = $data['person'];
    $active = $data['active'];
    $active = $data['hash'];
    
    $newUser = new User();

    $newUser->setId($id);
    $newUser->setDocument($document);
    $newUser->setPassword($password);
    $newUser->setPerson($person);
    $newUser->setActive($active);
    $newUser->setHash($hash);

    $transformObjInArray = json_decode(json_encode($newUser), true);

    return $transformObjInArray;
  }

  public function findByLogin($document, $passwordFromPost) {

    $stmt = $this->conn;

    $st = $stmt->prepare("SELECT * FROM users_users WHERE document = :document");

    $st->bindValue(":document", $document);

    $st->execute();

    $data = $st->fetch(PDO::FETCH_ASSOC);

    if ($data) {
      $password = $data['password'];

      if ($password === hash('sha256', $passwordFromPost)) {
        $id = $data['id'];
        $document = $data['document'];
        $person = $data['person'];
        $active = $data['active'];
        $hash = $data['hash'];
        
        $newUser = new User();

        $newUser->setId($id);
        $newUser->setDocument($document);
        $newUser->setPassword($password);
        $newUser->setPerson($person);
        $newUser->setActive($active);
        $newUser->setHash($hash);

        $transformObjInArray = json_decode(json_encode($newUser), true);

        return array(

          "message" => "",
          "data" => $transformObjInArray,
          "code" => 200

        );
      } else {

        return array(

          "message" => "Credenciais inválidas",
          "data" => [],
          "code" => 401

        );

      }

    } else {

      return array(

        "message" => "Usuário não encontrado",
        "data" => [],
        "code" => 404

      );

    }
  }

  public function update(User $user) {
   
    $stmt = $this->conn;

    $st = $stmt->prepare("UPDATE users_users SET password = :password WHERE id = :id");

    $st->bindValue(":password", $user->getPassword());
    $st->bindValue(":id", $user->getId());

    $st->execute();

    return $this->findById($user->getId());

  }

}