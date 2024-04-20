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
        <style type="text/css">
            .course-item:hover {
                background-color: #e0e0e0;
                cursor: pointer;
            }
        </style>
    </head>

    <body>


        <header class="bg-dark text-white p-4">
            <div class="container">
                <div class="row">
                    <div class="col-md-10">
                        <a href="."><h3>Career Vertex</h3></a>
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
    <?php if ($fullName === 'admin'): ?>
        <li><a class="dropdown-item" href="admin.php">Admin Panel</a></li>
        <li><hr class="dropdown-divider"></li>
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
                            $universities = $coursePathData['data']['Universities'];
                            ?>

                            <div class="col-md-9 mt-3">
                                <div class="h-100 d-flex justify-content-center align-items-center">
                                    <div class="card rounded bg-light">
                                        <div class="card-body">
                                            <div class="container my-5">
                                                <h3><?= $userCareer['career'] ?> Career Path</h3>
                                                <div class="row mt-3">
                                                    <div class="col-md-12">
                                                        <div class="card mb-3">
                                                            <div class="card-body course-item">
                                                                <i class="fas fa-graduation-cap"></i> <?= $ugDegree ?>
                                                            </div>
                                                            <div class="card-footer text-center">
                                                                <i class="fas fa-arrow-down"></i>
                                                            </div>
                                                        </div>
                                                        <div class="card mb-3">
                                                            <div class="card-body course-item">
                                                                <i class="fas fa-graduation-cap"></i> <?= $pgDegree ?>
                                                            </div>
                                                            <div class="card-footer text-center">
                                                                <i class="fas fa-arrow-down"></i>
                                                            </div>
                                                        </div>

                                                        <?php
                                                        $certificationCount = count($certifications);
                                                        foreach ($certifications as $key => $certification) {
                                                            ?>
                                                            <div class="card mb-3">
                                                                <div class="card-body course-item">
                                                                    <i class="fas fa-certificate"></i> <?= $certification ?>
                                                                </div>
                                                                <?php if ($key < $certificationCount - 1) { ?>
                                                                    <div class="card-footer text-center">
                                                                        <i class="fas fa-arrow-down"></i>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <?php
                                                        }
                                                        ?>

                                                    </div>
                                                    <div class="col-md-12"><hr>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <h5 class="card-title"><i class="fas fa-university mr-2"></i>
                                                                    Ideal Universities</h5>
                                                                <ul class="list-group list-group-flush">
                                                                    <?php foreach ($universities as $university) { ?>
                                                                        <li class="list-group-item"><?= $university ?></li>
                                                                    <?php } ?>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-end mt-3">
                                                            <button type="button" class="btn btn-danger btn-lg"
                                                                data-bs-toggle="modal" data-bs-target="#resetCareerModal">
                                                                Reset Career
                                                            </button>
                                                        </div>
                                                    </div>
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
        <!-- modal -->
        <!-- Reset Career Modal -->
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

    </body>

    </html>

    <?php
} else {
    // Handle case where user data is not found
    header("Location: index.php");
}
?>