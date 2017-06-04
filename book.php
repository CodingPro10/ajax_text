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

  $result = $conn->query("CREATE DATABASE IF NOT EXISTS ajax_book");
  $result = $conn->exec("use ajax_book");

  $result = $conn->query(
    "CREATE TABLE IF NOT EXISTS books
    (
      book_id int AUTO_INCREMENT,
      book_author varchar(255),
      book_name varchar(255),
      book_description varchar(1023),
      book_status int,
      PRIMARY KEY(book_id)
    );"
  );

  switch($_SERVER['REQUEST_METHOD']){
    case 'GET': {
      if(isset($_GET['id'])){
        $result = $conn->query("SELECT * FROM books WHERE book_id=".$_GET['id']." LIMIT 1");
        echo json_encode($result->fetch());
      } else {
        $result = $conn->query("SELECT * FROM books");
        echo json_encode($result->fetchAll());
      }
    } break;
    case 'POST': {
      $name = $_POST['name'] ?? false;
      $author = $_POST['author'] ?? false;
      $description = $_POST['description'] ?? false;

      if($name && $author && $description){
        $sql = "INSERT INTO books(book_author, book_name, book_description, book_status) VALUES(:author, :name, :desc, :status)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['author' => $author, 'name' => $name, 'desc' => $description, 'status' => 0]);

        $result = $conn->query("SELECT * FROM books WHERE book_id=".$conn->lastInsertId()." LIMIT 1");
        echo json_encode($result->fetch());
      } else {
        throw new Exception("Brak wszystkich pól");
      }
    } break;
    case 'PUT': {
      //to be implemented
    } break;
    case 'DELETE': {
      //to be implemented
    } break;
  }

//   $sql = "INSERT INTO users(user_name, user_email) VALUES(:name, :email)";
//   $stmt = $conn->prepare($sql);
//   $stmt->execute(['name' => 'name', 'email' => 'name@name']);

//   // Uzyskiwanie dostepu do aktualnie nie uzywanej bazy danych
//   // $result = $conn->query("SELECT information_schema.ENGINES.ENGINE FROM information_schema.ENGINES");

//   $result = $conn->query("SELECT * FROM users");
//   foreach($result as $row) {
//     var_dump($row);
//   }

//   $result = $conn->query("DROP DATABASE test");
} catch (Exception $e) {
  echo "Uwaga: " . $e->getMessage() . "\n";
}

$conn = null;
