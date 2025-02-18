
<?php
// Database configuration
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $profilePicture = $_FILES['profile_picture'] ?? null;
    $user_location = $_POST['user_location'] ?? '';

    // Validation
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword) || !$profilePicture) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
        exit;
    }

    if ($password !== $confirmPassword) {
        echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
        exit;
    } 

    // File upload
    $uploadDir = 'uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = uniqid() . '_' . basename($profilePicture['name']);
    $targetFilePath = $uploadDir . $fileName;

    if (!move_uploaded_file($profilePicture['tmp_name'], $targetFilePath)) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to upload profile picture.']);
        exit;
    }

    try {
        $stmt = $conn->prepare("INSERT INTO users_table (Name, unique_number, email, password, profile_picture, created_at, location) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $uniqueNumber = $conn->query("SELECT COUNT(*) FROM users_table")->fetchColumn() + 1;
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $createdAt = date('Y-m-d H:i:s');

        $stmt->execute([$username, $uniqueNumber, $email, $hashedPassword, $fileName, $createdAt, $user_location]);

        // Set cookies before any output
        setcookie("username", $username, time() + (86400 * 30), "/");  
        setcookie("profile_picture", $fileName, time() + (86400 * 30), "/");
        setcookie("unique_number", $uniqueNumber, time() + (86400 * 30), "/");
        setcookie("user_location", $user_location, time() + (86400 * 30), "/");
        setcookie("email", $email, time() + (86400 * 30), "/");

        echo json_encode(['status' => 'success', 'message' => 'User registered successfully.', 'data' => [
            'name' => $username,
            'email' => $email,
            'profile_picture' => $fileName,
            'unique_number' => $uniqueNumber,
            'location' => $user_location
        ]]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
