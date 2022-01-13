<?php

include_once '../../DAO/AddressDAO.php';
include_once '../../utils.php';

$conn = Utils::getConnection();
$addressDAO = new AddressDAO($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $neighborhood = $body->neighborhood;
  $street = $body->street;
  $number = $body->number;
  $complement = $body->complement;
  $zipcode = $body->zipcode;
  $city = $body->city;
  $state = $body->state;
  
  $newAddress = new Address();
  $newAddress->setNeighborhood($neighborhood);
  $newAddress->setStreet($street);
  $newAddress->setNumber($number);
  $newAddress->setComplement($complement);
  $newAddress->setZipcode($zipcode);
  $newAddress->setCity($city);
  $newAddress->setState($state);
  
  $result = $addressDAO->create($newAddress);

  Utils::ReturnSuccess($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  $results = [];

  if (isset($_GET['id'])) {

    $results = $addressDAO->findById($_GET['id']);

  } else {

    $results = $addressDAO->findAll();

  }


  Utils::ReturnSuccess($results);
  
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

  $results = [];

  $id = $body->id;
  $neighborhood = $body->neighborhood;
  $street = $body->street;
  $number = $body->number;
  $complement = $body->complement;
  $zipcode = $body->zipcode;
  $city = $body->city;
  $state = $body->state;
  
  $newAddress = new Address();
  $newAddress->setId($id);
  $newAddress->setNeighborhood($neighborhood);
  $newAddress->setStreet($street);
  $newAddress->setNumber($number);
  $newAddress->setComplement($complement);
  $newAddress->setZipcode($zipcode);
  $newAddress->setCity($city);
  $newAddress->setState($state);
  
  $result = $addressDAO->update($newAddress);

  Utils::ReturnSuccess($results);
  
}