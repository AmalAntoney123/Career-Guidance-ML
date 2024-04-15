<!DOCTYPE html>
<html lang="en">
<?php
session_start(); // Start the session to access $_SESSION['user']
require 'vendor/autoload.php';

// Connect to MongoDB
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$careerDb = $mongoClient->careerDb;
$userCollection = $careerDb->user;

// Fetch user data based on $_SESSION['user']
$userData = $userCollection->findOne(['_id' => $_SESSION['user']]);

// Check if user data is found
if ($userData) {
    // Extract user information from $userData
    $fullName = $userData['full_name'];
    $email = $userData['email'];
    $age = $userData['age'];
    $gender = $userData['gender'];
    $place = $userData['place'];
    $educationLevel = $userData['education_level'];
    // No need to populate password field as it's sensitive information

    // Now, echo the HTML form with the populated values
    ?>

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>Career-Vertex User Career</title>
        <meta content="" name="description">
        <meta content="" name="keywords">


        <link href="assets/img/favicon.png" rel="icon">
        <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">


        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,600;1,700&family=Roboto:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&family=Work+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
            rel="stylesheet">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">


        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
        <link href="assets/vendor/aos/aos.css" rel="stylesheet">
        <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
        <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">


        <link href="assets/css/main.css" rel="stylesheet">
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    </head>

    <body>
        <header class="bg-dark text-white p-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-10">
                        <h3>Career Vertex</h3>
                    </div>
                    <div class="col-md-2 text-right">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle  ml-1"></i><?= ucwords($fullName) ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="index.php">Home</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <main id="main">
            <div class="container mt-5">
                <div class="card bg-light">
                    <div class="card-body">
                        <form id="questionnaireForm" method="get" action="process.php">
                            <div id="questionnaire">
                                <div class="question-container">
                                    <h3>What course did you pursue in high school?</h3>
                                    <div class="form-check bg-white rounded p-3 pl-5">
                                        <input class="form-check-input ml-1" type="radio" name="highSchoolCourse"
                                            id="science" value="science">
                                        <label class="form-check-label h6 ml-4" for="science">Science</label>
                                    </div>
                                    <div class="form-check bg-white rounded p-3 mt-2">
                                        <input class="form-check-input ml-1" type="radio" name="highSchoolCourse"
                                            id="commerce" value="commerce">
                                        <label class="form-check-label h6 ml-4" for="commerce">Commerce</label>
                                    </div>
                                </div>
                                <div class="question-container mt-5" id="scienceOrEngineering" style="display: none;">
                                    <h3>Are you interested in pursuing a degree in science or engineering?</h3>
                                    <div class="form-check bg-white rounded p-3">
                                        <input class="form-check-input ml-1" type="radio" name="scienceOrEngineering"
                                            id="scienceDegree" value="science">
                                        <label class="form-check-label h6 ml-4" for="scienceDegree">Science</label>
                                    </div>
                                    <div class="form-check bg-white rounded p-3 mt-2">
                                        <input class="form-check-input ml-1" type="radio" name="scienceOrEngineering"
                                            id="engineeringDegree" value="engineering">
                                        <label class="form-check-label h6 ml-4" for="engineeringDegree">Engineering</label>
                                    </div>
                                </div>
                                <div class="card mb-3 question-container bg-light" id="question2" style="display: none;">
                                    <div class="card-body">
                                        <h6 class="card-title">Hi <?= ucwords($fullName) ?></h6>
                                        <p class="card-text">How much do you enjoy delving into the basics of managing
                                            digital
                                            information?
                                        </p>
                                        <div class="form-check bg-white rounded p-3">
                                            <input class="form-check-input  ml-1" type="radio" name="Database" id="option2-1"
                                                value="option1">
                                            <label class="form-check-label h6 ml-4" for="option2-1">Not Interested</label>
                                        </div>
                                        <div class="form-check bg-white rounded p-3 mt-2">
                                            <input class="form-check-input  ml-1" type="radio" name="Database" id="option2-2"
                                                value="option2">
                                            <label class="form-check-label h6 ml-4" for="option2-2">Poor</label>
                                        </div>
                                        <div class="form-check bg-white rounded p-3 mt-2">
                                            <input class="form-check-input  ml-1" type="radio" name="Database" id="option2-3"
                                                value="option3">
                                            <label class="form-check-label h6 ml-4" for="option2-3">Beginner</label>
                                        </div>
                                        <div class="form-check bg-white rounded p-3 mt-2">
                                            <input class="form-check-input  ml-1" type="radio" name="Database" id="option2-4"
                                                value="option4">
                                            <label class="form-check-label h6 ml-4" for="option2-4">Neutral</label>
                                        </div>
                                        <div class="form-check bg-white rounded p-3 mt-2">
                                            <input class="form-check-input  ml-1" type="radio" name="Database" id="option2-5"
                                                value="option5">
                                            <label class="form-check-label h6 ml-4" for="option2-5">Modestly Curious</label>
                                        </div>
                                        <div class="form-check bg-white rounded p-3 mt-2">
                                            <input class="form-check-input  ml-1" type="radio" name="Database" id="option2-6"
                                                value="option6">
                                            <label class="form-check-label h6 ml-4" for="option2-6">Developing Interest</label>
                                        </div>
                                        <div class="form-check bg-white rounded p-3 mt-2">
                                            <input class="form-check-input  ml-1" type="radio" name="Database" id="option2-7"
                                                value="option7">
                                            <label class="form-check-label h6 ml-4" for="option2-7">Profoundly Interested</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="container my-3">
                <div class="d-flex justify-content-between">
                    <button type="button" id="prevBtn" class="btn btn-secondary" disabled>Previous</button>
                    <a type="button" id="resetBtn" class="btn btn-warning" href="test2.php">Reset</a>
                    <button type="button" id="nextBtn" class="btn btn-danger">Next</button>
                    <button type="submit" id="submitBtn" class="btn btn-success" style="display: none;">Submit</button>
                </div>
            </div>
        </main><!-- End #main -->


        <footer id="footer" class="footer">

            <div class="footer-content position-relative">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-4 col-md-6">
                            <div class="footer-info">
                                <h3>Career-Vertex</h3>
                                <!--<p>
A108 Adam Street <br>
NY 535022, USA<br><br>
<strong>Phone:</strong> +1 5589 55488 55<br>
<strong>Email:</strong> info@example.com<br>
</p>-->
                                <div class="social-links d-flex mt-3">
                                    <a href="#" class="d-flex align-items-center justify-content-center"><i
                                            class="bi bi-twitter"></i></a>
                                    <a href="#" class="d-flex align-items-center justify-content-center"><i
                                            class="bi bi-facebook"></i></a>
                                    <a href="#" class="d-flex align-items-center justify-content-center"><i
                                            class="bi bi-instagram"></i></a>
                                    <a href="#" class="d-flex align-items-center justify-content-center"><i
                                            class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-3 footer-links">
                            <h4>Useful Links</h4>
                            <ul>
                                <li><a href="#">Home</a></li>
                                <li><a href="#">About us</a></li>
                                <li><a href="#">Services</a></li>
                                <li><a href="#">Terms of service</a></li>
                                <li><a href="#">Privacy policy</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-2 col-md-3 footer-links">
                            <h4>Our Services</h4>
                            <ul>
                                <li><a href="#">Web Design</a></li>
                                <li><a href="#">Web Development</a></li>
                                <li><a href="#">Product Management</a></li>
                                <li><a href="#">Marketing</a></li>
                                <li><a href="#">Graphic Design</a></li>
                            </ul>
                        </div>

                        <div class="footer-legal text-center position-relative">
                            <div class="container">
                                <div class="copyright">
                                    &copy; Copyright <strong><span>Career-Vertex</span></strong>. All Rights
                                    Reserved
                                </div>
                                <div class="credits">


                                </div>
                            </div>
                        </div>

        </footer>
        <!-- End Footer -->

        <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>

        <div id="preloader"></div>

        <!-- Vendor JS Files -->
        <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/vendor/aos/aos.js"></script>
        <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
        <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
        <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
        <script src="assets/vendor/php-email-form/validate.js"></script>
        <!-- Template Main JS File -->
        <script src="assets/js/main.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>
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

            let userResponses = {};
            let currentQuestion = 0;
            let questions = [];

            function showQuestion(questionIndex) {
                const questionDiv = document.createElement("div");
                questionDiv.className = "question-container";

                const questionText = document.createElement("h3");
                questionText.textContent = questions[questionIndex][1];

                questionDiv.appendChild(questionText);

                const questionName = questions[questionIndex][0];

                for (let i = 0; i < options.length; i++) {
                    const radioInput = document.createElement("input");
                    radioInput.type = "radio";
                    radioInput.id = `${questionName.replace(/\s+/g, '')}${i + 1}`;
                    radioInput.name = questionName.replace(/\s+/g, '');
                    radioInput.value = `option${i + 1}`;
                    radioInput.className = "form-check-input ml-1";

                    const label = document.createElement("label");
                    label.htmlFor = `${questionName.replace(/\s+/g, '')}${i + 1}`;
                    label.className = "form-check-label h6 ml-4";
                    label.textContent = options[i];

                    radioInput.addEventListener("change", () => {
                        if (radioInput.checked) {
                            userResponses[questionName] = options[i];
                        }
                    });
                    const formCheck = document.createElement("div");
                    formCheck.className = "form-check bg-white rounded p-3 m-2";
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
                nextBtn.style.display = "block";
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
                    nextBtn.style.display = "none";
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

            submitBtn.addEventListener("click", (event) => {
                event.preventDefault(); // Prevent the default form submission

                // Convert the userResponses object to a query string
                const queryString = Object.entries(userResponses)
                    .map(([key, value]) => `${encodeURIComponent(key)}=${encodeURIComponent(value)}`)
                    .join("&");

                // Append the query string to the form action URL
                const formAction = `${document.getElementById("questionnaireForm").action}?${queryString}`;

                // Submit the form with the updated action URL
                window.location.href = formAction;
            });

            
        </script>
    </body>


    </html>

    <?php
} else {
    // Handle case where user data is not found
    header("Location: index.php");
}
?>