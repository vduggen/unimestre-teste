<?php

include_once '../../models/Experience.php';

class ExperienceDAO implements IExperienceDAO {

  private $conn;

  public function __construct($conn) {
    $this->conn = $conn;
  }
  
  public function create(Experience $experience) {

    $stmt = $this->conn;

    $st = $stmt->prepare("INSERT INTO clients_experience (name, company, startMonth, startYear, expire, endMonth, endYear, user, description) VALUES (:name, :company, :startMonth, :startYear, :expire, :endMonth, :endYear, :user, :description)");

    $st->bindValue(":name", $experience->getName());
    $st->bindValue(":company", $experience->getCompany());
    $st->bindValue(":startMonth", $experience->getStartMonth());
    $st->bindValue(":startYear", $experience->getStartYear());
    $st->bindValue(":expire", $experience->getExpire());
    $st->bindValue(":endMonth", $experience->getEndMonth());
    $st->bindValue(":endYear", $experience->getEndYear());
    $st->bindValue(":user", $experience->getUser());
    $st->bindValue(":description", $experience->getDescription());

    $st->execute();

    $result = $stmt->lastInsertId();
    
    return $this->findById($result);

  }

  public function findAll() {

    $stmt = $this->conn;
    $experiences = [];

    $st = $stmt->query("SELECT * FROM clients_experience");

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
      $description = $value['description'];
      $active = $value['active'];
      
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
      $newExperience->setActive($active);

      $transformObjInArray = json_decode(json_encode($newExperience), true);

      array_push($experiences, $transformObjInArray);

    }

    return $experiences;
  }

  public function update(Experience $experience) {
   
    $stmt = $this->conn;

    $st = $stmt->prepare("UPDATE clients_experience SET name = :name, company = :company, startMonth = :startMonth, startYear = :startYear, expire = :expire, endMonth = :endMonth, endYear = :endYear, description = :description WHERE id = :id");

    $st->bindValue(":name", $experience->getName());
    $st->bindValue(":company", $experience->getCompany());
    $st->bindValue(":startMonth", $experience->getStartMonth());
    $st->bindValue(":startYear", $experience->getStartYear());
    $st->bindValue(":expire", $experience->getExpire());
    $st->bindValue(":endMonth", $experience->getEndMonth());
    $st->bindValue(":endYear", $experience->getEndYear());
    $st->bindValue(":description", $experience->getDescription());
    $st->bindValue(":id", $experience->getId());

    $st->execute();

    return $this->findById($experience->getId());

  }

  public function delete($id) {
    
    $stmt = $this->conn;

    $st = $stmt->prepare("DELETE FROM clients_experience WHERE id = :id");

    $st->bindValue(":id", $id);

    $st->execute();

  }
   
  public function findById($id) {

    $stmt = $this->conn;

    $st = $stmt->prepare("SELECT * FROM clients_experience WHERE id = :id");

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
    $description = $data['description'];
    $active = $data['active'];
    
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
    $newExperience->setActive($active);

    $transformObjInArray = json_decode(json_encode($newExperience), true);

    return $transformObjInArray;
  }

  public function findByUser($user) {

    $stmt = $this->conn;

    $st = $stmt->prepare("SELECT * FROM clients_experience WHERE user = :user");

    $st->bindValue(":user", $user);

    $st->execute();

    $data = $st->fetchAll();

    $experiences = [];

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
        $description = $value['description'];
        $active = $value['active'];
        
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
        $newExperience->setActive($active);
    
        $transformObjInArray = json_decode(json_encode($newExperience), true);
  
        array_push($experiences, $transformObjInArray);
  
      }

    }

    return $experiences;
  }


}