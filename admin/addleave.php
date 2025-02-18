<?php
include("include/connection.php");

// Define the database name
$db_name = "hr_3&4_leave_management";

if (!isset($connections[$db_name])) {
    die("Database connection not found for $db_name");
}

$connection = $connections[$db_name]; 

// Handle form submission (Add Leave Type)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $leave_name = $_POST['leave_name'];
    $description = $_POST['description'];
    $max_days_allowed = $_POST['max_days_allowed'];

    // Insert Query
    $query = "INSERT INTO `leavetypes` (LeaveTypeName, Description, MaxDaysAllowed) 
              VALUES ('$leave_name', '$description', '$max_days_allowed')";

    if (mysqli_query($connection, $query)) {
        echo "<script>alert('Leave type added successfully!'); window.location.href='addleave.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($connection) . "');</script>";
    }
}

// Handle Delete Request
if (isset($_GET['delete'])) {
    $leave_id = intval($_GET['delete']); // Prevent SQL Injection
    $delete_query = "DELETE FROM `leavetypes` WHERE LeaveTypeID = $leave_id";
    if (mysqli_query($connection, $delete_query)) {
        echo "<script>alert('Leave type deleted successfully!'); window.location.href='addleave.php';</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($connection) . "');</script>";
    }
}

// Fetch Leave Types
$query_fetch = "SELECT * FROM `leavetypes`";
$result = mysqli_query($connection, $query_fetch);
?>

<!DOCTYPE html>
<html lang="en">
<head>                                               
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Leave Types</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href='assets/alpha.css' rel='stylesheet'>
</head>
<body>
    <div class="flex min-h-screen w-full">
        <?php include('include/sidebar.php');?>
        <?php include('include/header.php');?>

        <main class="px-8 py-8">
        <div class="mt-5 space-y-6">
    <!-- Add Leave Form -->
    <div>

    <h2 class="text-lg font-bold mb-3 text-[#4E3B2A]">ADD LEAVE TYPES</h2>
        <div class="bg-[#F7E6CA] shadow-lg rounded-lg p-4 max-w-sm mx-auto">
            <form method="POST">
                <div class="mb-3">
                    <label class="block text-[#4E3B2A] font-semibold text-sm mb-1">Leave Type:</label>
                    <input type="text" class="w-full px-3 py-1 border border-[#D6C5A0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#594423]" name="leave_name" required>
                </div>
                <div class="mb-3">
                    <label class="block text-[#4E3B2A] font-semibold text-sm mb-1">Description:</label>
                    <input type="text" class="w-full px-3 py-1 border border-[#D6C5A0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#594423]" name="description" required>
                </div>
                <div class="mb-3">
                    <label class="block text-[#4E3B2A] font-semibold text-sm mb-1">Max Days Allowed:</label>
                    <input type="text" class="w-full px-3 py-1 border border-[#D6C5A0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#594423]" name="max_days_allowed" required>
                </div>
                <button type="submit" class="w-full bg-[#594423] text-white py-1 px-4 rounded-lg hover:bg-[#4E3B2A]">Apply</button>
            </form>
        </div>
    </div>
    
    <!-- Manage Leave Types Table -->
    <div>
        <h2 class="text-lg font-bold mb-3 text-[#4E3B2A]">MANAGE LEAVE TYPES</h2>
        <div class="relative overflow-hidden shadow-md rounded-lg">
            <table class="table-auto w-full text-center border-collapse border border-gray-300">
                <thead class="uppercase bg-[#594423] text-[#e5e7eb]">
                    <tr>
                        <th class="py-2 border border-gray-200 p-4">Leave Type ID</th>
                        <th class="py-2 border border-gray-200 p-4">Leave Type Name</th>
                        <th class="py-2 border border-gray-200 p-4">Description</th>
                        <th class="py-2 border border-gray-200 p-4">Max Days Allowed</th>
                        <th class="py-2 border border-gray-200 p-4">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white  text-[#4E3B2A]">
                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                        <tr class="hover:bg-gray-100">
                            <td class="py-3 border border-gray-200 p-4"><?php echo htmlspecialchars($row['LeaveTypeID']); ?></td>
                            <td class="py-3 border border-gray-200 p-4"><?php echo htmlspecialchars($row['LeaveTypeName']); ?></td>
                            <td class="py-3 border border-gray-200 p-4"><?php echo htmlspecialchars($row['Description']); ?></td>
                            <td class="py-3 border border-gray-200 p-4"><?php echo htmlspecialchars($row['MaxDaysAllowed']); ?></td>
                            <td class="py-3 border border-gray-200 p-4">
                                <a href="?delete=<?php echo $row['LeaveTypeID']; ?>" 
                                   onclick="return confirm('Are you sure you want to delete this leave type?');" 
                                   class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-700">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>





            
        </main>
    </div>
    <script src="assets/script.js"></script>
</body>
</html>
