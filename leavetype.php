<?php
include("include/connection.php");

// Define the database name
$db_name = "hr_3&4_leave_management";

if (!isset($connections[$db_name])) {
    die("Database connection not found for $db_name");
}

$connection = $connections[$db_name];

// Fetch only the required columns
$query_fetch = "SELECT LeaveTypeID, LeaveTypeName, Description, MaxDaysAllowed FROM leavetypes";
$result = mysqli_query($connection, $query_fetch);
?>

<!DOCTYPE html>
<html lang="en">
<head>                                               
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for Leave</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='assets/alpha.css' rel='stylesheet'>
</head>

<body>

    <div class="flex min-h-screen w-full">

        <!-- Overlay -->
        <div class="sidebar-overlay" id="sidebar-overlay"></div>

        <!-- Sidebar -->
        <?php include('include/sidebar.php');?>  

        <!-- Navbar -->
        <?php include('include/header.php');?>  

        <!-- Main Content -->
        <main class="px-8 py-8">
        <h2 class="text-lg font-bold mb-3 text-[#4E3B2A]">Leave Types</h2>
            <div class="relative overflow-hidden shadow-md rounded-lg">
                <table class="table-auto w-full text-center border-collapse border border-gray-300">
                    <thead class="uppercase bg-[#594423] text-[#e5e7eb]">
                        <tr>
                            <th class="py-2 border border-gray-200 p-4">Leave Type ID</th>
                            <th class="py-2 border border-gray-200 p-4">Leave Type Name</th>
                            <th class="py-2 border border-gray-200 p-4">Description</th>
                            <th class="py-2 border border-gray-200 p-4">Max Days Allowed</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white text-[#4E3B2A]">
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr class="hover:bg-gray-100">
                                <td class="py-3 border border-gray-200 p-4"><?php echo htmlspecialchars($row['LeaveTypeID']); ?></td>
                                <td class="py-3 border border-gray-200 p-4"><?php echo htmlspecialchars($row['LeaveTypeName']); ?></td>
                                <td class="py-3 border border-gray-200 p-4"><?php echo htmlspecialchars($row['Description']); ?></td>
                                <td class="py-3 border border-gray-200 p-4"><?php echo htmlspecialchars($row['MaxDaysAllowed']); ?></td>
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

