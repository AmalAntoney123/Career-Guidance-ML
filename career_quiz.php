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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

        <link href="assets/css/main.css" rel="stylesheet">
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    </head>

    <body>
        <header class="bg-dark text-white p-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-10">
                        <a href=".">
                            <h3>Career Vertex</h3>
                        </a>
                    </div>
                    <div class="col-md-2 text-right">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle  ml-1"></i>&nbsp;<?= ucwords($fullName) ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="user.php">Profile</a></li>
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
                                    <div class="form-check bg-white rounded p-3 mt-2">
                                        <input class="form-check-input ml-1" type="radio" name="highSchoolCourse"
                                            id="humanities" value="humanities">
                                        <label class="form-check-label h6 ml-4" for="humanities">Humanities</label>
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
                                            <input class="form-check-input  ml-1" type="radio" name="Database"
                                                id="option2-1" value="option1">
                                            <label class="form-check-label h6 ml-4" for="option2-1">Not Interested</label>
                                        </div>
                                        <div class="form-check bg-white rounded p-3 mt-2">
                                            <input class="form-check-input  ml-1" type="radio" name="Database"
                                                id="option2-2" value="option2">
                                            <label class="form-check-label h6 ml-4" for="option2-2">Poor</label>
                                        </div>
                                        <div class="form-check bg-white rounded p-3 mt-2">
                                            <input class="form-check-input  ml-1" type="radio" name="Database"
                                                id="option2-3" value="option3">
                                            <label class="form-check-label h6 ml-4" for="option2-3">Beginner</label>
                                        </div>
                                        <div class="form-check bg-white rounded p-3 mt-2">
                                            <input class="form-check-input  ml-1" type="radio" name="Database"
                                                id="option2-4" value="option4">
                                            <label class="form-check-label h6 ml-4" for="option2-4">Neutral</label>
                                        </div>
                                        <div class="form-check bg-white rounded p-3 mt-2">
                                            <input class="form-check-input  ml-1" type="radio" name="Database"
                                                id="option2-5" value="option5">
                                            <label class="form-check-label h6 ml-4" for="option2-5">Modestly Curious</label>
                                        </div>
                                        <div class="form-check bg-white rounded p-3 mt-2">
                                            <input class="form-check-input  ml-1" type="radio" name="Database"
                                                id="option2-6" value="option6">
                                            <label class="form-check-label h6 ml-4" for="option2-6">Developing
                                                Interest</label>
                                        </div>
                                        <div class="form-check bg-white rounded p-3 mt-2">
                                            <input class="form-check-input  ml-1" type="radio" name="Database"
                                                id="option2-7" value="option7">
                                            <label class="form-check-label h6 ml-4" for="option2-7">Profoundly
                                                Interested</label>
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
                    <button type="button" id="prevBtn" class="btn btn-secondary btn-lg" disabled>Previous</button>
                    <a type="button" id="resetBtn" class="btn btn-danger btn-lg" href="career_quiz.php">Reset</a>
                    <button type="button" id="nextBtn" class="btn btn-warning btn-lg">Next</button>
                    <button type="submit" id="submitBtn" class="btn btn-success btn-lg"
                        style="display: none;">Submit</button>
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

        <!-- modal -->
        <div class="modal fade" id="validationModal" tabindex="-1" aria-labelledby="validationModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="validationModalLabel">Please Select an Option</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        You must select an option before proceeding to the next question.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

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

            function shuffleScience(array) {
                for (let i = array.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [array[i], array[j]] = [array[j], array[i]];
                }
                return array;
            }

            Science = [
                ["Physics", "How curious are you to learn more about natural phenomena?", ["No Particular Interest", "Somewhat Interested", "Exploring the Subject", "Moderately Interested", "Very Curious", "Deeply Fascinated", "Extremely Passionate"]],
                ["Chemistry", "To what extent are you eager to understand matter and its properties?", ["Uninterested", "Slightly Interested", "Exploring the Topic", "Moderately Engaged", "Quite Keen", "Proficient in the Subject", "Highly Driven to Learn More"]],
                ["Biology", "How enthusiastic are you to deepen your understanding of living organisms?", ["Uninterested", "Basic Familiarity", "Exploring the Field", "Moderately Interested", "Very Curious", "Advanced Knowledge", "Expert-Level Interest"]],
                ["Mathematics", "How motivated are you to develop your skills in numerical concepts?", ["Not Really Interested", "Beginner-Level Interest", "Exploring the Subject", "Moderately Engaged", "Quite Keen", "Advanced Skills", "Masterful Expertise"]],
                ["Environmental_Science", "How eager are you to expand your knowledge of ecological systems?", ["Uninterested", "Basic Understanding", "Exploring the Topic", "Moderately Confident", "Very Curious", "Proficient in the Subject", "Expert-Level Passion"]],
                ["Astronomy", "To what extent are you driven to understand celestial bodies?", ["No Special Interest", "Basic Familiarity", "Exploring the Field", "Moderately Interested", "Very Curious", "Advanced Knowledge", "Expert-Level Enthusiasm"]],
                ["Medicine", "How motivated are you to learn about health and wellness?", ["Uninterested", "Basic Understanding", "Exploring the Subject", "Moderately Engaged", "Very Curious", "Advanced Knowledge", "Expert-Level Passion"]],
                ["Pharmacology", "How eager are you to deepen your familiarity with drugs and their effects?", ["Uninterested", "Limited Interest", "Exploring the Topic", "Moderately Familiar", "Very Curious", "Proficient in the Subject", "Expert-Level Enthusiasm"]],
                ["Biochemistry", "To what extent are you driven to understand chemical processes in living organisms?", ["No Special Interest", "Basic Familiarity", "Exploring the Field", "Moderately Interested", "Very Curious", "Advanced Knowledge", "Deeply Fascinated"]]
            ];


            Engineering = [
                ["Mechanical_Engineering", "How interested are you in designing and building objects?", ["No Particular Interest", "Limited Interest", "Exploring the Subject", "Moderately Engaged", "Quite Engaged", "Developing Skills", "Highly Skilled Interest"]],
                ["Electrical_Engineering", "How eager are you to work with gadgets and technology?", ["No Special Interest", "Limited Understanding", "Exploring the Topic", "Moderately Confident", "Quite Interested", "Developing Skills", "Expert-Level Enthusiasm"]],
                ["Civil_Engineering", "How motivated are you to plan and construct buildings or bridges?", ["Not My Main Focus", "Basic Interest", "Starting to Explore", "Moderately Engaged", "Very Curious", "Progressing Skills", "Highly Competent Interest"]],
                ["Chemical_Engineering", "How eager are you to learn about mixing and transforming different materials?", ["Not My Area", "Basic Understanding", "Exploring the Subject", "Moderately Familiar", "Quite Inquisitive", "Developing Skills", "Highly Knowledgeable Interest"]],
                ["Computer_Engineering", "How interested are you in developing your understanding of computers and software?", ["Not Fully Engaged", "Limited Interest", "Exploring the Topic", "Moderately Engaged", "Very Curious", "Progressing Skills", "Highly Proficient Interest"]],
                ["Aerospace_Engineering", "To what extent are you driven to learn about aerospace systems and technology?", ["No Special Interest", "Limited Understanding", "Exploring the Field", "Moderately Engaged", "Quite Intrigued", "Advancing Skills", "Expert-Level Enthusiasm"]],
                ["Biomedical_Engineering", "How eager are you to learn about medical equipment and procedures?", ["Not Particularly Interested", "Basic Knowledge", "Exploring the Subject", "Moderately Engaged", "Very Curious", "Improving Skills", "Very Knowledgeable Interest"]],
                ["Environmental_Engineering", "How motivated are you to learn about environmental systems and sustainability?", ["Not My Strength", "Limited Understanding", "Exploring the Topic", "Moderately Engaged", "Quite Interested", "Advancing Skills", "Highly Skilled Interest"]],
                ["Industrial_Engineering", "How eager are you to learn about improving production processes?", ["Not Fully Engaged", "Basic Interest", "Starting to Explore", "Moderately Engaged", "Quite Intrigued", "Progressing Skills", "Highly Competent Interest"]],
                ["Software_Engineering", "How confident are you in developing your skills in computer programming?", ["Not My Focus", "Basic Interest", "Exploring the Subject", "Moderately Engaged", "Very Curious", "Advancing Skills", "Highly Skilled Interest"]]
            ];


            Commerce = [
                ["Accounting", "How comfortable are you with the idea of managing financial records?", ["No Interest", "Limited Interest", "Just Starting to Explore", "Moderately Engaged", "Very Curious", "Improving Skills", "Very Proficient Interest"]],
                ["Finance", "How eager are you to deepen your understanding of financial markets?", ["Not Really", "Basic Understanding", "Exploring the Topic", "Moderately Okay", "Quite Interested", "Developing Skills", "Very Confident Interest"]],
                ["Economics", "To what extent are you driven to learn about economic principles?", ["Not Really My Thing", "Basic Interest", "Starting to Explore", "Moderately Engaged", "Very Curious", "Improving Skills", "Very Knowledgeable Interest"]],
                ["Business_Management", "How interested are you in developing your ability to oversee business operations?", ["Not Really", "Basic Interest", "Just Starting Out", "Moderately Okay", "Quite Interested", "Developing Skills", "Highly Skilled Interest"]],
                ["Marketing", "How eager are you to learn about promoting products and services?", ["Not Really", "Basic Understanding", "Exploring the Topic", "Moderately Okay", "Quite Interested", "Developing Skills", "Very Familiar Interest"]],
                ["Human_Resource_Management", "To what extent are you driven to learn about managing personnel?", ["Not Really", "Basic Understanding", "Exploring the Subject", "Moderately Okay", "Very Curious", "Developing Skills", "Very Knowledgeable Interest"]],
                ["Supply_Chain_Management", "How interested are you in learning about managing product distribution?", ["Not Really", "Basic Interest", "Just Starting Out", "Moderately Okay", "Quite Interested", "Improving Skills", "Highly Skilled Interest"]],
                ["International_Business", "How eager are you to navigate global markets?", ["Not Really", "Basic Understanding", "Exploring the Topic", "Moderately Okay", "Quite Interested", "Advancing Skills", "Very Confident Interest"]],
                ["Entrepreneurship", "To what extent are you prepared to start and run your own business?", ["Not Really", "Basic Interest", "Just Starting Out", "Moderately Okay", "Very Curious", "Developing Skills", "Highly Prepared Interest"]],
                ["Corporate_Law", "How interested are you in learning about legal matters in business?", ["Not Really", "Basic Interest", "Exploring the Subject", "Moderately Okay", "Quite Interested", "Developing Skills", "Very Knowledgeable Interest"]],
                ["Organizational_Behavior", "To what extent are you driven to understand human behavior in organizations?", ["Not Really", "Basic Understanding", "Exploring the Topic", "Moderately Okay", "Very Curious", "Improving Skills", "Very Insightful Interest"]],
                ["Risk_Management", "How eager are you to learn about identifying and mitigating risks in business?", ["Not Really", "Basic Understanding", "Exploring the Subject", "Moderately Okay", "Quite Interested", "Advancing Skills", "Very Familiar Interest"]],
                ["Business_Analytics", "How interested are you in developing your ability to analyze and interpret business data?", ["Not Really", "Basic Interest", "Just Starting Out", "Moderately Okay", "Very Curious", "Improving Skills", "Very Skilled Interest"]],
                ["Financial_Planning", "To what extent are you interested in managing personal or business finances?", ["No Interest", "Limited Interest", "Just Starting to Explore", "Moderately Engaged", "Very Curious", "Improving Skills", "Very Proficient Interest"]]
            ];
            Humanities = [
                ["History", "How interested are you in studying past events and their significance?", ["No Special Interest", "Limited Interest", "Curious to Explore", "Moderately Engaged", "Quite Interested", "Developing Knowledge", "Deeply Intrigued"]],
                ["Literature", "To what extent are you drawn to exploring written works and their meanings?", ["No Special Interest", "Limited Interest", "Curious to Explore", "Moderately Engaged", "Quite Interested", "Developing Understanding", "Deeply Enthralled"]],
                ["Philosophy", "How eager are you to delve into fundamental questions about existence and knowledge?", ["No Special Interest", "Limited Interest", "Curious to Explore", "Moderately Engaged", "Quite Interested", "Developing Insight", "Deeply Philosophical"]],
                ["Art_History", "To what extent are you fascinated by the study of artistic movements and masterpieces?", ["No Special Interest", "Limited Interest", "Curious to Explore", "Moderately Engaged", "Quite Interested", "Developing Knowledge", "Deeply Captivated"]],
                ["Cultural_Studies", "How motivated are you to analyze and understand various cultural phenomena?", ["No Special Interest", "Limited Interest", "Curious to Explore", "Moderately Engaged", "Quite Interested", "Developing Understanding", "Deeply Investigative"]],
                ["Religious_Studies", "How interested are you in exploring different religious beliefs and practices?", ["No Special Interest", "Limited Interest", "Curious to Explore", "Moderately Engaged", "Quite Interested", "Developing Knowledge", "Deeply Intrigued"]],
                ["Linguistics", "To what extent are you fascinated by the study of language and its structures?", ["No Special Interest", "Limited Interest", "Curious to Explore", "Moderately Engaged", "Quite Interested", "Developing Understanding", "Deeply Analytical"]],
                ["Archaeology", "How eager are you to uncover and interpret past human cultures through material remains?", ["No Special Interest", "Limited Interest", "Curious to Explore", "Moderately Engaged", "Quite Interested", "Developing Knowledge", "Deeply Investigative"]],
                ["Anthropology", "To what extent are you driven to understand human societies and cultures?", ["No Special Interest", "Limited Interest", "Curious to Explore", "Moderately Engaged", "Quite Interested", "Developing Understanding", "Deeply Intrigued"]],
                ["Performing_Arts", "How interested are you in participating or studying theatrical or musical performances?", ["No Special Interest", "Limited Interest", "Curious to Explore", "Moderately Engaged", "Quite Interested", "Developing Skills", "Deeply Enthralled"]]
            ]

            Science = shuffleScience(Science);
            Engineering = shuffleScience(Engineering);
            Commerce = shuffleScience(Commerce);
            Humanities = shuffleScience(Humanities);


            let userResponses = {};
            let currentQuestion = 0;
            let questions = [];
            let hasSelectedOption = false;

            function showQuestion(questionIndex) {
                const questionDiv = document.createElement("div");
                questionDiv.className = "question-container";

                const questionText = document.createElement("h3");
                questionText.textContent = questions[questionIndex][1];
                questionText.className = "mb-3";

                questionDiv.appendChild(questionText);

                const questionName = questions[questionIndex][0];
                const options = questions[questionIndex][2];

                for (let i = 0; i < options.length; i++) {
                    const radioInput = document.createElement("input");
                    radioInput.type = "radio";
                    radioInput.id = `${questionName.replace(/\s+/g, '')}${i + 1}`;
                    radioInput.name = questionName.replace(/\s+/g, '');
                    radioInput.value = i + 1;
                    radioInput.className = "form-check-input ml-1";

                    const label = document.createElement("label");
                    label.htmlFor = `${questionName.replace(/\s+/g, '')}${i + 1}`;
                    label.className = "form-check-label h6 ml-4";
                    label.textContent = options[i];

                    radioInput.addEventListener("change", () => {
                        if (radioInput.checked) {
                            userResponses[questionName] = radioInput.value;
                            hasSelectedOption = true;
                        }
                    });
                    if (userResponses[questionName] === radioInput.value) {
                        radioInput.checked = true;
                    }
                    const formCheck = document.createElement("div");
                    formCheck.className = "form-check bg-white rounded p-3 m-2";
                    formCheck.appendChild(radioInput);
                    formCheck.appendChild(label);

                    questionDiv.appendChild(formCheck);
                }

                const questionnaire = document.getElementById("questionnaire");
                questionnaire.innerHTML = "";
                questionnaire.appendChild(questionDiv);

                questionnaire.classList.add("animate__animated", "animate__fadeIn");
                setTimeout(() => {
                    questionnaire.classList.remove("animate__animated", "animate__fadeIn");
                }, 700);
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
                window.scrollTo({ top: 100, behavior: 'smooth' });
            });

            nextBtn.addEventListener("click", () => {
                let hasSelectedOption = false;
                const selectedRadios = document.querySelectorAll(`input[name="${questions[currentQuestion][0].replace(/\s+/g, '')}"]:checked`);
                if (selectedRadios.length > 0) {
                    hasSelectedOption = true;
                    userResponses[questions[currentQuestion][0]] = selectedRadios[0].value;
                }

                if (hasSelectedOption) {
                    currentQuestion++;
                    if (currentQuestion < questions.length) {
                        showQuestion(currentQuestion);
                    } else {
                        nextBtn.disabled = true;
                        submitBtn.style.display = "block";
                        nextBtn.style.display = "none";
                    }
                    prevBtn.disabled = false;
                    window.scrollTo({ top: 130, behavior: 'smooth' });
                } else {
                    $('#validationModal').modal('show');
                }
            });

            const highSchoolCourseRadios = document.getElementsByName("highSchoolCourse");
            for (const radio of highSchoolCourseRadios) {
                radio.addEventListener("change", () => {
                    if (radio.value === "science") {
                        document.getElementById("scienceOrEngineering").style.display = "block";
                        document.getElementById("question2").style.display = "none";
                    } else if (radio.value === "commerce") {
                        questions = Commerce;
                        currentQuestion = 0;
                        showQuestion(currentQuestion);
                        nextBtn.disabled = false;
                        prevBtn.disabled = true;
                        submitBtn.style.display = "none";
                        document.getElementById("scienceOrEngineering").style.display = "none";
                        document.getElementById("question2").style.display = "none";
                    } else {
                        questions = Humanities;
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