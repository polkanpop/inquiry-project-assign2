<?php
// Prevent direct access to this script
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: apply.php");
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

// Check connection
if (!$conn) {
    echo"<p>Database connection failure</p>";
}

// Function to sanitize input data
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Validate and sanitize input data
$jobRef = sanitize_input($_POST['jobRef']);
$firstName = sanitize_input($_POST['1stName']);
$lastName = sanitize_input($_POST['lastname']);
$dob = sanitize_input($_POST['DOB']);
$email = sanitize_input($_POST['email']);
$phone = sanitize_input($_POST['teleNum']);
$skills = isset($_POST['programlanguage']) ? implode(", ", $_POST['programlanguage']) : "";
$additionalSkills = sanitize_input($_POST['add-skill']);

// Validate required fields
$errors = [];
if (empty($jobRef) || !preg_match("/^[A-Za-z0-9]{5}$/", $jobRef)) {
    $errors[] = "Invalid Job Reference Number";
}
if (empty($firstName) || !preg_match("/^[A-Za-z]+$/", $firstName)) {
    $errors[] = "Invalid First Name";
}
if (empty($lastName) || !preg_match("/^[A-Za-z]+$/", $lastName)) {
    $errors[] = "Invalid Last Name";
}
if (empty($dob) || !preg_match("/^\d{2}\/\d{2}\/\d{4}$/", $dob)) {
    $errors[] = "Invalid Date of Birth";
}
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid Email";
}
if (empty($phone) || !preg_match("/^(\d\s?){8,12}$/", $phone)) {
    $errors[] = "Invalid Phone Number";
}

// If there are errors, display them and stop processing
if (!empty($errors)) {
    echo "<h2>Error(s) found:</h2>";
    echo "<ul>";
    foreach ($errors as $error) {
        echo "<li>$error</li>";
    }
    echo "</ul>";
    echo "<a href='javascript:history.back()'>Go Back</a>";
    exit();
}

// Check if EOI table exists, if not create it
$sql = "CREATE TABLE IF NOT EXISTS EOI (
    EOInumber INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jobRef VARCHAR(5) NOT NULL,
    firstName VARCHAR(20) NOT NULL,
    lastName VARCHAR(20) NOT NULL,
    dob DATE NOT NULL,
    gender ENUM('male', 'female', 'other') NOT NULL,
    email VARCHAR(50) NOT NULL,
    phone VARCHAR(12) NOT NULL,
    skills VARCHAR(255),
    additionalSkills TEXT,
    status ENUM('New', 'Current', 'Final') DEFAULT 'New'
)";

if ($conn->query($sql) === FALSE) {
    die("Error creating table: " . $conn->error);
}

// Insert data into the EOI table
$sql = "INSERT INTO EOI (jobRef, firstName, lastName, dob, gender, email, phone, skills, additionalSkills)
        VALUES (?, ?, ?, STR_TO_DATE(?, '%d/%m/%Y'), ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssss", $jobRef, $firstName, $lastName, $dob, $gender, $email, $phone, $skills, $additionalSkills);

if ($stmt->execute()) {
    $eoiNumber = $stmt->insert_id;
    echo "<h2>Application Submitted Successfully</h2>";
    echo "<p>Your EOI Number is: " . $eoiNumber . "</p>";
    echo "<p>Current Status: New</p>";
    echo "<a href='index.php'>Return to Home</a>";
} else {
    die("Error: " . $sql . "<br>" . $conn->error);
}

$stmt->close();
$conn->close();
?>