<?php
include("include/connection.php");

$db_name = "hr_3&4_leave_management"; 

if (!isset($connections[$db_name])) {
    die("Database connection not found for $db_name");
}

$connection = $connections[$db_name]; 

// Fetch leave history with employee names and IDs from the correct database
$query_history = "SELECT lh.*, e.EmployeeID, e.FirstName, e.LastName, 
                         COALESCE(lt.LeaveTypeName, 'N/A') AS LeaveTypeName 
                  FROM leaverequests lh
                  JOIN `hr_1&2_new_hire_onboarding_and_employee_self-service`.employees e 
                  ON lh.EmployeeID = e.EmployeeID
                  LEFT JOIN leavetypes lt  
                  ON lh.LeaveTypeID = lt.LeaveTypeID
                  WHERE lh.Status != 'Pending'";



                  
$result_history = mysqli_query($connection, $query_history);

if (!$result_history) {
    die("Query failed: " . mysqli_error($connection));
}





?>



<!DOCTYPE html>
<html lang="en">
<head>                                                
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave History</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='assets/alpha.css' rel='stylesheet'>
</head>
<body>
    <div class="flex min-h-screen w-full">
        <div class="sidebar-overlay" id="sidebar-overlay"></div>

        <?php include('include/sidebar.php');?>
        <?php include('include/header.php');?>

        <main class="px-8 py-8">
        <div class="relative overflow-hidden shadow-md rounded-lg">
    <table class="table-fixed w-full text-left">
        <thead class="uppercase bg-[#594423] text-[#e5e7eb]">
            <tr>
                <th class="py-2 border border-gray-200 text-center font-bold p-4">Employee ID</th>
                <th class="py-2 border border-gray-200 text-center font-bold p-4">Employee Name</th>
                <th class="py-2 border border-gray-200 text-center font-bold p-4">Leave Type</th>
                <th class="py-2 border border-gray-200 text-center font-bold p-4">Leave Name</th>
                <th class="py-2 border border-gray-200 text-center font-bold p-4">Program Name</th>
                <th class="py-2 border border-gray-200 text-center font-bold p-4">Start Date</th>
                <th class="py-2 border border-gray-200 text-center font-bold p-4">End Date</th>
                <th class="py-2 border border-gray-200 text-center font-bold p-4">Status</th>
                <th class="py-2 border border-gray-200 text-center font-bold p-4">Request Date</th>
            </tr>
        </thead>
        <tbody class="bg-white text-[#594423]">
            <?php while ($row = mysqli_fetch_assoc($result_history)) { ?>
                <tr class="hover:bg-gray-100">
                    <td class="py-3 border border-gray-200 text-center p-4"><?php echo htmlspecialchars($row['EmployeeID']); ?></td>
                    <td class="py-3 border border-gray-200 text-center p-4"><?php echo htmlspecialchars($row['FirstName'] . ' ' . $row['LastName']); ?></td>
                    <td class="py-3 border border-gray-200 text-center p-4"><?php echo htmlspecialchars($row['LeaveTypeName']); ?></td>
                    <td class="py-3 border border-gray-200 text-center p-4"><?php echo htmlspecialchars($row['LeaveName']); ?></td>
                    <td class="py-3 border border-gray-200 text-center p-4"><?php echo htmlspecialchars($row['ProgramName']); ?></td>
                    <td class="py-3 border border-gray-200 text-center p-4"><?php echo htmlspecialchars($row['StartDate']); ?></td>
                    <td class="py-3 border border-gray-200 text-center p-4"><?php echo htmlspecialchars($row['EndDate']); ?></td>
                    <td class="py-3 border border-gray-200 text-center p-4"><?php echo htmlspecialchars($row['Status']); ?></td>
                    <td class="py-3 border border-gray-200 text-center p-4"><?php echo htmlspecialchars($row['RequestDate']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

        </main>
    </div>
    <script src="assets/script.js"></script>
</body>
</html>
