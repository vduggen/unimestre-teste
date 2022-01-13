<?php

include_once '../../models/Address.php';

class AddressDAO implements IAddressDAO {

  private $conn;

  public function __construct($conn) {
    $this->conn = $conn;
  }
  
  public function create(Address $address) {

    $stmt = $this->conn;

    $st = $stmt->prepare("INSERT INTO clients_address (neighborhood, street, number, complement, zipcode, city, state) VALUES (:neighborhood, :street, :number, :complement, :zipcode, :city, :state)");

    $st->bindValue(":neighborhood", $address->getNeighborhood());
    $st->bindValue(":street", $address->getStreet());
    $st->bindValue(":number", $address->getNumber());
    $st->bindValue(":complement", $address->getComplement());
    $st->bindValue(":zipcode", $address->getZipcode());
    $st->bindValue(":city", $address->getCity());
    $st->bindValue(":state", $address->getState());

    $st->execute();

    $result = $stmt->lastInsertId();
    
    return $this->findById($result);

  }

  public function findAll() {

    $stmt = $this->conn;
    $address = [];

    $st = $stmt->query("SELECT * FROM clients_address");

    $data = $st->fetchAll();

    foreach ($data as $key => $value) {

      $id = $value['id'];
      $neighborhood = $value['neighborhood'];
      $street = $value['street'];
      $number = $value['number'];
      $complement = $value['complement'];
      $zipcode = $value['zipcode'];
      $city = $value['city'];
      $state = $value['state'];
      $active = $value['active'];
      
      $newAddress = new Address();

      $newAddress->setId($id);
      $newAddress->setNeighborhood($neighborhood);
      $newAddress->setStreet($street);
      $newAddress->setNumber($number);
      $newAddress->setComplement($complement);
      $newAddress->setZipcode($zipcode);
      $newAddress->setCity($city);
      $newAddress->setState($state);
      $newAddress->setActive($active);

      $transformObjInArray = json_decode(json_encode($newAddress), true);

      array_push($address, $transformObjInArray);

    }

    return $address;
  }

  public function findById($id) {

    $stmt = $this->conn;

    $st = $stmt->prepare("SELECT * FROM clients_address WHERE id = :id");

    $st->bindValue(":id", $id);

    $st->execute();

    $data = $st->fetch(PDO::FETCH_ASSOC);

    $id = $data['id'];
    $neighborhood = $data['neighborhood'];
    $street = $data['street'];
    $number = $data['number'];
    $complement = $data['complement'];
    $zipcode = $data['zipcode'];
    $city = $data['city'];
    $state = $data['state'];
    $active = $data['active'];
    
    $newAddress = new Address();

    $newAddress->setId($id);
    $newAddress->setNeighborhood($neighborhood);
    $newAddress->setStreet($street);
    $newAddress->setNumber($number);
    $newAddress->setComplement($complement);
    $newAddress->setZipcode($zipcode);
    $newAddress->setCity($city);
    $newAddress->setState($state);
    $newAddress->setActive($active);

    $transformObjInArray = json_decode(json_encode($newAddress), true);

    return $transformObjInArray;
  }
  
  public function update(Address $address) {
   
    $stmt = $this->conn;

    $st = $stmt->prepare("UPDATE clients_address SET neighborhood = :neighborhood, street = :street, number = :number, complement = :complement, zipcode = :zipcode, city = :city, state = :state WHERE id = :id");

    $st->bindValue(":neighborhood", $address->getNeighborhood());
    $st->bindValue(":street", $address->getStreet());
    $st->bindValue(":number", $address->getNumber());
    $st->bindValue(":complement", $address->getComplement());
    $st->bindValue(":zipcode", $address->getZipcode());
    $st->bindValue(":city", $address->getCity());
    $st->bindValue(":state", $address->getState());
    $st->bindValue(":id", $address->getId());

    $st->execute();

    return $this->findById($address->getId());

  }

}