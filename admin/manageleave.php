<?php
include("include/connection.php");

$db_name = "hr_3&4_leave_management";

if (!isset($connections[$db_name])) {
    die("Database connection not found for $db_name");
}

$connection = $connections[$db_name];

// Fetch leave requests
$query_requests = "SELECT lh.*, e.EmployeeID, e.FirstName, e.LastName, lt.LeaveTypeName 
                  FROM leaverequests lh
                  JOIN `hr_1&2_new_hire_onboarding_and_employee_self-service`.employees e 
                  ON lh.EmployeeID = e.EmployeeID
                  JOIN leavetypes lt 
                  ON lh.LeaveTypeID = lt.LeaveTypeID
                  WHERE lh.Status = 'Pending'";

$result_requests = mysqli_query($connection, $query_requests);

if (!$result_requests) {
    die("Query failed: " . mysqli_error($connection));
}

// Handle Approve/Reject actions
if (isset($_GET['approve'])) {
    $request_id = mysqli_real_escape_string($connection, $_GET['approve']);

    // Fetch leave request details
    $query_request = "SELECT * FROM leaverequests WHERE RequestID='$request_id'";
    $result_request = mysqli_query($connection, $query_request);
    $leave_data = mysqli_fetch_assoc($result_request);

    $employee_id = $leave_data['EmployeeID'];
    $leave_type_id = $leave_data['LeaveTypeID'];
    $leave_name = $leave_data['LeaveName'];
    $start_date = new DateTime($leave_data['StartDate']);
    $end_date = new DateTime($leave_data['EndDate']);

  
    $requested_days = $start_date->diff($end_date)->days + 1; 

   
    $query_max_days = "SELECT MaxDaysAllowed FROM leavetypes WHERE LeaveTypeID='$leave_type_id'";
    $result_max_days = mysqli_query($connection, $query_max_days);
    $max_days_data = mysqli_fetch_assoc($result_max_days);
    $max_days_allowed = $max_days_data['MaxDaysAllowed'];

  
    $query_check_balance = "SELECT RemainingDays FROM leavebalances WHERE EmployeeID='$employee_id' AND LeaveTypeID='$leave_type_id'";
    $result_check_balance = mysqli_query($connection, $query_check_balance);
    $leave_balance = mysqli_fetch_assoc($result_check_balance);

   
    if ($leave_balance && $leave_balance['RemainingDays'] <= 0) {
        echo "<script>alert('Leave request denied: No remaining balance for this leave type.'); window.location.href='manageleave.php';</script>";
        exit();
    }

    if (mysqli_num_rows($result_check_balance) > 0) {
        
        $query_update_balance = "UPDATE leavebalances 
                                 SET RemainingDays = GREATEST(RemainingDays - $requested_days, 0)
                                 WHERE EmployeeID='$employee_id' AND LeaveTypeID='$leave_type_id'";
        mysqli_query($connection, $query_update_balance);
    } else {
        // ✅ If no record exists, INSERT a new balance
        $query_employee = "SELECT FirstName, LastName FROM `hr_1&2_new_hire_onboarding_and_employee_self-service`.employees 
                           WHERE EmployeeID='$employee_id'";
        $result_employee = mysqli_query($connection, $query_employee);
        $employee_data = mysqli_fetch_assoc($result_employee);
        $employee_name = $employee_data['FirstName'] . " " . $employee_data['LastName'];

        // Ensure that RemainingDays does not exceed MaxDaysAllowed
        $remaining_days = max($max_days_allowed - $requested_days, 0);

        $query_insert_balance = "INSERT INTO leavebalances (EmployeeID, EmployeeName, LeaveName, LeaveTypeID, RemainingDays) 
                                 VALUES ('$employee_id', '$employee_name', '$leave_name', '$leave_type_id', '$remaining_days')";
        mysqli_query($connection, $query_insert_balance);
    }

    // ✅ Approve the request
    $query_approve = "UPDATE leaverequests SET Status='Approved' WHERE RequestID='$request_id'";
    mysqli_query($connection, $query_approve);

    header("Location: manageleave.php");
    exit();
}

if (isset($_GET['reject'])) {
    $request_id = mysqli_real_escape_string($connection, $_GET['reject']);
    $query = "UPDATE leaverequests SET Status='Rejected' WHERE RequestID='$request_id'";
    mysqli_query($connection, $query);
    header("Location: manageleave.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>                                                
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Leave Requests</title>
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
        <div class="form-container mt-5">
    <h2 class="text-xl font-extrabold mb-4 text-[#4E3B2A]">Pending Leave Requests</h2>
    <?php if (mysqli_num_rows($result_requests) > 0) { ?>
        <table class="table-auto w-full text-center border-collapse border border-gray-300 rounded-lg overflow-hidden shadow-lg ">
            <thead class="uppercase bg-[#594423] text-[#e5e7eb]">
                <tr>
                    <th class="py-2 border border-gray-200 p-4">Employee ID</th>
                    <th class="py-2 border border-gray-200 p-4">Employee Name</th>
                    <th class="py-2 border border-gray-200 p-4">Leave Type</th>
                    <th class="py-2 border border-gray-200 p-4">Leave Name</th>
                    <th class="py-2 border border-gray-200 p-4">Program Name</th>
                    <th class="py-2 border border-gray-200 p-4">Start Date</th>
                    <th class="py-2 border border-gray-200 p-4">End Date</th>
                    <th class="py-2 border border-gray-200 p-4">Status</th>
                    <th class="py-2 border border-gray-200 p-4">Action</th>
                </tr>
            </thead>
            <tbody class="bg-white text-[#594423]">
                <?php while ($row = mysqli_fetch_assoc($result_requests)) { ?>
                    <tr class="hover:bg-gray-100">
                        <td class="py-3 border border-gray-200 p-4"><?php echo htmlspecialchars($row['EmployeeID']); ?></td>
                        <td class="py-3 border border-gray-200 p-4"><?php echo htmlspecialchars($row['FirstName'] . ' ' . $row['LastName']); ?></td>
                        <td class="py-3 border border-gray-200 p-4"><?php echo htmlspecialchars($row['LeaveTypeName']); ?></td>
                        <td class="py-3 border border-gray-200 p-4"><?php echo htmlspecialchars($row['LeaveName']); ?></td>
                        <td class="py-3 border border-gray-200 p-4"><?php echo htmlspecialchars($row['ProgramName']); ?></td>
                        <td class="py-3 border border-gray-200 p-4"><?php echo htmlspecialchars($row['StartDate']); ?></td>
                        <td class="py-3 border border-gray-200 p-4"><?php echo htmlspecialchars($row['EndDate']); ?></td>
                        <td class="py-3 border border-gray-200 p-4"><?php echo htmlspecialchars($row['Status']); ?></td>
                        <td class="py-3 border border-gray-200 p-4 flex justify-center gap-3">
                            <!-- Approve Button -->
                            <a href='?approve=<?php echo $row['RequestID']; ?>' 
                               class='inline-block bg-green-500 text-white px-4 py-3 rounded-lg hover:bg-green-700 focus:outline-none'>
                               Approve
                            </a>
                            <!-- Reject Button -->
                            <a href='?reject=<?php echo $row['RequestID']; ?>' 
                               class='inline-block bg-red-500 text-white px-4 py-3 rounded-lg hover:bg-red-700 focus:outline-none'>
                               Reject
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-gray-500 mt-4">No pending leave requests found.</p>
    <?php } ?>
</div>


        </main>
    </div>
    <script src="assets/script.js"></script>
</body>
</html>
