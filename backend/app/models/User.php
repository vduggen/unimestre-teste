<?php

class User {

  public $id;
  public $document;
  public $password;
  public $person;
  public $active;
  public $hash;

  public function getId() {
    return $this->id;
  }

  public function setId($id) {
    $this->id = $id;
  }

  public function getDocument() {
    return $this->document;
  }

  public function setDocument($document) {
    $this->document = $document;
  }

  public function getPassword() {
    return hash('sha256', $this->password);
  }

  public function setPassword($password) {
    $this->password = $password;
  }

  public function getPerson() {
    return $this->person;
  }

  public function setPerson($person) {
    $this->person = $person;
  }

  public function getActive() {
    return $this->active;
  }

  public function setActive($active) {
    $this->active = $active;
  }

  public function getHash() {
    return $this->hash;
  }

  public function setHash($hash) {
    $this->hash = $hash;
  }

}

interface IUserDAO {

  public function create(User $user);
  public function read($id);
  public function findAll();
  public function findById($id);
  public function findByLogin($document, $password);
  public function findByDocument($document);
  public function findByHash($hash);
  public function update(User $user);

}