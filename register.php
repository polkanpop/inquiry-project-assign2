<?php
session_start();


require_once("settings.php");
// Database connection

$username = "$user";
$password = "$pass";
$dbname = "$sql_db";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else {
    
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    // Validate username
    if (empty($username) || strlen($username) < 5) {
        $error = "Username must be at least 5 characters long.";
    } else {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT id FROM managers WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $error = "Username already exists.";
        }
        $stmt->close();
    }
    
    // Validate password
    if (empty($password) || strlen($password) < 8 || !preg_match("/[A-Z]/", $password) || !preg_match("/[a-z]/", $password) || !preg_match("/[0-9]/", $password)) {
        $error = "Password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter, and one number.";
    }
    
    if (empty($error)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert new manager
        $stmt = $conn->prepare("INSERT INTO managers (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Registration successful. You can now log in.";
            header("Location: login.php");
            exit();
        } else {
            $error = "Registration failed. Please try again.";
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Registration</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px; }
        form { max-width: 400px; margin: 0 auto; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; margin-bottom: 10px; }
        input[type="submit"] { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; cursor: pointer; }
        .error { color: red; margin-bottom: 10px; }
        h1 {text-align: center;}
    </style>
</head>
<body>
    <h1>Manager Registration</h1>
    <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <input type="submit" value="Register">
    </form>
</body>
</html>