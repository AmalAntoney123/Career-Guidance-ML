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


        <style>
            .question-container-main {
                position: relative;
            }

            .question-container {
                position: absolute;
                top: 0;
                width: 100%;
                opacity: 0;
                transform: translateX(-20px);
                transition: opacity 0.4s, transform 1.0s;
            }

            .question-container.active {
                opacity: 1;
                transform: translateX(0);
            }

            .question-nav {
                position: absolute;
                display: flex;
                top: 320px;
                justify-content: space-between;
            }

            /* Center the card and make it more rounded */
            .card {
                border-radius: 20px;
            }

            /* Increase the text size */
            .card-title,
            .card-text {
                font-size: 1.2em;
                /* Adjust the font size as needed */
            }

            /* Give a background color to the body */
            body.bg-light {
                background-color: #f8f9fa;
                /* Light grey background */
            }

            /* Center the navigation buttons */
            .question-nav {
                justify-content: center;
            }
        </style>

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
                                <i class="fas fa-user-circle me-2"></i><?= ucwords($fullName) ?>
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

        <main id="main" style="height:500px;">

            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <form id="questionForm" method="post">
                            <div class="question-container-main">
                                <!-- Question 1 -->
                                <div class="card mb-3 question-container bg-light active" id="question1">
                                    <div class="card-body">
                                        <h5 class="card-title">Hi <?=ucwords($fullName)?></h5>
                                        <p class="card-text">What course did u pursue in highschool?</p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="options1" id="option2-1"
                                                value="commerce">
                                            <label class="form-check-label" for="option2-1">Commerce</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="options1" id="option2-2"
                                                value="science">
                                            <label class="form-check-label" for="option2-2">Science</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="options1" id="option2-2"
                                                value="maths">
                                            <label class="form-check-label" for="option2-2">Maths</label>
                                        </div>

                                        <!-- Add more options as needed -->
                                    </div>
                                </div>
                                <!-- Question 2 -->
                                <div class="card mb-3 question-container bg-light" id="question2">
                                    <div class="card-body">
                                        <h5 class="card-title">Hi <?=ucwords($fullName)?></h5>
                                        <p class="card-text">How much do you enjoy delving into the basics of managing digital information?</p>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="options2" id="option2-1"
                                                value="option1">
                                            <label class="form-check-label" for="option2-1">Not Interested</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="options2" id="option2-2"
                                                value="option2">
                                            <label class="form-check-label" for="option2-2">Poor</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="options2" id="option2-2"
                                                value="option2">
                                            <label class="form-check-label" for="option2-2">Beginner</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="options2" id="option2-2"
                                                value="option2">
                                            <label class="form-check-label" for="option2-2">Neutral</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="options2" id="option2-2"
                                                value="option2">
                                            <label class="form-check-label" for="option2-2">Modestly Curious</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="options2" id="option2-2"
                                                value="option2">
                                            <label class="form-check-label" for="option2-2">Developing Interest</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="options2" id="option2-2"
                                                value="option2">
                                            <label class="form-check-label" for="option2-2">Profoundly Interested</label>
                                        </div>
                                        <!-- Add more options as needed -->
                                    </div>
                                </div>
                                <div>
                                    <!-- Add more questions as needed -->
                                    <div class="d-flex justify-content-between mt-3 question-nav">
                                        <button class="btn btn-secondary" type="button" id="prevBtn">Previous</button>&nbsp;
                                        <button class="btn btn-warning" type="button" id="nextBtn">Next</button>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>


        </main><!-- End #main -->

        <!-- ======= Footer ======= -->
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
                                    &copy; Copyright <strong><span>Career-Vertex</span></strong>. All Rights Reserved
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
            let currentQuestionIndex = 1;

            document.getElementById('prevBtn').addEventListener('click', function () {
                if (currentQuestionIndex > 1) {
                    document.getElementById(`question${currentQuestionIndex}`).classList.remove('active');
                    currentQuestionIndex--;
                    document.getElementById(`question${currentQuestionIndex}`).classList.add('active');
                }
            });

            document.getElementById('nextBtn').addEventListener('click', function () {
                if (currentQuestionIndex < 2) { // Adjust this number based on the total number of questions
                    document.getElementById(`question${currentQuestionIndex}`).classList.remove('active');
                    currentQuestionIndex++;
                    document.getElementById(`question${currentQuestionIndex}`).classList.add('active');
                }
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