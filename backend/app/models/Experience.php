<?php

class Experience {

  public $id;
  public $name;
  public $company;
  public $startMonth;
  public $startYear;
  public $expire;
  public $endMonth;
  public $endYear;
  public $user;
  public $description;
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

  public function getCompany() {
    return $this->company;
  }

  public function setCompany($company) {
    $this->company = $company;
  }

  public function getStartMonth() {
    return $this->startMonth;
  }

  public function setStartMonth($startMonth) {
    $this->startMonth = $startMonth;
  }

  public function getStartYear() {
    return $this->startYear;
  }

  public function setStartYear($startYear) {
    $this->startYear = $startYear;
  }

  public function getExpire() {
    return $this->expire;
  }

  public function setExpire($expire) {
    $this->expire = $expire;
  }

  public function getEndMonth() {
    return $this->endMonth;
  }

  public function setEndMonth($endMonth) {
    $this->endMonth = $endMonth;
  }

  public function getEndYear() {
    return $this->endYear;
  }

  public function setEndYear($endYear) {
    $this->endYear = $endYear;
  }

  public function getUser() {
    return $this->user;
  }

  public function setUser($user) {
    $this->user = $user;
  }

  public function getDescription() {
    return $this->description;
  }

  public function setDescription($description) {
    $this->description = $description;
  }

  public function getActive() {
    return $this->active;
  }

  public function setActive($active) {
    $this->active = $active;
  }

}

interface IExperienceDAO {

  public function create(Experience $experience);
  public function findAll();
  public function findById($id);
  public function findByUser($user);
  public function update(Experience $experience);
  public function delete($id);

}