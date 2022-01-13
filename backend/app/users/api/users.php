<?php

include_once '../../DAO/UserDAO.php';
include_once '../../utils.php';

$conn = Utils::getConnection();
$userDAO = new UserDAO($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $document = $body->document;
  $password = $body->password;
  $person = $body->person;
  
  $newUser = new User();
  $newUser->setDocument($document);
  $newUser->setPassword($password);
  $newUser->setPerson($person);
  $newUser->setHash($document);
  
  $result = $userDAO->create($newUser);

  Utils::ReturnSuccess($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

  $id = $body->id;
  $password = $body->password;
  
  $newUser = new User();
  $newUser->setPassword($password);
  $newUser->setId($id);
  
  $result = $userDAO->update($newUser);

  Utils::ReturnSuccess($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

   if (isset($_GET['document']) && isset($_GET['password'])) {
    $result = $userDAO->findByLogin($_GET['document'], $_GET['password']);

    Utils::ReturnSuccess($result['data'], $result['message'], $result['code']);

  } else if (isset($_GET['document'])) {

    $result = $userDAO->findByDocument($_GET['document']);

    Utils::ReturnSuccess($result['data'], $result['message'], $result['code']);

  } else if (isset($_GET['hash'])) {

    $result = $userDAO->findByHash($_GET['hash']);

    Utils::ReturnSuccess($result);

  } else {

    $result = $userDAO->findAll();

    Utils::ReturnSuccess($result);

  }

  
}