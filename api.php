
<?php
try {
   $serverName = getenv('a4.database.windows.net');
$database = getenv('Patients');
$username = getenv('A4');
$password = getenv('Test1234!');

    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connection successful!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
