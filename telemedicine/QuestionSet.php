<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    $selectedOptions = $_POST["selectedOptions"];

    // Database connection details
    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "miniproject_db";

    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    for ($i = 0; $i < count($selectedOptions); $i++) {
        $questionNumber = $i + 1;
        $selectedOption = $selectedOptions[$i];

        $sql = "INSERT INTO qna (question, answer ) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $questionNumber, $selectedOption);
        $stmt->execute();
        $stmt->close();
    }

    $conn->close();

    echo "Thank you !";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Questionnaire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: aqua;
            background-image: url('back3.jpeg'); /* Replace with your hospital-themed background */
            background-size: cover;
            background-position: center;
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
}
        .logo{
    font-size: 2em;
    position: left;
    color: white ;
    user-select: none;
}
        .back-arrow {
            position: fixed;
            top: 100px;
            left: 260px;
            font-size: 15px;
            background: #333 ;
            text-decoration:  navy ;
            border-color: black;
           
            color: #ffffff;
            width: 40px; 
            height: 40px; 
            border-radius: 50%; 
            display: flex;
            justify-content: center;
            align-items: center;
        }

            .back-arrow:hover{
            background-color: rgb(0, 251, 255);
            color: white;
        }
        .container {
            background-color: rgb(255, 255, 255);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            width: 900px;
        }

        .question {
            font-size: 30px;
            margin-bottom: auto;
            margin-left: auto ;
            margin-right: auto;
        }
        
        .option {
            display: block;
            padding: 10px;
            margin: 10px 0;
            border: 2px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        .option:hover,
        .option.selected {
            background-color: rgb(0, 251, 255);
            color: white;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: auto;    
        }

        .previous-button,
        .next-button,
        .submit-button {
            padding: 10px;
            background-color: #3538be;
            color: #fff;
            cursor: pointer;
            animation-duration: 1s;
            box-shadow: 1px 4px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
         
            padding: 10px;
            width: auto;
        }
        .submit-button {
            display: none;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .next-button:hover,
        .submit-button:hover {
            background-color: rgb(0, 251, 255);
        }

        .submit-button[disabled] {
            background-color: #aaa;
            cursor: not-allowed;
        }
        .previous-button:hover,
        .next-button:hover,
        .submit-button:hover {
            background-color: #00ffff;
        }

        .previous-button[disabled],
        .next-button[disabled],
        .submit-button[disabled] {
            background-color: #aaa;
            cursor: not-allowed;
        }
        
        /* #thresholdResult {
            display: none;
            margin-top: 20px;
            padding: 10px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        } */
        #thresholdResult {
            display: none;
            margin-top: 30px;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        #resultOverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        #resultContainer {
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            padding: 20px;
            width: 80%;
            max-width: 600px;
            text-align: center;
        }
        #popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            border: 2px solid #333;
            text-align: center;
            font-size: 24px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
          button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #ff5a5f; /* Red color, you can change it */
            color: #fff; /* White text color */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px; /* Adjust margin as needed */
        }

      button:hover {
            background-color: #e40042; /* Darker red on hover, you can change it */
        }
</style>
</head>

