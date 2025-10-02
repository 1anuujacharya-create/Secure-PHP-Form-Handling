<?php
// -------------------- START SESSION --------------------
session_start();

// -------------------- ERROR HANDLING --------------------
$errors = [];
$successMessage = "";
$getMessage = "";

// -------------------- PROCESS REGISTRATION FORM (POST) --------------------
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['register'])) {
    // Step 1: Capture and sanitize input values
    $username = trim($_POST["username"]);  
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $password = $_POST["password"];  
    $confirmPassword = $_POST["confirm_password"];

    // Step 2: Validation checks
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $errors[] = "All fields are required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    if (strlen($password) < 8 || !preg_match("/[0-9]/", $password) || !preg_match("/[^a-zA-Z0-9]/", $password)) {
        $errors[] = "Password must be at least 8 characters long, include a number, and a special character.";
    }
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    // Step 3: Secure password processing (hashing)
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Example (commented out): Safe database insertion using prepared statements
        /*
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashedPassword);
        $stmt->execute();
        */

        $successMessage = "✅ Registration successful! Welcome, $username";
    }
}

// -------------------- PROCESS GET EXAMPLE --------------------
if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["username"])) {
    // htmlspecialchars prevents XSS by escaping malicious HTML/JS
    $getMessage = htmlspecialchars($_GET["username"]);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Registration & Data Transmission Demo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9fafc;
            color: #333;
            margin: 40px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #4A90E2;
        }
        label {
            font-weight: bold;
        }
        input, button {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        button {
            background: #4A90E2;
            color: white;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #357ABD;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .success {
            color: green;
            margin-bottom: 10px;
        }
        .info-box {
            background: #eef5ff;
            padding: 15px;
            border-left: 4px solid #4A90E2;
            margin-top: 20px;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <div class="container">

        <!-- Secure User Registration Form -->
        <h2>Secure User Registration</h2>
        <?php
        // Display errors
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<div class='error'>⚠️ " . htmlspecialchars($error) . "</div>";
            }
        }
        // Display success message
        if (!empty($successMessage)) {
    echo "<div class='success'>" . htmlspecialchars($successMessage, ENT_QUOTES, 'UTF-8') . "</div>";
        }
        ?>
        <form method="POST" action="">
            <!-- Username field -->
            <label for="username">Username:</label>
            <input type="text" name="username" placeholder="Enter username" required>
            
            <!-- Email field -->
            <label for="email">Email:</label>
            <input type="email" name="email" placeholder="Enter email" required>
            
            <!-- Password field -->
            <label for="password">Password:</label>
            <input type="password" name="password" placeholder="Enter password" required>
            
            <!-- Confirm password field -->
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" placeholder="Confirm password" required>
            
            <!-- Submit button -->
            <button type="submit" name="register">Register</button>
        </form>
        
        <!-- GET Method Example -->
        <h2>GET Method Example</h2>
        <form method="GET" action="">
            <label for="username">Enter your name (via GET):</label>
            <input type="text" name="username" placeholder="Enter your name">
            <button type="submit">Submit</button>
        </form>
        <?php
        if (!empty($getMessage)) {
            echo "<div class='info-box'>Message received via GET: <strong>$getMessage</strong></div>";
        }
        ?>

        <!-- Explanation of GET vs POST -->
        <h2>GET vs POST: Explanation</h2>
        <div class="info-box">
            <p><strong>GET:</strong> Appends data to the URL (e.g., search queries). Easy for bookmarking but less secure because data is visible in the URL.</p>
            <p><strong>POST:</strong> Sends data inside the request body (e.g., registration/login forms). More secure for sensitive information like passwords.</p>
            <p><em>Use GET</em> when data retrieval doesn’t affect security (like searches).  
            <em>Use POST</em> when handling sensitive or large amounts of data (like user registration).</p>
        </div>
    </div>
</body>
</html>
