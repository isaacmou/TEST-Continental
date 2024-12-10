

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
</head>
<body>
    <h2>Welcome to the Test Page, Please enter your Account Name and Password</h2>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>

<?php
include 'database.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredUsername = $_POST['username'];
    $enteredPassword = $_POST['password'];

    // SQL query to retrieve data from the table
    $sql = "SELECT * FROM users WHERE username='$enteredUsername' AND password='$enteredPassword'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        session_start(); // Start a session to store user information
        $row = $result->fetch_assoc();
        $username = $row['username'];
        $_SESSION['username'] = $username;
        header("Location: Mainpage.php"); // Redirect to Mainpage.php
        exit(); // Stop further execution
    } else {
        // No match found
        echo "No match found!";
    }
}

?>