<body>
<header>
        <h2 class="logo">TeleHealth Platform</h2>
    </header>
    <div class="container" id="questionContainer">
        <div class="question" id="questionText"></div>
        <div class="option" onclick="selectOption(this, 0)" name="selectedOptions[]"></div>
        <div class="option" onclick="selectOption(this, 1)" name="selectedOptions[]"></div>
        <div class="option" onclick="selectOption(this, 2)" name="selectedOptions[]"></div>
        <div class="option" onclick="selectOption(this, 3)" name="selectedOptions[]"></div>
        
        <div class="button-container">
            <button class="previous-button" onclick="previousQuestion()" disabled>Previous</button>
            <button class="next-button" onclick="nextQuestion()">Next</button>
            <button class="submit-button" onclick="submitAnswers()" disabled>Submit</button>
           
        </div>
        <p id="selectionErrorMessage" style="color: rgb(0, 204, 255);"></p>


    </div>
    </div>

    <a href="PatientProfile.html" class="back-arrow">&lArr;</a>
    <div id="thresholdResult">

        <h2>Status</h2>
        <p id="resultText"></p>
        <input type="text" name="userEmail" id="userEmail"style="display: none;" placeholder="Enter your email">
        <button id="consultNowButton" onclick="consultNow()" style="display: none;">Consult Now</button>
        <button id="okayButton" onclick="okay()" style="display: none;">Okay</button>
    </div>

    <div id="resultOverlay">
        <div id="resultContainer">
            <h2>Threshold Result</h2>
            <p id="resultText"></p>
           
        </div>


        <div class="container">
        </div>

    </div>
    <div id="popup">
        <p>Thank you for your time! 😊</p>
    </div>

    <script>
        const questions = [
            "1. How are you ?",
            "2.	In the past two weeks how often have you felt down, hopeless or depressed?",
            "3.	Have you experienced changes in your weight or appetite recently?",
            "4.	Do you have trouble sleeping such as, difficulty falling asleep or staying asleep?",
            "5.	Have you lost interest in activities you used to enjoy?",
            "6.	How would you rate your energy levels throughout the day?",
            "7.	Do you have difficulty concentrating or making decisions?",
            "8.	Have you had thoughts of harming yourself or ending your life?",
            "9.	Do you feel guilty or worthless about things more than usual?",
            "10. How often do you feel restless, impatient or nervous?",
            "11. Do you find it difficult to carry out your responsibilities such as works or house chores?",
        ];

        const options = [
            ["Fine", "Very Fine", "Not Fine", "Yes"],
            ["Not at all", "Occasionally", "Moderately", "Frequently"],
            ["No change","Slight change","Moderate change","Significant change"],
            ["Never", "Occasionally", "Moderately", "Always"],
            ["Not at all (Next) ", "A little", "Quite a bit", "Completely"],
            ["High (Next)", "Moderate", "Low", "Very low"],
            ["Rarely (Next) ", "Sometimes", "Moderately", "Constantly"],
            ["Never (Next) ", "Rarely", "Sometimes", "Frequently"],
            ["Not at all (Next) ", "Occasionally", "Moderately", "Constantly"],
            ["Rarely (Next) " , "Sometimes", "Mostly", "Constantly"],
            ["Not at all (Submit) ", "Occasionally", "Mostly", "Always"],
        ];

        let currentQuestionIndex = 0;
        let selectedOptions = [null, null, null, null];
        function updateQuestion() {
            const questionTextElement = document.getElementById('questionText');
            questionTextElement.innerText = `${questions[currentQuestionIndex]}`;
            resetOptions();
            populateOptions();
        }

        function populateOptions() {
            const optionElements = document.querySelectorAll('.option');
            options[currentQuestionIndex].forEach((option, index) => {
                optionElements[index].innerText = option;
            });
        }

        function resetOptions() {
            const options = document.querySelectorAll('.option');
            options.forEach((option, index) => {
                option.classList.remove('selected');
                option.classList.remove('hover-effect');
            });
        }

        function selectOption(optionElement, optionIndex) {
            resetOptions();
            optionElement.classList.add('selected');
            selectedOptions[currentQuestionIndex] = optionIndex;

            updateButtonState();
        }



        // buttons functionality //

        var previousButton = document.getElementById('previous-Button');
        var nextButton = document.getElementById('next-Button');
        var submitButton = document.getElementById('submit-Button');;
        var popup = document.getElementById('popup');


        function previousQuestion() {
            if (currentQuestionIndex > 0) {
                currentQuestionIndex--;
                updateQuestion();
                updateButtonState();
                submitButton.disabled = false;
            }
        }

        function nextQuestion() {
            if (currentQuestionIndex < questions.length - 1) {
                currentQuestionIndex++;
                updateQuestion();
                updateButtonState();
            }
        }

 function updateButtonState() {
    const previousButton = document.querySelector('.previous-button');
            const nextButton = document.querySelector('.next-button');
            const submitButton = document.querySelector('.submit-button');

            previousButton.disabled = currentQuestionIndex === 0;
            nextButton.disabled = selectedOptions[currentQuestionIndex] === null;

            // Show the Submit button on the last question
            
            submitButton.style.display = currentQuestionIndex === questions.length - 1 ? 'inline-block' : 'none';
            submitButton.disabled = selectedOptions.includes(null);  
            
        }

        function nextQuestion() {
            if (currentQuestionIndex < questions.length - 1) {
                currentQuestionIndex++;
                updateQuestion();
                updateButtonState();
                submitButton.disabled = false;
            }
        }
        function submitAnswers() {
            alert('Answers submitted!');
        }

        updateQuestion();
        updateButtonState();
        function submitAnswers() {
            //logic for submitting answers
            const thresholdResult = calculateThreshold();
            displayThresholdResult(thresholdResult);
            previousButton.disabled = true;
            nextButton.style.display = 'none';
            
        }





        function calculateThreshold() {
    const result = [0, 0, 0, 0];
    const questionThresholds = [
        { A: 0, B: 0, C: 0, D: 0 }, // Thresholds for Question 1
        { A: 0, B: 18, C: 27, D: 45 }, // Thresholds for Question 2
        { A: 0, B: 17, C: 23, D: 40 }, // Thresholds for Question 3
        { A: 0, B: 12, C: 18, D: 30 }, // Thresholds for Question 4
        { A: 0, B: 14, C: 21, D: 35 }, // Thresholds for Question 5
        { A: 0, B: 6,  C: 14, D: 20 }, // Thresholds for Question 6
        { A: 0, B: 3,  C: 7,  D: 10 }, // Thresholds for Question 7
        { A: 0, B: 15, C:30,  D: 55 }, // Thresholds for Question 8
        { A: 0, B: 1.5,C: 3.5,D: 5  }, // Thresholds for Question 9
        { A: 0, B: 7.5,C: 15, D: 27.5 }, // Thresholds for Question 10
        { A: 0, B: 4.5,C: 9,  D: 16.5 }, // Thresholds for Question 11
    ];

    for (let i = 0; i < selectedOptions.length; i++) {
        const option = String.fromCharCode(65 + selectedOptions[i]); // Convert index to option letter (A, B, C, D)
        result[selectedOptions[i]] += questionThresholds[i][option];
    }

    return result;
}



