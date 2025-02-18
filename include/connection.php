
<?php
$server = "localhost"; 
$user = "root";  // Default MySQL user for localhost
$password = "";  // Default password (empty in XAMPP)

// Define the database names in an array
$databases = [
    "hr_1&2_new_hire_onboarding_and_employee_self-service",
    "hr_3&4_leave_management"
];

$connections = []; 

foreach ($databases as $db) {
    $connection = mysqli_connect($server, $user, $password, $db);
    
    if (!$connection) {
        die("Connection failed for $db: " . mysqli_connect_error());
    }

    // Store connection in an array
    $connections[$db] = $connection;
}



?>
