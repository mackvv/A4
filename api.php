<?php
// Fetch environment variables
$serverName = getenv('A4');
$database = getenv('A4');
$username = getenv('A4');
$password = getenv('Test1234!');

// Establish database connection
try {
    $conn = new PDO("sqlsrv:server=$serverName;Database=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle GET requests
$action = $_GET['action'] ?? null;

if ($action === 'read') {
    try {
        $stmt = $conn->query("SELECT * FROM Patients");
        $patients = $stmt->fetchAll(PDO::FETCH_ASSOC);
        header('Content-Type: application/json');
        echo json_encode($patients);
    } catch (PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
} elseif ($action === 'delete') {
    $id = $_GET['id'] ?? null;
    if ($id) {
        try {
            $stmt = $conn->prepare("DELETE FROM Patients WHERE id = :id");
            $stmt->execute(['id' => $id]);
            echo json_encode(['message' => "Record with id $id deleted successfully."]);
        } catch (PDOException $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    } else {
        http_response_code(400);
        echo json_encode(['error' => 'Missing id parameter.']);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid action.']);
}
?>
