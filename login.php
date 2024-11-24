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

$error = "";
$lockout_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    // Check if the account is locked
    $stmt = $conn->prepare("SELECT login_attempts, lockout_expiration FROM managers WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $login_attempts = $row['login_attempts'];
        $lockout_expiration = $row['lockout_expiration'];
        
        // Check if the account is locked
        $stmt = $conn->prepare("SELECT NOW() > ? AS lockout_expired");
        $stmt->bind_param("s", $lockout_expiration);
        $stmt->execute();
        $lockout_result = $stmt->get_result()->fetch_assoc();
        
        if ($login_attempts >= 3 && !$lockout_result['lockout_expired']) {
            $lockout_message = "Account is locked. Please try again later.";
        } else {
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
                    
                    // Reset login attempts and lockout
                    $stmt = $conn->prepare("UPDATE managers SET login_attempts = 0, lockout_expiration = NULL WHERE id = ?");
                    $stmt->bind_param("i", $row['id']);
                    $stmt->execute();
                    
                    header("Location: manage.php");
                    exit();
                } else {
                    // Increment login attempts and set lockout if necessary
                    $login_attempts++;
                    if ($login_attempts >= 3) {
                        $stmt = $conn->prepare("UPDATE managers SET login_attempts = ?, lockout_expiration = DATE_ADD(NOW(), INTERVAL 2 MINUTE) WHERE username = ?");
                        $stmt->bind_param("is", $login_attempts, $username);
                        $stmt->execute();
                        $lockout_message = "Account is locked. Please try again later.";
                    } else {
                        $stmt = $conn->prepare("UPDATE managers SET login_attempts = ? WHERE username = ?");
                        $stmt->bind_param("is", $login_attempts, $username);
                        $stmt->execute();
                        $error = "Invalid username or password. Attempts remaining: " . (3 - $login_attempts);
                    }
                }
            } else {
                $error = "Invalid username or password.";
            }
        }
    } else {
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
    <link rel="stylesheet" href="./styles/login-register_style.css">
</head>
<body>
    <div class="container">
        <h1>Manager Login</h1>
        <?php 
        if (!empty($lockout_message)) { 
            echo "<p class='lockout'>$lockout_message</p>"; 
        } elseif (!empty($error)) { 
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
        <div class="register-link">
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</body>
</html>