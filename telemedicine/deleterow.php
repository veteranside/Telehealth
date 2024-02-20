<?php
// deleterow.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure that the patientId is provided in the POST data
    if (isset($_POST['patientId'])) {
        $patientId = $_POST['patientId'];

        // Your database connection code (similar to your existing PHP file)
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "miniproject_db";
        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Delete the row
        $sql = "DELETE FROM patient_details WHERE id = $patientId";
        if ($conn->query($sql) === TRUE) {
            echo "success";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "Invalid request. Missing patientId.";
    }
} else {
    echo "Invalid request method.";
}
?>
