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
    $fullName = $userData['full_name'];
    $email = $userData['email'];
    $age = $userData['age'];
    $gender = $userData['gender'];
    $place = $userData['place'];
    $educationLevel = $userData['education_level'];

    $careerCollection = $careerDb->career;
    $userCareer = $careerCollection->findOne(['user_id' => $_SESSION['user']]);

    if (isset($_POST['reset_career'])) {
        // Delete the user's career entry from the collection
        $careerCollection->deleteOne(['user_id' => $_SESSION['user']]);

        // Redirect the user to the career_quiz.php page
        header("Location: career_view.php");
        exit;
    }
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
            .circle {
                font-weight: bold;
                padding: 15px 20px;
                border-radius: 50%;
                background-color: #feb900;
                color: #4D4545;
                max-height: 50px;
                z-index: 2;
            }

            .how-it-works.row {
                display: flex;
            }

            .how-it-works.row .col-2 {
                display: inline-flex;
                align-self: stretch;
                align-items: center;
                justify-content: center;
            }

            .how-it-works.row .col-2::after {
                content: "";
                position: absolute;
                border-left: 3px solid #feb900;
                z-index: 1;
            }

            .how-it-works.row .col-2.bottom::after {
                height: 50%;
                left: 50%;
                top: 50%;
            }

            .how-it-works.row .col-2.full::after {
                height: 100%;
                left: calc(50% - 3px);
            }

            .how-it-works.row .col-2.top::after {
                height: 50%;
                left: 50%;
                top: 0;
            }

            .timeline div {
                padding: 0;
                height: 40px;
            }

            .timeline hr {
                border-top: 3px solid #feb900;
                margin: 0;
                top: 17px;
                position: relative;
            }

            .timeline .col-2 {
                display: flex;
                overflow: hidden;
            }

            .timeline .corner {
                border: 3px solid #feb900;
                width: 100%;
                position: relative;
                border-radius: 15px;
            }

            .timeline .top-right {
                left: 50%;
                top: -50%;
            }

            .timeline .left-bottom {
                left: -50%;
                top: calc(50% - 3px);
            }

            .timeline .top-left {
                left: -50%;
                top: -50%;
            }

            .timeline .right-bottom {
                left: 50%;
                top: calc(50% - 3px);
            }
        </style>

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
                                <i class="fas fa-user-circle me-2"></i><?= ucwords($fullName) ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="user.php">Profile</a></li>
                                <li><a class="dropdown-item" href="index.php">Home</a></li>
                                <?php if ($fullName === 'admin'): ?>
                                    <li><a class="dropdown-item" href="admin.php">Admin Panel</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                <?php endif; ?>
                                <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main id="main">
            <div class="container my-4">
                <div class="row">
                    <div class="col-md-3 mt-3">
                        <div class="list-group">
                            <a href="user.php" class="list-group-item list-group-item-action">Profile</a>
                            <a href="#" class="list-group-item list-group-item-action active">Career Path</a>
                        </div>
                    </div>
                    <?php
                    if ($userData && $userCareer) {
                        $careerPath = $userCareer['career'];
                        $coursePathData = $careerDb->coursePath->findOne(['careerPath' => $careerPath]);

                        if ($coursePathData) {
                            $ugDegree = $coursePathData['data']['UGDegree'];
                            $pgDegree = $coursePathData['data']['PGDegree'];
                            $certifications = $coursePathData['data']['Certifications'];
                            $universities = $coursePathData['data']['Universities']->getArrayCopy();
                            ?>
                            <div class="col-md-9 mt-3">
                                <div class="card h-100 d-flex justify-content-center align-items-center bg-light p-5">
                                    <div class="container-fluid blue-bg">
                                        <div class="container">
                                            <h2 class="pb-3 pt-2"><?= $userCareer['career'] ?> Career Path</h2>
                                            <hr>

                                            <!--first section-->
                                            <div class="row align-items-center how-it-works">
                                                <div class="col-2 text-center bottom">
                                                    <div class="circle">1</div>
                                                </div>
                                                <div class="col-6">
                                                    <h5><?= $ugDegree ?></h5>
                                                    <ul>
                                                        <?php
                                                        $universityCount = count($universities);
                                                        $maxUniversities = 2; // Maximum universities to display in the first step
                                                        $displayedUniversities = 0;
                                                        foreach ($universities as $university) {
                                                            if ($displayedUniversities < $maxUniversities) {
                                                                ?>
                                                                <li><?= $university ?></li>
                                                                <?php
                                                                $displayedUniversities++;
                                                            } else {
                                                                break;
                                                            }
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                            </div>

                                            <!--path between 1-2-->
                                            <div class="row timeline">
                                                <div class="col-2">
                                                    <div class="corner top-right"></div>
                                                </div>
                                                <div class="col-8">
                                                    <hr />
                                                </div>
                                                <div class="col-2">
                                                    <div class="corner left-bottom"></div>
                                                </div>
                                            </div>

                                            <!--second section-->
                                            <div class="row align-items-center justify-content-end how-it-works">
                                                <div class="col-6 text-right">
                                                    <h5><?= $pgDegree ?></h5>
                                                    <ul>
                                                        <?php
                                                        $remainingUniversities = array_slice($universities, $maxUniversities);
                                                        foreach ($remainingUniversities as $university) {
                                                            ?>
                                                            <li><?= $university ?></li>
                                                            <?php
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                                <div class="col-2 text-center full">
                                                    <div class="circle">2</div>
                                                </div>
                                            </div>

                                            <!--path between 2-3-->
                                            <div class="row timeline">
                                                <div class="col-2">
                                                    <div class="corner right-bottom"></div>
                                                </div>
                                                <div class="col-8">
                                                    <hr />
                                                </div>
                                                <div class="col-2">
                                                    <div class="corner top-left"></div>
                                                </div>
                                            </div>

                                            <!--third section-->
                                            <div class="row align-items-center how-it-works">
                                                <div class="col-2 text-center top">
                                                    <div class="circle">3</div>
                                                </div>
                                                <div class="col-6">
                                                    <h5>Certifications</h5>
                                                    <ul>
                                                        <?php foreach ($certifications as $certification) { ?>
                                                            <li><?= $certification ?></li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-end mt-3">
                                                    <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal"
                                                        data-bs-target="#resetCareerModal">
                                                        Reset Career
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        } else {
                            // Handle case where user's career path data does not exist in the coursePath collection
                            ?>
                            <div class="col-md-9 mt-3">
                                <div class="h-100 w-100 d-flex justify-content-center align-items-center">
                                    <div class="card rounded bg-light">
                                        <div class="card-body">
                                            <div class="container my-5">
                                                <div class="row">
                                                    <div class="col-md-12 text-center">
                                                        <h4>Oops! Your career path data is not available.</h4>
                                                        <a href="career_quiz.php" class="btn btn-primary btn-lg">Find Your
                                                            Career</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        // Handle case where user's career data does not exist
                        ?>
                        <div class="col-md-9 mt-3">
                            <div class="h-100 w-100 d-flex justify-content-center align-items-center" style="width:100%">
                                <div class="card rounded bg-light">
                                    <div class="card-body">
                                        <div class="container my-5">
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <h4>Oops! You haven't defined your career path yet.</h4>
                                                    <a href="career_quiz.php" class="btn btn-warning btn-lg">Find Your
                                                        Career</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </main>

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
        <!-- reset modal -->
        <div class="modal fade" id="resetCareerModal" tabindex="-1" aria-labelledby="resetCareerModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resetCareerModalLabel">Reset Career</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to reset your career path? This action cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form action="career_view.php" method="post">
                            <input type="hidden" name="reset_career" value="true">
                            <button type="submit" class="btn btn-danger">Reset Career</button>
                        </form>
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