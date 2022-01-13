<?php

class Address {

  public $id;
  public $neighborhood;
  public $street;
  public $number;
  public $complement;
  public $zipcode;
  public $city;
  public $state;
  public $active;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getNeighborhood() {
    return $this->neighborhood;
  }

  public function setNeighborhood($neighborhood) {
    $this->neighborhood = $neighborhood;
  }

  public function getStreet() {
    return $this->street;
  }

  public function setStreet($street) {
    $this->street = $street;
  }

  public function getNumber() {
    return $this->number;
  }

  public function setNumber($number) {
    $this->number = $number;
  }

  public function getComplement() {
    return $this->complement;
  }

  public function setComplement($complement) {
    $this->complement = $complement;
  }

  public function getZipcode() {
    return $this->zipcode;
  }

  public function setZipcode($zipcode) {
    $this->zipcode = $zipcode;
  }

  public function getCity() {
    return $this->city;
  }

  public function setCity($city) {
    $this->city = $city;
  }

  public function getState() {
    return $this->state;
  }

  public function setState($state) {
    $this->state = $state;
  }

  public function getActive() {
    return $this->active;
  }

  public function setActive($active) {
    $this->active = $active;
  }

}

interface IAddressDAO {

  public function create(Address $address);
  public function findAll();
  public function findById($id);
  public function update(Address $address);

}