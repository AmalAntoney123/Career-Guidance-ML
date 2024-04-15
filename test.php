<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questionnaire</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .question-container {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <form id="questionnaireForm" method="get" action="process.php">
        <div id="questionnaire">
            <div class="question-container">
                <h3>What course did you pursue in high school?</h3>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="highSchoolCourse" id="science" value="science">
                    <label class="form-check-label" for="science">Science</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="highSchoolCourse" id="commerce" value="commerce">
                    <label class="form-check-label" for="commerce">Commerce</label>
                </div>
            </div>
            <div class="question-container" id="scienceOrEngineering" style="display: none;">
                <h3>Are you interested in pursuing a degree in science or engineering?</h3>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="scienceOrEngineering" id="scienceDegree"
                        value="science">
                    <label class="form-check-label" for="scienceDegree">Science</label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="scienceOrEngineering" id="engineeringDegree"
                        value="engineering">
                    <label class="form-check-label" for="engineeringDegree">Engineering</label>
                </div>
            </div>
            <div class="card mb-3 question-container bg-light" id="question2" style="display: none;">
                <div class="card-body">
                    <h5 class="card-title">Hi <?= ucwords($fullName) ?></h5>
                    <p class="card-text">How much do you enjoy delving into the basics of managing digital information?
                    </p>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="Database" id="option2-1" value="option1">
                        <label class="form-check-label" for="option2-1">Not Interested</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="Database" id="option2-2" value="option2">
                        <label class="form-check-label" for="option2-2">Poor</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="Database" id="option2-3" value="option3">
                        <label class="form-check-label" for="option2-3">Beginner</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="Database" id="option2-4" value="option4">
                        <label class="form-check-label" for="option2-4">Neutral</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="Database" id="option2-5" value="option5">
                        <label class="form-check-label" for="option2-5">Modestly Curious</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="Database" id="option2-6" value="option6">
                        <label class="form-check-label" for="option2-6">Developing Interest</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="Database" id="option2-7" value="option7">
                        <label class="form-check-label" for="option2-7">Profoundly Interested</label>
                    </div>
                </div>
            </div>
        </div>
        <button type="button" id="prevBtn" disabled>Previous</button>
        <button type="button" id="nextBtn">Next</button>
        <button type="submit" id="submitBtn" style="display: none;">Submit</button>
    </form>

    <script>
    const Science = [
        ["Physics", "How would you rate your expertise in Physics?"],
        ["Chemistry", "How would you rate your expertise in Chemistry?"],
        ["Biology", "How would you rate your expertise in Biology?"],
        ["Mathematics", "How would you rate your expertise in Mathematics?"],
        ["Environmental Science", "How would you rate your expertise in Environmental Science?"],
        ["Astronomy", "How would you rate your expertise in Astronomy?"],
        ["Medicine", "How would you rate your expertise in Medicine?"],
        ["Pharmacology", "How would you rate your expertise in Pharmacology?"],
        ["Biochemistry", "How would you rate your expertise in Biochemistry?"]
    ];

    const Engineering = [
        ["Mechanical Engineering", "How would you rate your expertise in Mechanical Engineering?"],
        ["Electrical Engineering", "How would you rate your expertise in Electrical Engineering?"],
        ["Civil Engineering", "How would you rate your expertise in Civil Engineering?"],
        ["Chemical Engineering", "How would you rate your expertise in Chemical Engineering?"],
        ["Computer Engineering", "How would you rate your expertise in Computer Engineering?"],
        ["Aerospace Engineering", "How would you rate your expertise in Aerospace Engineering?"],
        ["Biomedical Engineering", "How would you rate your expertise in Biomedical Engineering?"],
        ["Environmental Engineering", "How would you rate your expertise in Environmental Engineering?"],
        ["Industrial Engineering", "How would you rate your expertise in Industrial Engineering?"],
        ["Software Engineering", "How would you rate your expertise in Software Engineering?"]
    ];

    const Commerce = [
        ["Accounting", "How would you rate your expertise in Accounting?"],
        ["Finance", "How would you rate your expertise in Finance?"],
        ["Economics", "How would you rate your expertise in Economics?"],
        ["Business Management", "How would you rate your expertise in Business Management?"],
        ["Marketing", "How would you rate your expertise in Marketing?"],
        ["Human Resource Management", "How would you rate your expertise in Human Resource Management?"],
        ["Supply Chain Management", "How would you rate your expertise in Supply Chain Management?"],
        ["International Business", "How would you rate your expertise in International Business?"],
        ["Entrepreneurship", "How would you rate your expertise in Entrepreneurship?"],
        ["Corporate Law", "How would you rate your expertise in Corporate Law?"],
        ["Organizational Behavior", "How would you rate your expertise in Organizational Behavior?"],
        ["Risk Management", "How would you rate your expertise in Risk Management?"],
        ["Business Analytics", "How would you rate your expertise in Business Analytics?"],
        ["Financial Planning", "How would you rate your expertise in Financial Planning?"]
    ];

    const options = [
        "Not Interested",
        "Poor",
        "Beginner",
        "Neutral",
        "Modestly Curious",
        "Developing Interest",
        "Profoundly Interested"
    ];

    let currentQuestion = 0;
    let questions = [];

    function showQuestion(questionIndex) {
        const questionDiv = document.createElement("div");
        questionDiv.className = "question-container";

        const questionText = document.createElement("h3");
        questionText.textContent = questions[questionIndex][0];

        questionDiv.appendChild(questionText);

        const questionName = questions[questionIndex][0];

        for (let i = 0; i < options.length; i++) {
            const radioInput = document.createElement("input");
            radioInput.type = "radio";
            radioInput.id = `${questionName.replace(/\s+/g, '')}${i + 1}`;
            radioInput.name = questionName.replace(/\s+/g, '');
            radioInput.value = `option${i + 1}`;
            radioInput.className = "form-check-input";

            const label = document.createElement("label");
            label.htmlFor = `${questionName.replace(/\s+/g, '')}${i + 1}`;
            label.className = "form-check-label";
            label.textContent = options[i];

            const formCheck = document.createElement("div");
            formCheck.className = "form-check";
            formCheck.appendChild(radioInput);
            formCheck.appendChild(label);

            questionDiv.appendChild(formCheck);
        }

        const questionnaire = document.getElementById("questionnaire");
        questionnaire.innerHTML = "";
        questionnaire.appendChild(questionDiv);
    }

    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const submitBtn = document.getElementById("submitBtn");

    prevBtn.addEventListener("click", () => {
        currentQuestion--;
        showQuestion(currentQuestion);
        nextBtn.disabled = false;
        submitBtn.style.display = "none";
        if (currentQuestion === 0) {
            prevBtn.disabled = true;
        }
    });

    nextBtn.addEventListener("click", () => {
        currentQuestion++;
        if (currentQuestion < questions.length) {
            showQuestion(currentQuestion);
        } else {
            nextBtn.disabled = true;
            submitBtn.style.display = "block";
        }
        prevBtn.disabled = false;
    });

    const highSchoolCourseRadios = document.getElementsByName("highSchoolCourse");
    for (const radio of highSchoolCourseRadios) {
        radio.addEventListener("change", () => {
            if (radio.value === "science") {
                document.getElementById("scienceOrEngineering").style.display = "block";
                document.getElementById("question2").style.display = "none";
            } else {
                questions = Commerce;
                currentQuestion = 0;
                showQuestion(currentQuestion);
                nextBtn.disabled = false;
                prevBtn.disabled = true;
                submitBtn.style.display = "none";
                document.getElementById("scienceOrEngineering").style.display = "none";
                document.getElementById("question2").style.display = "none";
            }
        });
    }

    const scienceOrEngineeringRadios = document.getElementsByName("scienceOrEngineering");
    for (const radio of scienceOrEngineeringRadios) {
        radio.addEventListener("change", () => {
            if (radio.value === "science") {
                questions = Science;
            } else {
                questions = Engineering;
            }
            currentQuestion = 0;
            showQuestion(currentQuestion);
            nextBtn.disabled = false;
            prevBtn.disabled = true;
            submitBtn.style.display = "none";
            document.getElementById("scienceOrEngineering").style.display = "none";
            document.getElementById("question2").style.display = "block";
        });
    }
</script>
</body>

</html>