<?php

// header("Content-type:application/json");

$body = $_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT' ? Utils::getBodyData() : '';

 if (isset($_SERVER['HTTP_ORIGIN'])) {
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
  header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
  header('Access-Control-Allow-Credentials: true');
  header('Access-Control-Max-Age: 86400');
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
      header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");

  if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
      header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");

  exit(0);
}

class Utils {

  protected static $configs = array(
    'host' => 'localhost',
    'dbname' => 'unimestre',
    'user' => 'root',
    'password' => ''
  );

  public static function getConnection() {

    $host = self::$configs['host'];
    $dbname = self::$configs['dbname'];
    $user = self::$configs['user'];
    $password = self::$configs['password'];

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    return $conn;
  }

  public static function ReturnSuccess($object, $msg = null, $code = 200) { 

    header("HTTP/1.1 $code");

    print json_encode(array(
      "return" => $object,
      "message" => $msg
    ));

    die();

  }

  public static function getBodyData(){

    $body = file_get_contents('php://input');
    $body = json_decode($body);

    return $body;

  }

}