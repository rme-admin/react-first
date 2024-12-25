<?php
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
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

$firstName = $conn->real_escape_string($data['firstName']);
$lastName = $conn->real_escape_string($data['lastName']);
$contactNumber = $conn->real_escape_string($data['contactNumber']);
$email = $conn->real_escape_string($data['email']);
$participationType = $conn->real_escape_string($data['participationType']);
$department = $conn->real_escape_string($data['department']);
$courseYear = isset($data['courseYear']) ? $conn->real_escape_string($data['courseYear']) : null;

// Prepare SQL query
$sql = "INSERT INTO registrations (first_name, last_name, contact_number, email, participation_type, department, course_year)
        VALUES ('$firstName', '$lastName', '$contactNumber', '$email', '$participationType', '$department', '$courseYear')";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["message" => "Registration successful"]);
} else {
    echo json_encode(["error" => "Error: " . $conn->error]);
}

$conn->close();
