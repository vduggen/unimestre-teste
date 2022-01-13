<?php

include_once '../../models/Graduation.php';

class GraduationDAO implements IGraduationDAO {

  private $conn;

  public function __construct($conn) {
    $this->conn = $conn;
  }
  
  public function create(Graduation $graduation) {

    $stmt = $this->conn;

    $st = $stmt->prepare("INSERT INTO clients_graduation (name, company, startMonth, startYear, expire, endMonth, endYear, user) VALUES (:name, :company, :startMonth, :startYear, :expire, :endMonth, :endYear, :user)");

    $st->bindValue(":name", $graduation->getName());
    $st->bindValue(":company", $graduation->getCompany());
    $st->bindValue(":startMonth", $graduation->getStartMonth());
    $st->bindValue(":startYear", $graduation->getStartYear());
    $st->bindValue(":expire", $graduation->getExpire());
    $st->bindValue(":endMonth", $graduation->getEndMonth());
    $st->bindValue(":endYear", $graduation->getEndYear());
    $st->bindValue(":user", $graduation->getUser());

    $st->execute();

    $result = $stmt->lastInsertId();
    
    return $this->findById($result);

  }

  public function findAll() {

    $stmt = $this->conn;
    $graduations = [];

    $st = $stmt->query("SELECT * FROM clients_graduation");

    $data = $st->fetchAll();

    foreach ($data as $key => $value) {

      $id = $value['id'];
      $name = $value['name'];
      $company = $value['company'];
      $startMonth = $value['startMonth'];
      $startYear = $value['startYear'];
      $expire = $value['expire'];
      $endMonth = $value['endMonth'];
      $endYear = $value['endYear'];
      $user = $value['user'];
      $active = $value['active'];
      
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
      $newGraduation->setActive($active);

      $transformObjInArray = json_decode(json_encode($newGraduation), true);

      array_push($graduations, $transformObjInArray);

    }

    return $graduations;
  }
  
  public function findByUser($user) {

    $stmt = $this->conn;

    $st = $stmt->prepare("SELECT * FROM clients_graduation WHERE user = :user");

    $st->bindValue(":user", $user);

    $st->execute();

    $data = $st->fetchAll();

    $graduations = [];

    if ($data) {

      foreach ($data as $key => $value) {

        $id = $value['id'];
        $name = $value['name'];
        $company = $value['company'];
        $startMonth = $value['startMonth'];
        $startYear = $value['startYear'];
        $expire = $value['expire'];
        $endMonth = $value['endMonth'];
        $endYear = $value['endYear'];
        $user = $value['user'];
        $active = $value['active'];
        
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
        $newGraduation->setActive($active);
  
        $transformObjInArray = json_decode(json_encode($newGraduation), true);
  
        array_push($graduations, $transformObjInArray);
  
      }

    }

    return $graduations;
  }

  public function update(Graduation $graduation) {
   
    $stmt = $this->conn;

    $st = $stmt->prepare("UPDATE clients_graduation SET name = :name, company = :company, startMonth = :startMonth, startYear = :startYear, expire = :expire, endMonth = :endMonth, endYear = :endYear, user = :user WHERE id = :id");

    $st->bindValue(":name", $graduation->getName());
    $st->bindValue(":company", $graduation->getCompany());
    $st->bindValue(":startMonth", $graduation->getStartMonth());
    $st->bindValue(":startYear", $graduation->getStartYear());
    $st->bindValue(":expire", $graduation->getExpire());
    $st->bindValue(":endMonth", $graduation->getEndMonth());
    $st->bindValue(":endYear", $graduation->getEndYear());
    $st->bindValue(":user", $graduation->getUser());
    $st->bindValue(":id", $graduation->getId());

    $st->execute();

    return $this->findById($graduation->getId());

  }

  public function delete($id) {
    
    $stmt = $this->conn;

    $st = $stmt->prepare("DELETE FROM clients_graduation WHERE id = :id");

    $st->bindValue(":id", $id);

    $st->execute();

  }
  
  public function findById($id) {

    $stmt = $this->conn;

    $st = $stmt->prepare("SELECT * FROM clients_graduation WHERE id = :id");

    $st->bindValue(":id", $id);

    $st->execute();

    $data = $st->fetch(PDO::FETCH_ASSOC);

    $id = $data['id'];
    $name = $data['name'];
    $company = $data['company'];
    $startMonth = $data['startMonth'];
    $startYear = $data['startYear'];
    $expire = $data['expire'];
    $endMonth = $data['endMonth'];
    $endYear = $data['endYear'];
    $user = $data['user'];
    $active = $data['active'];
    
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
    $newGraduation->setActive($active);

    $transformObjInArray = json_decode(json_encode($newGraduation), true);

    return $transformObjInArray;
  }

}