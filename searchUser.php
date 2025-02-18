 <?php
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

if (isset($_POST['query'])) {
    $searchQuery = trim($_POST['query']);

    // Prevent SQL Injection
    $stmt = $conn->prepare("SELECT name, email, profile_picture, unique_number FROM users_table WHERE name LIKE ?");
    $searchTerm = "%$searchQuery%";
    $stmt->bindValue(1, $searchTerm, PDO::PARAM_STR);
    $stmt->execute();

    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($result) > 0) {
        foreach ($result as $row) {
            echo '<div class="search-result-item">';
            echo '<img src="uploads/' . htmlspecialchars($row['profile_picture']) . '" alt="Profile Picture">';
            echo '<p><strong>Name:</strong> ' . htmlspecialchars($row['name']) . '</p>';
            echo '<p><strong>Email:</strong> ' . htmlspecialchars($row['email']) . '</p>';
            echo '<p><strong>UN:</strong> <h1 style="display: inline; color: red; font-size: 24px;">' . htmlspecialchars($row['unique_number']) . '</h1></p>';
            echo '<button class="follow-button" style="background-color: blue; color: white; padding: 10px 20px; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">+</button>';
            echo '</div>';
        }
    } else {
        echo "<p>No results found</p>";
    }
}
?>
