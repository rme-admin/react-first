<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Only POST requests are allowed."]);
    exit();
}

// Connect to the database
$conn = new mysqli("localhost", "root", "", "treasure_hunt");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data
$data = json_decode(file_get_contents("php://input"), true);

$username = $conn->real_escape_string($data['username']);
$password = $data['password'];

// Query the admins table
$sql = "SELECT * FROM admins WHERE username = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    // Verify password
    if (password_verify($password, $admin['password'])) {
        echo json_encode(["message" => "Login successful"]);
    } else {
        echo json_encode(["error" => "Invalid password"]);
    }
} else {
    echo json_encode(["error" => "Admin not found"]);
}

$conn->close();
?>
