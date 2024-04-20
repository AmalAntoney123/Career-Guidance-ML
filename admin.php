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

    if ($fullName != "admin")
        header('Location: user.php');

    $users = $userCollection->find([
        'full_name' => ['$ne' => 'admin']
    ]);



    // Select the collections
    $feedbackCollection = $careerDb->feedback;

    // Get all feedback data
    $feedbackCursor = $feedbackCollection->find();
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
            button.active {
                background-color: #feb900 !important;
            }
            button.active:hover {
                background-color: #eeb900 !important;
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

        <main class="container">
            <div class="card m-4 p-4 bg-light">
                <ul class="nav nav-pills d-flex justify-content-center" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active mx-3 text-black" id="user-management-tab" data-bs-toggle="tab"
                            data-bs-target="#user-management" type="button" role="tab" aria-controls="user-management"
                            aria-selected="true">User Management</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link mx-3 text-black" id="feedback-tab" data-bs-toggle="tab" data-bs-target="#feedback"
                            type="button" role="tab" aria-controls="feedback" aria-selected="false">Feedback</button>
                    </li>
                </ul>
            </div>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="user-management" role="tabpanel"
                    aria-labelledby="user-management-tab">
                    <div class="card m-4 p-4 bg-light">
                        <h3 class="mb-4">User Management</h3>
                        <table class="table table-striped rounded-3 overflow-hidden table-bordered ">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Place</th>
                                    <th>Education Level</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?php echo $user['full_name']; ?></td>
                                        <td><?php echo $user['email']; ?></td>
                                        <td><?php echo $user['age']; ?></td>
                                        <td><?php echo $user['gender']; ?></td>
                                        <td><?php echo $user['place']; ?></td>
                                        <td><?php echo $user['education_level']; ?></td>
                                        <td id="status-<?php echo $user['_id']; ?>">
                                            <?php echo $user['isActive'] ? 'Active' : 'Inactive'; ?>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input toggle-switch" type="checkbox" role="switch"
                                                    id="switch-<?php echo $user['_id']; ?>" <?php echo $user['isActive'] ? 'checked' : ''; ?> data-user-id="<?php echo $user['_id']; ?>">
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tab-pane fade" id="feedback" role="tabpanel" aria-labelledby="feedback-tab">
                    <div class="card m-4 p-4 bg-light">
                        <h3 class="mb-4">Feedback</h3>
                        <table class="table table-striped rounded-3 overflow-hidden table-bordered ">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Feedback</th>
                                    <th>Rating</th>
                                    <th>Place</th>
                                    <th>Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($feedbackCursor as $feedback): ?>
                                    <?php
                                    $user = $userCollection->findOne(
                                        ["_id" => new MongoDB\BSON\ObjectId($feedback["user_id"])]
                                    );

                                    if ($user):
                                        $feedbackTimestamp = $feedback["timestamp"]->toDateTime()->format("Y-m-d H:i:s");
                                        $userTimestamp = $user["timestamp"]->toDateTime()->format("Y-m-d H:i:s");
                                        ?>
                                        <tr>
                                            <td><?php echo $user["full_name"] . " (" . $user["email"] . ")"; ?></td>
                                            <td><?php echo $feedback["feedback"]; ?></td>
                                            <td>
                                                <?php
                                                $rating = $feedback["rating"];
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($i <= $rating) {
                                                        echo '<i class="fas fa-star text-warning"></i>'; // Solid golden star
                                                    } else {
                                                        echo '<i class="far fa-star text-warning"></i>'; // Bordered star
                                                    }
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo $user["place"]; ?></td>
                                            <td><?php echo $feedbackTimestamp; ?></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
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
        <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script> -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

        <script>
            $(document).ready(function () {
                $('.toggle-switch').on('change', function () {
                    var userId = $(this).data('user-id');
                    var isActive = $(this).is(':checked');
                    var row = $(this).closest('tr');
                    var statusCell = row.find('#status-' + userId);

                    $.ajax({
                        url: 'update_status.php',
                        type: 'POST',
                        data: {
                            userId: userId,
                            isActive: isActive
                        },
                        success: function (response) {
                            statusCell.text(isActive ? 'Active' : 'Inactive');

                            // Update the checkbox state in case of success
                            row.find('.toggle-switch').prop('checked', isActive);
                            // alert(response)
                        },
                        error: function () {
                            alert('Error updating status');
                        }
                    });
                });
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