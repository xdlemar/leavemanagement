<?php 
include("include/connection.php");

// Define database name
$db_name = "hr_3&4_leave_management"; 

if (!isset($connections[$db_name])) {
    die("Database connection not found for $db_name");
}

$connection = $connections[$db_name];

$employee_id = "";
$leave_options = "";
$leave_data = "";

// Handle form submission
if (isset($_POST['search_leave'])) {
    $employee_id = $_POST['employee_id'];
    $leave_type_id = $_POST['leave_type_id'];

    // Fetch leave balance with leave type name
    $query = "SELECT lb.EmployeeID, lb.EmployeeName, lt.LeaveTypeName, lb.RemainingDays 
              FROM leavebalances lb
              JOIN leavetypes lt ON lb.LeaveTypeID = lt.LeaveTypeID
              WHERE lb.EmployeeID = '$employee_id' AND lb.LeaveTypeID = '$leave_type_id'";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $leave_data .= "<tr>
                            <td class='border px-4 py-2'>{$row['EmployeeID']}</td>
                            <td class='border px-4 py-2'>{$row['EmployeeName']}</td>
                            <td class='border px-4 py-2'>{$row['LeaveTypeName']}</td>
                            <td class='border px-4 py-2'>{$row['RemainingDays']}</td>
                        </tr>";
        }
    } else {
        $leave_data = "<tr><td colspan='4' class='border px-4 py-2 text-center'>No records found</td></tr>";
    }
}

// Fetch leave types for dropdown
$leave_query = "SELECT LeaveTypeID, LeaveTypeName FROM leavetypes";
$leave_result = mysqli_query($connection, $leave_query);
$leave_options = "";
while ($leave_row = mysqli_fetch_assoc($leave_result)) {
    $leave_options .= "<option value='{$leave_row['LeaveTypeID']}'>{$leave_row['LeaveTypeName']}</option>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>                                               
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LEAVE BALANCE</title>
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
            

        <div class="max-w-lg mx-auto p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-xl font-extrabold mb-4 text-[#4E3B2A]">Check Leave Balance</h2>

                <!-- Employee Leave Check Form -->
                <form method="POST">
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Employee ID:</label>
                    <input type="text" name="employee_id" class="w-full px-3 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#594423]" value="<?= $employee_id ?>" required>

                    <label class="block text-sm font-semibold text-gray-700 mb-1 mt-3">Leave Type:</label>
                    <select name="leave_type_id" class="w-full px-3 py-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#594423]" required>
                        <option value="">Select Leave Type</option>
                        <?= $leave_options ?>
                    </select>

                    <button type="submit" name="search_leave" class="mt-3 w-full bg-[#594423] text-white py-2 px-4 rounded-lg hover:bg-[#4E3B2A]">Check Leave Balance</button>
                </form>
            </div>

            
               
                <?php if ($leave_data): ?>
    <div class="form-container mt-6">
        <h2 class="text-xl font-extrabold mb-4 text-[#4E3B2A]">Leave Balance Result</h2>
        <table class="table-auto w-full text-center border-collapse border border-gray-300 rounded-lg overflow-hidden shadow-md">
            <thead class="uppercase bg-[#594423] text-[#e5e7eb]">
                <tr>
                    <th class="py-2 border border-gray-200 p-4">Employee ID</th>
                    <th class="py-2 border border-gray-200 p-4">Employee Name</th>
                    <th class="py-2 border border-gray-200 p-4">Leave Type</th>
                    <th class="py-2 border border-gray-200 p-4">Remaining Days</th>
                </tr>
            </thead>
            <tbody class="bg-white text-[#594423]">
                <?= $leave_data ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

            




        </main>
    </div>

    <script src="assets/script.js"></script>
</body>
</html>
