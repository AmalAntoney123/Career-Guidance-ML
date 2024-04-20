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

        <title>Career-Vertex User Profile</title>
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
                    <div class="col-md-3">
                        <div class="list-group">
                            <a href="#" class="list-group-item list-group-item-action active">Profile</a>
                            <a href="career_view.php" class="list-group-item list-group-item-action">Career Path</a>
                        </div>
                        <!-- HTML for Bootstrap Toast -->
                        <div class="toast mt-5" id="toast" role="alert" aria-live="assertive" aria-atomic="true"
                            data-delay="5000">
                            <div class="toast-header">
                                <strong class="me-auto">Notification</strong>
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                            <div class="toast-body">
                                Field updated successfully!
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="card rounded">
                            <div class="card-body">
                                <div class="row">

                                    <div class="col-md-12">
                                        <form id="profileForm">
                                            <div class="form-group">
                                                <label for="name">Name:</label>
                                                <input type="text" class="form-control" id="name" name="full_name"
                                                    value="<?php echo $fullName; ?>" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email:</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="<?php echo $email; ?>" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="age">Age:</label>
                                                <input type="number" class="form-control" id="age" value="<?php echo $age; ?>"
                                                    name="age" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="gender">Gender:</label>
                                                <select class="form-select" id="gender" name="gender" required disabled>
                                                    <option value="male" <?php if($gender=='male') echo'selected'?>>Male</option>
                                                    <option value="female" <?php if($gender=='female') echo'selected'?>>Female</option>
                                                    <option value="other" <?php if($gender=='other') echo'selected'?>>Other</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="place">Place:</label>
                                                <input type="text" class="form-control" id="place" name="place"
                                                    value="<?php echo $place; ?>" disabled>
                                            </div>
                                            <div class="form-group">
                                                <label for="education">Education Level:</label>
                                                <input type="text" class="form-control" id="education"
                                                    name="education_level" value="<?php echo $educationLevel; ?>" disabled>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label for="password">Password:</label>
                                                <input type="password" class="form-control" id="password"
                                                    placeholder="********" disabled>
                                            </div> -->
                                            <button type="button" class="btn btn-warning updateBtn" onclick="enableForm()"
                                                id="updateBtn">Update
                                                Profile</button>
                                            <button type="button" class="btn btn-warning saveBtn" style="display:none"
                                                onclick="disableForm()" id="saveBtn">
                                                Save</button>
                                        </form>
                                        <script>
            // Function to update user profile data via AJAX
            function updateUserProfile(field, value) {
                $.ajax({
                    url: 'update_profile.php',
                    type: 'POST',
                    data: { field: field, value: value },
                    success: function (response) {
                        // Show toast notification
                        showToast('Value updated successfully!');
                        console.log(response);
                    }
                });
            }

            // Function to show toast notification
            function showToast(message) {
                // Implement toast notification display here (using Bootstrap Toast or any other library)
                // For example, using Bootstrap 5 Toast component:
                var toastEl = document.getElementById('toast');
                var bsToast = new bootstrap.Toast(toastEl);
                toastEl.querySelector('.toast-body').textContent = message;
                bsToast.show();
            }

            // Event listener for input field blur
            $('input, select').blur(function () {
                var fieldName = $(this).attr('name');
                var fieldValue = $(this).val();
                // Call updateUserProfile function when the input field loses focus
                updateUserProfile(fieldName, fieldValue);
                console.log(hello);

            });
            function enableForm() {
                var form = document.getElementById('profileForm');
                var inputs = form.getElementsByTagName('input');
                var genderform = document.getElementById('gender');
                for (var i = 0; i < inputs.length; i++) {
                    inputs[i].disabled = false;
                }
                $('.updateBtn').hide();
                $('.saveBtn').show();
                genderform.disabled=false;
            }
            function disableForm() {
                var form = document.getElementById('profileForm');
                var inputs = form.getElementsByTagName('input');
                var genderform = document.getElementById('gender');
                for (var i = 0; i < inputs.length; i++) {
                    inputs[i].disabled = true;
                }
                $('.updateBtn').show();
                $('.saveBtn').hide();
                genderform.disabled=true;
            }
        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
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


    </body>

    </html>

    <?php
} else {
    // Handle case where user data is not found
    header("Location: index.php");
}
?>