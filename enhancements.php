<?php


// Include the menu
include_once "menu.inc";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css" type="text/css">
    <title>Enhancements</title>
    <style>
        .enhancement {
            background-color: #f0f8ff;
            border: 1px solid #2c79d1;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .code {
            background-color: #f4f4f4;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 10px;
            font-family: monospace;
            white-space: pre-wrap;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Website Enhancements</h1>

        <div class="enhancement">
            <h2>1. CSS Animation for Hero Section</h2>
            <p>We've added a subtle animation to the hero section on the home page to improve user engagement.</p>
            <h3>Implementation:</h3>
            <div class="code">
.hero {
    animation: fadeIn 1s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
            </div>
            <p>Reference: <a href="https://developer.mozilla.org/en-US/docs/Web/CSS/animation" target="_blank">MDN Web Docs - CSS Animations</a></p>
            <p>Applied here: <a href="index.php#hero">Home Page Hero Section</a></p>
        </div>

        <div class="enhancement">
            <h2>2. Responsive Design for Mobile and Tablet</h2>
            <p>We've implemented a responsive design that adapts the layout for mobile and tablet screens.</p>
            <h3>Implementation:</h3>
            <div class="code">
@media (max-width: 768px) {
    .container {
        width: 95%;
    }
    .hero-content {
        padding: 1rem;
    }
    .hero h1 {
        font-size: 2rem;
    }
}
            </div>
            <p>Reference: <a href="https://developer.mozilla.org/en-US/docs/Web/CSS/Media_Queries/Using_media_queries" target="_blank">MDN Web Docs - Using Media Queries</a></p>
            <p>Applied throughout the website. Example: <a href="index.php">Home Page</a></p>
        </div>

        <div class="enhancement">
            <h2>3. Interactive Job Listings</h2>
            <p>We've added an interactive feature to the job listings page that allows users to expand job descriptions.</p>
            <h3>Implementation:</h3>
            <div class="code">
&lt;details&gt;
    &lt;summary&gt;Job Title&lt;/summary&gt;
    &lt;p&gt;Full job description...&lt;/p&gt;
&lt;/details&gt;

details summary {
    cursor: pointer;
}

details[open] summary {
    font-weight: bold;
}
            </div>
            <p>Reference: <a href="https://developer.mozilla.org/en-US/docs/Web/HTML/Element/details" target="_blank">MDN Web Docs - &lt;details&gt;: The Details disclosure element</a></p>
            <p>Applied here: <a href="jobs.php">Jobs Page</a></p>
        </div>

        <div class="enhancement">
            <h2>4. Secure Manager Authentication System</h2>
            <p>We've implemented a robust authentication system for managers, including registration, login, and logout functionality.</p>
            <h3>Key Features:</h3>
            <ul>
                <li>Secure password hashing using PHP's password_hash() function</li>
                <li>Protection against brute-force attacks by limiting login attempts</li>
                <li>Session-based authentication to prevent unauthorized access</li>
                <li>Logout functionality to securely end user sessions</li>
                <li>Immediate lockout message after 3 failed login attempts</li>
            </ul>
            <h3>Implementation Highlights:</h3>
            <div class="code">
// Password hashing
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Login attempt limiting and lockout
if ($login_attempts >= 3) {
    $stmt = $conn->prepare("UPDATE managers SET login_attempts = ?, lockout_expiration = DATE_ADD(NOW(), INTERVAL 15 MINUTE) WHERE username = ?");
    $stmt->bind_param("is", $login_attempts, $username);
    $stmt->execute();
    $lockout_message = "Account is locked. Please try again later.";
}

// Session-based authentication check
if (!isset($_SESSION['manager_id'])) {
    header("Location: login.php");
    exit();
}
            </div>
            <p>Reference: <a href="https://www.php.net/manual/en/book.password.php" target="_blank">PHP Manual - Password Hashing</a></p>
            <p>Applied in: register.php, login.php, manage.php, and logout.php</p>
        </div>

        <div class="enhancement">
            <h2>5. Server-Side Validation for EOI Submissions</h2>
            <p>We've implemented robust server-side validation for all EOI (Expression of Interest) submissions to ensure data integrity and security.</p>
            <h3>Key Features:</h3>
            <ul>
                <li>Input sanitization to prevent XSS attacks</li>
                <li>Strict validation of all form fields</li>
                <li>Custom error messages for invalid inputs</li>
                <li>Prevention of null values in required fields</li>
            </ul>
            <h3>Implementation Highlights:</h3>
            <div class="code">
// Input sanitization
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Field validation example
if (empty($gender) || !in_array($gender, ['male', 'female', 'other'])) {
    $errors[] = "Invalid Gender";
}

// Prepared statements to prevent SQL injection
$stmt = $conn->prepare("INSERT INTO EOI (jobRef, firstName, lastName, dob, gender, email, phone, skills, additionalSkills) VALUES (?, ?, ?, STR_TO_DATE(?, '%d/%m/%Y'), ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssss", $jobRef, $firstName, $lastName, $dob, $gender, $email, $phone, $skills, $additionalSkills);
            </div>
            <p>Reference: <a href="https://www.php.net/manual/en/mysqli.quickstart.prepared-statements.php" target="_blank">PHP Manual - Prepared Statements</a></p>
            <p>Applied in: processEOI.php</p>
        </div>

    <?php
    include_once "footer.inc";
    ?>
</body>
</html>