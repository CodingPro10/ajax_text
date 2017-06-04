<?php
$host = "127.0.0.1";
$user = "root";
$pass = "1234";

$conn = null;

try {
  $conn = new PDO("mysql:host=$host", $user, $pass, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ]);

  $result = $conn->query("CREATE DATABASE IF NOT EXISTS test");
  $result = $conn->exec("use test");

  $result = $conn->query(
    "CREATE TABLE IF NOT EXISTS users
    (
      user_id int AUTO_INCREMENT,
      user_name varchar(255),
      user_email varchar(255) UNIQUE,
      PRIMARY KEY(user_id)
    );"
  );

  $sql = "INSERT INTO users(user_name, user_email) VALUES(:name, :email)";
  $stmt = $conn->prepare($sql);
  $stmt->execute(['name' => 'name', 'email' => 'name@name']);

  // Uzyskiwanie dostepu do aktualnie nie uzywanej bazy danych
  // $result = $conn->query("SELECT information_schema.ENGINES.ENGINE FROM information_schema.ENGINES");

  $result = $conn->query("SELECT * FROM users");
  foreach($result as $row) {
    var_dump($row);
  }

  $result = $conn->query("DROP DATABASE test");
} catch (Exception $e) {
  echo "Uwaga: " . $e->getMessage() . "\n";
}

$conn = null;
