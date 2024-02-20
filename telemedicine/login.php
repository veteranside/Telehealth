<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Database connection details (modify these based on your database setup)
    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "miniproject_db";

    // Create a connection
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user data from the database
    $sql = "SELECT * FROM patients WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if the user exists and the password is correct
    if ($user && password_verify($password, $user["password"])) {
        // Redirect to another page upon successful login
        header("Location: PatientProfile.html");
        exit();
    } else {
       
       echo '<script>alert("Wrong password"); window.location.href = "doc.html";</script>';
       
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
