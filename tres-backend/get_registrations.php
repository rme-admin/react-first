<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

include_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if the action is 'download'
    if (isset($_GET['action']) && $_GET['action'] === 'download') {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="registrations.xls"');

        $sql = "SELECT * FROM registrations";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Print column headers
            echo "ID\tFirst Name\tLast Name\tContact Number\tEmail\tParticipation Type\tDepartment\tCourse Year\n";

            // Print rows
            while ($row = $result->fetch_assoc()) {
                echo $row['id'] . "\t" .
                     $row['first_name'] . "\t" .
                     $row['last_name'] . "\t" .
                     $row['contact_number'] . "\t" .
                     $row['email'] . "\t" .
                     $row['participation_type'] . "\t" .
                     $row['department'] . "\t" .
                     ($row['course_year'] ?: "N/A") . "\n";
            }
        } else {
            echo "No registrations found.";
        }
        exit; // End the script to avoid additional output
    }

    // Default action: Fetch registrations as JSON
    $sql = "SELECT * FROM registrations";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $registrations = [];
        while ($row = $result->fetch_assoc()) {
            $registrations[] = $row;
        }
        echo json_encode($registrations);
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode(["error" => "Invalid request method."]);
}
?>
