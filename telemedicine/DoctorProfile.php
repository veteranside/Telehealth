<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Page</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            text-align: center;
            margin: 50px;
        }

        h1 {
            font-size: 36px;
            color: #333;
        }

        #welcome-message {
            font-size: 24px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h1>Welcome</h1>
    
    <?php
    // Assuming you have a valid database connection
    $dbHost = 'localhost';
    $dbUser = 'root';
    $dbPass = '';
    $dbName = 'miniproject_db';

    $conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Assuming you have received the email through some means, replace 'user@example.com' with the actual email
    $email = 'user@example.com';

    // Fetch user details from the database based on the provided email
    $sql = "SELECT name FROM doctors WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display the welcome message with the user's name
        $row = $result->fetch_assoc();
        $name = $row['doctorName'];
        echo "<div id='welcome-message'>Welcome, $name!</div>";
    } else {
        // Handle the case where the user with the provided email is not found
        echo "<div id='welcome-message'>User not found.</div>";
    }

    // Close the database connection
    $conn->close();
    ?>

</body>

</html>
