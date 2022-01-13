<?php

include_once '../../DAO/GraduationDAO.php';
include_once '../../utils.php';

$conn = Utils::getConnection();
$graduationDAO = new GraduationDAO($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $name = $body->name;
  $company = $body->company;
  $startMonth = $body->startMonth;
  $startYear = $body->startYear;
  $expire = $body->expire;
  $endMonth = $body->endMonth;
  $endYear = $body->endYear;
  $user = $body->user;
  
  $newGraduation = new Graduation();
  $newGraduation->setName($name);
  $newGraduation->setCompany($company);
  $newGraduation->setStartMonth($startMonth);
  $newGraduation->setStartYear($startYear);
  $newGraduation->setExpire($expire);
  $newGraduation->setEndMonth($endMonth);
  $newGraduation->setEndYear($endYear);
  $newGraduation->setUser($user);
  
  $result = $graduationDAO->create($newGraduation);

  Utils::ReturnSuccess($result);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

  $results = [];

  if (isset($_GET['user'])) {

    $results = $graduationDAO->findByUser($_GET['user']);

  } else {

    $results = $graduationDAO->findAll();

  }

  Utils::ReturnSuccess($results);
  
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
  
  $newGraduation = new Graduation();
  $newGraduation->setId($id);
  $newGraduation->setName($name);
  $newGraduation->setCompany($company);
  $newGraduation->setStartMonth($startMonth);
  $newGraduation->setStartYear($startYear);
  $newGraduation->setExpire($expire);
  $newGraduation->setEndMonth($endMonth);
  $newGraduation->setEndYear($endYear);
  $newGraduation->setUser($user);
  
  $results = $graduationDAO->update($newGraduation);

  Utils::ReturnSuccess($results);
  
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

  $results = [];
  
  $graduationDAO->delete($_GET['id']);

  Utils::ReturnSuccess($results);
  
}