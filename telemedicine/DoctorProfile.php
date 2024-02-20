<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ecf0f3;
            /* background: url('back3.jpeg') no-repeat; */
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
   
/*    

        .logo{
    font-size: 2em;
    color: #7dbaef;
    align-self: center;
    user-select: none;
}
    .navigation a{
    position: relative;
    font-size: 1.1em;
    color: #020a11;
    text-decoration: none;
    font-weight: 500;
    margin-left: 40px;
}

.navigation a::after{
    content: '';
    position: absolute;
    left: 0%;
    bottom: -6px;
    width: 100%;
    height: 3px;
    background: #136cd8;
    border-radius: 5px;
    transform-origin: center;
    transform: scaleX(0);
    transition:.5s;
}

.navigation a:hover::after{
    transform: scaleX(1);
}

header {
    position: fixed;
    top:0%;
    left: 0%;
    width: 100%;
    padding: 20px 100px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 99;
}       */
        .wrapper {

            position: relative;
            width: 80%;
            padding: 30px;
            border-radius: 10px;
            background: transparent;
          
            box-shadow: -10px -10px -10px #0099ff, 10px 10px 20px #ceced1;
        }

     
        .display {
            width: 100%;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #00ffff;
        
            border-radius: 6px;
            overflow: hidden;
        }

        th, td {
  padding: 15px;
  text-align: left;
}
th {
  background-color: #04AA6D;
  color: white;
}
tr:hover {background-color: coral;}
        .delete-btn {
            background-color: #ff5a5f;
            color: #fff;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
        }

        .delete-btn:hover {
            background-color: #0099ff;
        }
        .img-area {
            height: 150px;
            width: 150px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px 20px;
            background: #ecf0f3;
            box-shadow: -5px -5px 10px #0099ff, 5px 5px 10px #ceced1;
        }

        .img-area .inner-area {
            height: calc(100% - 25px);
            width: calc(100% - 25px);
            border-radius: 50%;
        }

        .inner-area img {
            height: 100%;
            width: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
        .about {
            font: bold;
            font-size: 20px;
            background-color: #ceced1;
        }
         </style>
</head>

<!-- <header>
                <h2 class="logo">TeleHealth Platform</h2>
                <nav class="navigation">
                    <a href="PatientProfile.html">User Profile</a>
            <a href="#">Dashboard</a>
            <a href="index.html">Logout</a>
                </nav>  
</header> -->

<body>


    <div class="wrapper">
        <div class="icon arrow">
            <i class="fas fa-arrow-left"></i>
        </div>
        <div class="icon dots">
            <i class="fas fa-ellipsis-v"></i>
        </div>
        <div class="img-area">
            <div class="inner-area">
                <img src="docprofile.jpg"
                    alt="Profile Picture">
            </div>
        </div>
        <!-- <div class="name">
            <center>Patient Details</center>
        </div> -->
        <div class="about">Check the status of our Patients below</div>
        <div id="display" class="display">
            <table>
                <tr>
                    <th>Patient ID</th>
                    <th>Patient Name</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Email</th>
                    <th>Call on</th>
                    <th>Question ID</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Action</th>
                </tr>

                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "miniproject_db";
    
                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);
    
                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }
    
                $res = mysqli_query($conn, "SELECT * FROM patient_details ORDER BY id DESC");
                if (!$res) {
                    die("Error: " . mysqli_error($conn)); // Print error if query fails
                }
    
                if (mysqli_num_rows($res) > 0) {
                    // Fetch and display data if there are rows returned
                    while($row = mysqli_fetch_assoc($res)) {
                        echo '<tr>
                                <td>'.$row['id'].'</td>
                                <td>'.$row['patientName'].'</td>
                                <td>'.$row['gender'].'</td>
                                <td>'.$row['age'].'</td>
                                <td>'.$row['email'].'</td>
                                <td>'.$row['phoneNumber'].'</td>
                                <td>'.$row['question_id'].'</td>
                                <td>'.$row['question'].'</td>
                                <td>'.$row['answer'].'</td>
                                <td><button class="delete-btn" onclick="deleteRow('.$row['id'].')">Remove</button></td>
                              </tr>';
                    }
                } else {
                    echo '<tr><td colspan="10">No records found</td></tr>';
                }
    
                // Close connection
                $conn->close();
                // $close = mysqli_close($conn);
                ?>

            </table>
        </div>
    </div>

    <script>
        function deleteRow(patientId) {
            var confirmDelete = confirm("Are you sure you want to delete this record?");

            if (confirmDelete) {
                $.ajax({
                    type: "POST",
                    url: "deleterow.php",
                    data: { patientId: patientId },
                    success: function (response) {
                        if (response === "success") {
                            // Remove the deleted row from the table
                            $("tr[data-id='" + patientId + "']").remove();
                            alert("Record deleted successfully!");
                        } else {
                            alert("Failed to delete record. Please try again later.");
                        }
                    },
                    error: function () {
                        alert("An error occurred while processing your request.");
                    }
                });
            }
        }
    </script>
</body>

</html>
