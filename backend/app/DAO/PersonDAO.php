<?php

include_once '../../models/Person.php';

class PersonDAO implements IPersonDAO {

  private $conn;

  public function __construct($conn) {
    $this->conn = $conn;
  }
  
  public function create(Person $person) {

    $stmt = $this->conn;

    $st = $stmt->prepare("INSERT INTO clients_person (name, document, email, birth, gender, address) VALUES (:name, :document, :email, :birth, :gender, :address)");

    $st->bindValue(":name", $person->getName());
    $st->bindValue(":document", $person->getDocument());
    $st->bindValue(":email", $person->getEmail());
    $st->bindValue(":birth", $person->getBirth());
    $st->bindValue(":gender", $person->getGender());
    $st->bindValue(":address", $person->getAddress());

    $st->execute();

    $result = $stmt->lastInsertId();
    
    return $this->findById($result);
  }

  public function findAll() {

    $stmt = $this->conn;
    $persons = [];

    $st = $stmt->query("SELECT * FROM clients_person");

    $data = $st->fetchAll();

    foreach ($data as $key => $value) {

      $id = $value['id'];
      $name = $value['name'];
      $document = $value['document'];
      $email = $value['email'];
      $birth = $value['birth'];
      $gender = $value['gender'];
      $address = $value['address'];
      $active = $value['active'];
      
      $person = new Person();

      $person->setId($id);
      $person->setName($name);
      $person->setDocument($document);
      $person->setEmail($email);
      $person->setBirth($birth);
      $person->setGender($gender);
      $person->setAddress($address);
      $person->setActive($active);

      $transformObjInArray = json_decode(json_encode($person), true);

      array_push($persons, $transformObjInArray);

    }

    return $persons;
  }

  public function findById($id) {

    $stmt = $this->conn;

    $st = $stmt->prepare("SELECT * FROM clients_person WHERE id = :id");

    $st->bindValue(":id", $id);

    $st->execute();

    $data = $st->fetch(PDO::FETCH_ASSOC);

    $id = $data['id'];
    $name = $data['name'];
    $document = $data['document'];
    $email = $data['email'];
    $birth = $data['birth'];
    $gender = $data['gender'];
    $address = $data['address'];
    $active = $data['active'];
    
    $person = new Person();

    $person->setId($id);
    $person->setName($name);
    $person->setDocument($document);
    $person->setEmail($email);
    $person->setBirth($birth);
    $person->setGender($gender);
    $person->setAddress($address);
    $person->setActive($active);

    $transformObjInArray = json_decode(json_encode($person), true);

    return $transformObjInArray;
  }

  public function update(Person $person) {
   
    $stmt = $this->conn;

    $st = $stmt->prepare("UPDATE clients_person SET name = :name, document = :document, email = :email, birth = :birth, gender = :gender, address = :address WHERE id = :id");

    $st->bindValue(":name", $person->getName());
    $st->bindValue(":document", $person->getDocument());
    $st->bindValue(":email", $person->getEmail());
    $st->bindValue(":birth", $person->getBirth());
    $st->bindValue(":gender", $person->getGender());
    $st->bindValue(":address", $person->getAddress());
    $st->bindValue(":id", $person->getId());

    $st->execute();

    return $this->findById($person->getId());

  }
}