function submitAnswers() {
            const thresholdResult = calculateThreshold();
            displayThresholdResult(thresholdResult);
        }

        function displayThresholdResult(result) {
            const thresholdResultElement = document.getElementById('thresholdResult');
            const resultTextElement = document.getElementById('resultText');

            const totalPercentage = result.reduce((acc, val) => acc + val, 0);

            let resultText = '';

            if (totalPercentage > 90) {
                resultText = `You should Consult With Our Doctors<br>`;
                userEmail.style.display = true ;
                consultNowButton.style.display = 'inline-block';
                okayButton.style.display = 'none';
               //   resultText += <button onclick="consultNow()">Consult Now</button>;
            } else if (totalPercentage >= 50 && totalPercentage <= 90) {
                resultText = `Visit The Nearest Health Post<br>`;
               
                consultNowButton.style.display = 'none';
                userEmail.style.display = 'none' ;
                okayButton.style.display = 'inline-block';
            } else {
                const healthyPercentage = 100 - totalPercentage;
                resultText = `You are ${healthyPercentage}% Healthy!<br>`;
                consultNowButton.style.display = 'none';
                userEmail.style.display = 'none' ;
                okayButton.style.display = 'inline-block';
            }

            // resultText += `
            //     Option A: ${result[0]}%<br>
            //     Option B: ${result[1]}%<br>
            //     Option C: ${result[2]}%<br>
            //     Option D: ${result[3]}%<br>
            // `;

            resultTextElement.innerHTML = resultText;

            thresholdResultElement.style.display = 'block';
            popup.style.display = 'block';
        }
function okay(){
    alert("Stay Hydrated");
    window.location.href = 'PatientProfile.html'; 

}

        function consultNow() {
    // Implement the logic to initiate a consultation
    alert("Our Doctors will get in touch with you very soon.");
    window.location.href = 'PatientProfile.html'; 
}


        // background audio...//

        document.addEventListener('DOMContentLoaded', function() {
        var audio = document.querySelector('audio');
        audio.volume = 0.5; // Set volume (0.0 to 1.0)
        
    });

    
    </script>
    <audio autoplay loop>
        <source src="Cluster_one_Pink_FLOYD.mp3" type="audio/mp3">

    </audio>

</body>

</html>
