<?php

include_once '../../DAO/ExperienceDAO.php';
include_once '../../utils.php';

$conn = Utils::getConnection();
$experienceDAO = new ExperienceDAO($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  $name = $body->name;
  $company = $body->company;
  $startMonth = $body->startMonth;
  $startYear = $body->startYear;
  $expire = $body->expire;
  $endMonth = $body->endMonth;
  $endYear = $body->endYear;
  $user = $body->user;
  $description = $body->description;
  
  $newExperience = new Experience();

  $newExperience->setName($name);
  $newExperience->setCompany($company);
  $newExperience->setStartMonth($startMonth);
  $newExperience->setStartYear($startYear);
  $newExperience->setExpire($expire);
  $newExperience->setEndMonth($endMonth);
  $newExperience->setEndYear($endYear);
  $newExperience->setUser($user);
  $newExperience->setDescription($description);

  $result = $experienceDAO->create($newExperience);

  Utils::ReturnSuccess($result);

}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

  $results = [];

  $id = $body->id;
  $name = $body->name;
  $company = $body->company;
  $startMonth = $body->startMonth;
  $startYear = $body->startYear;
  $expire = $body->expire;
  $endMonth = $body->endMonth;
  $endYear = $body->endYear;
  $user = $body->user;
  $description = $body->description;
  
  $newExperience = new Experience();

  $newExperience->setId($id);
  $newExperience->setName($name);
  $newExperience->setCompany($company);
  $newExperience->setStartMonth($startMonth);
  $newExperience->setStartYear($startYear);
  $newExperience->setExpire($expire);
  $newExperience->setEndMonth($endMonth);
  $newExperience->setEndYear($endYear);
  $newExperience->setUser($user);
  $newExperience->setDescription($description);

  $results = $experienceDAO->update($newExperience);

  Utils::ReturnSuccess($results);
  
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

  $results = [];

  $results = $experienceDAO->delete($_GET['id']);

  Utils::ReturnSuccess($results);
  
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  $results = [];


  if (isset($_GET['user'])) {

    $results = $experienceDAO->findByUser($_GET['user']);

  } else {

    $results = $experienceDAO->findAll();

  }

  Utils::ReturnSuccess($results);
  
}