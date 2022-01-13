<?php

class Person {

  public $id;
  public $name;
  public $document;
  public $email;
  public $birth;
  public $gender;
  public $address;
  public $active;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getName() {
    return $this->name;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public function getDocument() {
    return $this->document;
  }

  public function setDocument($document) {
    $this->document = $document;
  }

  public function getEmail() {
    return $this->email;
  }

  public function setEmail($email) {
    $this->email = $email;
  }

  public function getBirth() {
    return $this->birth;
  }

  public function setBirth($birth) {
    $this->birth = $birth;
  }

  public function getGender() {
    return $this->gender;
  }

  public function setGender($gender) {
    $this->gender = $gender;
  }

  public function getAddress() {
    return $this->address;
  }

  public function setAddress($address) {
    $this->address = $address;
  }

  public function getActive() {
    return $this->active;
  }

  public function setActive($active) {
    $this->active = $active;
  }

}

interface IPersonDAO {

  public function create(Person $person);
  public function findAll();
  public function findById($id);
  public function update(Person $person);

}