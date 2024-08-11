<!-- connection.php -->
<?php 
    $database  = 'mysql:host=localhost; dbname=twitter';   // database name
    $user = 'root';
    $pass = '';
    try {
        $pdo = new PDO($database, $user, $pass);
        // echo "database connected successfully";
    } catch(PDOException $e) {
        echo 'Connection error! '. $e->getMessage();
    }
?>
