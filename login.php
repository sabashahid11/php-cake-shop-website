<?php
$servername = "localhost";
$username = "root"; // Your MySQL username
$password = ""; // Your MySQL password
$dbname = "cakeshop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Debugging output - username and password entered
    echo "Username entered: " . $user . "<br>";
    echo "Password entered: " . $pass . "<br>";


    // Prepare and bind
    $stmt = $conn->prepare("SELECT password FROM users WHERE username=?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    // Debugging output - hashed password retrieved from the database
    echo "Hashed password from database: " . $hashed_password . "<br>";

    if ($stmt->num_rows > 0 || password_verify($pass, $hashed_password)) {
        // Debugging output - successful login
        echo "Password match found in database!<br>";
        echo "Redirecting to dashboard...";
        // User found and password is correct
        header("Location: dashboard.html");
    } else {
        // Debugging output - unsuccessful login
        echo "INCORRECT PASSWORD OR USERNAME!";
        // User not found or password incorrect
    }

    $stmt->close();
}

$conn->close();
?>