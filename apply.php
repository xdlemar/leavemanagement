<?php
include("include/connection.php");


$db_name = "hr_3&4_leave_management";
$db_employees = "hr_1&2_new_hire_onboarding_and_employee_self-service"; 

if (!isset($connections[$db_name]) || !isset($connections[$db_employees])) {
    die("Database connections not found!");
}

$connection = $connections[$db_name]; 
$connection_employees = $connections[$db_employees];


$query_leave_types = "SELECT LeaveTypeID, LeaveTypeName FROM `leavetypes`"; 
$result_leave_types = mysqli_query($connection, $query_leave_types);

if (!$result_leave_types) {
    die("Query failed: " . mysqli_error($connection));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = mysqli_real_escape_string($connection, $_POST['employee_id']);
    $program_name = mysqli_real_escape_string($connection, $_POST['program_name']);
    $leave_type_id = mysqli_real_escape_string($connection, $_POST['leave_type_id']);
    $leave_name = mysqli_real_escape_string($connection, $_POST['leave_name']);
    $start_date = new DateTime($_POST['start_date']);
    $end_date = new DateTime($_POST['end_date']);
    $status = 'Pending';

   
    $query_check_employee = "SELECT * FROM `$db_employees`.`employees` WHERE EmployeeID='$employee_id'";
    $result_check_employee = mysqli_query($connection_employees, $query_check_employee);

    if (mysqli_num_rows($result_check_employee) == 0) {
        echo "<script>alert('Invalid Employee ID: No record found in the employees database.'); window.location.href='apply.php';</script>";
        exit();
    }


    $requested_days = $start_date->diff($end_date)->days + 1;

    $query_check_balance = "SELECT RemainingDays FROM leavebalances WHERE EmployeeID='$employee_id' AND LeaveTypeID='$leave_type_id'";
    $result_check_balance = mysqli_query($connection, $query_check_balance);
    $leave_balance = mysqli_fetch_assoc($result_check_balance);

    if ($leave_balance) {
        $remaining_days = $leave_balance['RemainingDays'];

       
        if ($requested_days > $remaining_days) {
            echo "<script>alert('Leave request denied: You requested $requested_days days, but only $remaining_days days are available for this leave type.'); window.location.href='apply.php';</script>";
            exit();
        }
    } else {
     
        $query_max_days = "SELECT MaxDaysAllowed FROM leavetypes WHERE LeaveTypeID='$leave_type_id'";
        $result_max_days = mysqli_query($connection, $query_max_days);
        $max_days_data = mysqli_fetch_assoc($result_max_days);
        $max_days_allowed = $max_days_data['MaxDaysAllowed'];

        if ($requested_days > $max_days_allowed) {
            echo "<script>alert('Leave request denied: You requested $requested_days days, but only $max_days_allowed days are available for this leave type.'); window.location.href='apply.php';</script>";
            exit();
        }
    }


    $insert_query = "INSERT INTO leaverequests (LeaveName, EmployeeID, ProgramName, LeaveTypeID, StartDate, EndDate, Status, RequestDate) 
                     VALUES ('$leave_name', '$employee_id', '$program_name', '$leave_type_id', '{$_POST['start_date']}', '{$_POST['end_date']}', '$status', NOW())";

    if (mysqli_query($connection, $insert_query)) {
        echo "<script>alert('Leave request submitted successfully.'); window.location.href='apply.php';</script>";
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}
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
        <div class="mt-5 space-y-6">
    <!-- Apply for Leave Form -->
    <div>
    <h2 class="text-xl font-extrabold mb-4 text-[#4E3B2A] drop-shadow-xl">Apply For Leave</h2>
        <div class="bg-[#F7E6CA] shadow-lg rounded-lg p-4 max-w-sm mx-auto">
            <form method="POST">
                <div class="mb-3">
                    <label class="block text-[#4E3B2A] font-semibold text-sm mb-1">Employee ID:</label>
                    <input type="text" class="w-full px-3 py-1 border border-[#D6C5A0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#594423]" name="employee_id" required placeholder="Enter your Employee ID">
                </div>
                <div class="mb-3">
                    <label class="block text-[#4E3B2A] font-semibold text-sm mb-1">Leave Name:</label>
                    <input type="text" class="w-full px-3 py-1 border border-[#D6C5A0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#594423]" name="leave_name" required>
                </div>
                <div class="mb-3">
                    <label class="block text-[#4E3B2A] font-semibold text-sm mb-1">Program Name:</label>
                    <input type="text" class="w-full px-3 py-1 border border-[#D6C5A0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#594423]" name="program_name" required>
                </div>
                <div class="mb-3">
                    <label class="block text-[#4E3B2A] font-semibold text-sm mb-1">Leave Type:</label>
                    <select class="w-full px-3 py-1 border border-[#D6C5A0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#594423]" name="leave_type_id" required>
                        <option value="">-- Select Leave Type --</option>
                        <?php
                        while ($row = mysqli_fetch_assoc($result_leave_types)) {
                            echo "<option value='{$row['LeaveTypeID']}'>{$row['LeaveTypeName']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-[#4E3B2A] font-semibold text-sm mb-1">Start Date:</label>
                    <input type="date" class="w-full px-3 py-1 border border-[#D6C5A0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#594423]" name="start_date" required>
                </div>
                <div class="mb-3">
                    <label class="block text-[#4E3B2A] font-semibold text-sm mb-1">End Date:</label>
                    <input type="date" class="w-full px-3 py-1 border border-[#D6C5A0] rounded-lg focus:outline-none focus:ring-2 focus:ring-[#594423]" name="end_date" required>
                </div>
                <button type="submit" class="w-full bg-[#594423] text-white py-1 px-4 rounded-lg hover:bg-[#4E3B2A]">Submit Leave Request</button>
            </form>
        </div>
    </div>
</div>
        </main>
    </div>

    <script src="assets/script.js"></script>
</body>
</html>
