<?php
// Database connection (replace with your credentials)
$host = 'localhost';
$dbname = 'vaikuntha';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['status' => 'error', 'message' => 'Database connection failed.']));
}

// Get user ID (you'll need to store this in a cookie or session)
$userId = $_COOKIE["username"]; // Or however you identify the user

// Determine request type (sent or received)
$requestType = $_GET["type"]; // e.g., ?type=sent or ?type=received

if ($requestType === "sent") {
    $sql = "SELECT r.to_user_id, u.username FROM requests r
            INNER JOIN users u ON r.to_user_id = u.id
            WHERE r.from_user_id = $userId";
} else if ($requestType === "received") {
    $sql = "SELECT r.from_user_id, u.username FROM requests r
            INNER JOIN users u ON r.from_user_id = u.id
            WHERE r.to_user_id = $userId";
} else {
    die(json_encode(["status" => "error", "message" => "Invalid request type"]));
}

$result = $conn->query($sql);
$requests = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $requests[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode(["status" => "success", "requests" => $requests]);

$conn->close();
?>