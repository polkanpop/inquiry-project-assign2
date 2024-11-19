<?php
session_start();

require_once ("settings.php");
// Database connection
$username = "$user";
$password = "$pass";
$dbname = "$sql_db";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
            // Verify password
            $stmt = $conn->prepare("SELECT id, password FROM managers WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                if (password_verify($password, $row['password'])) {
                    // Login successful
                    $_SESSION['manager_id'] = $row['id'];
                    $_SESSION['username'] = $username;
                    header("Location: manage.php");
                    exit();
                } 
                else {

                    $error = "Invalid username or password.";
                }
            } 
            else {
                $error = "Invalid username or password.";
            }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manager Login</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; margin: 0; padding: 20px; }
        form { max-width: 400px; margin: 0 auto; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="password"] { width: 100%; padding: 8px; margin-bottom: 10px; }
        input[type="submit"] { background-color: #4CAF50; color: white; padding: 10px 15px; border: none; cursor: pointer; }
        .error { color: red; margin-bottom: 10px; text-align: center; }
        .message { color: green; margin-bottom: 10px; text-align: center;}
        h1 {text-align: center;}
    </style>
</head>
<body>
    <h1>Manager Login</h1>
    <?php 
    if (!empty($error)) { 
        echo "<p class='error'>$error</p>"; 
    }
    if (isset($_SESSION['message'])) {
        echo "<p class='message'>" . $_SESSION['message'] . "</p>";
        unset($_SESSION['message']);
    }
    ?>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <input type="submit" value="Login">
    </form>
</body>
</html>