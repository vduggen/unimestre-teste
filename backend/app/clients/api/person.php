<?php

include_once '../../DAO/PersonDAO.php';
include_once '../../utils.php';

$conn = Utils::getConnection();
$personDAO = new PersonDAO($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  $name = $body->name;
  $document = $body->document;
  $email = $body->email;
  $birth = $body->birth;
  $gender = $body->gender;
  $address = $body->address;
  
  $newPerson = new Person();

  $newPerson->setName($name);
  $newPerson->setDocument($document);
  $newPerson->setEmail($email);
  $newPerson->setBirth($birth);
  $newPerson->setGender($gender);
  $newPerson->setAddress($address);

  $result = $personDAO->create($newPerson);

  Utils::ReturnSuccess($result);

}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  
  $id = $body->id;
  $name = $body->name;
  $document = $body->document;
  $email = $body->email;
  $birth = $body->birth;
  $gender = $body->gender;
  $address = $body->address;
  
  $newPerson = new Person();

  $newPerson->setId($id);
  $newPerson->setName($name);
  $newPerson->setDocument($document);
  $newPerson->setEmail($email);
  $newPerson->setBirth($birth);
  $newPerson->setGender($gender);
  $newPerson->setAddress($address);

  $result = $personDAO->update($newPerson);

  Utils::ReturnSuccess($result);

}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  $results = [];

  if (isset($_GET['id'])) {

    $results = $personDAO->findById($_GET['id']);

  } else {

    $results = $personDAO->findAll();

  }


  Utils::ReturnSuccess($results);
  
}