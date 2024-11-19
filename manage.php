<?php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['manager_id'])) {
    header("Location: login.php");
    exit();
}

require_once ("settings.php");


// Database connection details
$host = "$host";
$username = "$user";
$password = "$pass";
$dbname = "$sql_db";

// Create connection
$conn = @mysqli_connect($host, $username, $password, $dbname);


if (!$conn) {
    echo"<p>Database connection failure</p>";
}

else {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'list_all':
                    $sql = "SELECT * FROM EOI";
                    $result = $conn->query($sql);
                    break;
                case 'list_by_job':
                    $jobRef = sanitize_input($_POST['jobRef']);
                    $sql = "SELECT * FROM EOI WHERE jobRef = '$jobRef'";
                    $result = $conn->query($sql);
                    break;
                case 'list_by_applicant':
                    $firstName = sanitize_input($_POST['firstName']);
                    $lastName = sanitize_input($_POST['lastName']);
                    $sql = "SELECT * FROM EOI WHERE firstName LIKE '%$firstName%' AND lastName LIKE '%$lastName%'";
                    $result = $conn->query($sql);
                    break;
                case 'delete_by_job':
                    $jobRef = sanitize_input($_POST['jobRef']);
                    $sql = "DELETE FROM EOI WHERE jobRef = '$jobRef'";
                    if ($conn->query($sql) === TRUE) {
                        $message = "EOIs with job reference $jobRef have been deleted.";
                        // Check if the table is empty and reset auto-increment if it is
                        $check_empty = "SELECT COUNT(*) as count FROM EOI";
                        $result = $conn->query($check_empty);
                        $row = $result->fetch_assoc();
                        if ($row['count'] == 0) {
                            reset_auto_increment($conn, 'EOI');
                            $message .= " Auto-increment has been reset.";
                        }
                    } else {
                        $message = "Error deleting EOIs: " . $conn->error;
                    }
                    break;
                case 'change_status':
                    $eoiNumber = sanitize_input($_POST['eoiNumber']);
                    $newStatus = sanitize_input($_POST['newStatus']);
                    $sql = "UPDATE EOI SET status = '$newStatus' WHERE EOInumber = $eoiNumber";
                    if ($conn->query($sql) === TRUE) {
                        $message = "Status updated for EOI number $eoiNumber.";
                    } else {
                        $message = "Error updating status: " . $conn->error;
                    }
                    break;
                case 'delete_all':
                    $sql = "TRUNCATE TABLE EOI";
                    if ($conn->query($sql) === TRUE) {
                        $message = "All EOIs have been deleted and auto-increment has been reset.";
                    } else {
                        $message = "Error deleting all EOIs: " . $conn->error;
                    }
                    break;
            }
        }
    }
}



// Function to sanitize input data
function sanitize_input($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $conn->real_escape_string($data);
}
function reset_auto_increment($conn, $table_name) {
    $sql = "ALTER TABLE $table_name AUTO_INCREMENT = 1";
    if ($conn->query($sql) === FALSE) {
        echo "Error resetting auto-increment: " . $conn->error;
    }
}

// Process form submissions

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage EOIs</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px; }
        h1, h2 { color: #333; }
        form { margin-bottom: 20px; }
        input[type="text"], input[type="submit"] { margin: 5px 0; padding: 5px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>

    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>! <a href="logout.php">Logout</a></p>
    <h1>Manage EOIs</h1>

    <h2>List all EOIs</h2>
    <form method="post">
        <input type="hidden" name="action" value="list_all">
        <input type="submit" value="List All EOIs">
    </form>

    <h2>List EOIs by Job Reference</h2>
    <form method="post">
        <input type="hidden" name="action" value="list_by_job">
        <input type="text" name="jobRef" placeholder="Job Reference" required>
        <input type="submit" value="List EOIs">
    </form>

    <h2>List EOIs by Applicant</h2>
    <form method="post">
        <input type="hidden" name="action" value="list_by_applicant">
        <input type="text" name="firstName" placeholder="First Name">
        <input type="text" name="lastName" placeholder="Last Name">
        <input type="submit" value="List EOIs">
    </form>

    <h2>Delete EOIs by Job Reference</h2>
    <form method="post" onsubmit="return confirm('Are you sure you want to delete these EOIs?');">
        <input type="hidden" name="action" value="delete_by_job">
        <input type="text" name="jobRef" placeholder="Job Reference" required>
        <input type="submit" value="Delete EOIs">
    </form>

    <h2>Change EOI Status</h2>
    <form method="post">
        <input type="hidden" name="action" value="change_status">
        <input type="text" name="eoiNumber" placeholder="EOI Number" required>
        <select name="newStatus" required>
            <option value="">Select Status</option>
            <option value="New">New</option>
            <option value="Current">Current</option>
            <option value="Final">Final</option>
        </select>
        <input type="submit" value="Update Status">
    </form>

    <h2>Delete All EOIs</h2>
    <form method="post" onsubmit="return confirm('Are you sure you want to delete ALL EOIs? This action cannot be undone.');">
        <input type="hidden" name="action" value="delete_all">
        <input type="submit" value="Delete All EOIs">
    </form>

    <?php
    if (isset($result) && $result->num_rows > 0) {
        echo "<h2>Query Results</h2>";
        echo "<table>";
        echo "<tr><th>EOI Number</th><th>Job Ref</th><th>First Name</th><th>Last Name</th><th>DOB</th><th>Gender</th><th>Email</th><th>Phone</th><th>Skills</th><th>Additional Skills</th><th>Status</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["EOInumber"]."</td>";
            echo "<td>".$row["jobRef"]."</td>";
            echo "<td>".$row["firstName"]."</td>";
            echo "<td>".$row["lastName"]."</td>";
            echo "<td>".$row["dob"]."</td>";
            echo "<td>".$row["gender"]."</td>";
            echo "<td>".$row["email"]."</td>";
            echo "<td>".$row["phone"]."</td>";
            echo "<td>".$row["skills"]."</td>";
            echo "<td>".$row["additionalSkills"]."</td>";
            echo "<td>".$row["status"]."</td>";
            echo "</tr>";
        }
        echo "</table>";
    } elseif (isset($result)) {
        echo "<p>No results found.</p>";
    }

    if (isset($message)) {
        echo "<p>$message</p>";
    }
    ?>

</body>
</html>

<?php
mysqli_close($conn);
?>