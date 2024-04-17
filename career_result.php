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
<?php if(!isset($_POST['career'])){ header('Location:career_quiz.php');} ?>

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
            <div class="container my-5">
                <div class="card bg-light">
                    <div class="card-body">
                        <h3 class="card-title">Careers in <span id="subject"></span></h3>
                        <p class="card-text h-5">Based on the analysis, here are three potential career paths you can
                            explore:
                        </p>
                        <div class="d-flex flex-column align-items-center" id="career-buttons">
                        </div>
                        <p class="card-text h-5">Choose one and we can continue</p>

                    </div>
                </div>
            </div>
            <style>
                .career-button {
                    width: 350px;
                }
            </style>
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
            career = {
                "Physics": ["Physicist", "Optical Engineer", "Materials Scientist"],
                "Chemistry": ["Chemist", "Pharmaceutical Scientist", "Environmental Scientist"],
                "Biology": ["Biologist", "Medical Researcher", "Environmental Consultant"],
                "Mathematics": ["Mathematician", "Data Analyst", "Financial Analyst"],
                "Environmental_Science": ["Environmental Engineer", "Sustainability Coordinator", "Natural Resource Manager"],
                "Astronomy": ["Astronomer", "Satellite Engineer", "Science Communicator"],
                "Medicine": ["Physician", "Pharmacist", "Biomedical Engineer"],
                "Pharmacology": ["Pharmacologist", "Clinical Research Coordinator", "Pharmaceutical Sales Representative"],
                "Biochemistry": ["Biochemist", "Biotechnology Researcher", "Food Scientist"],

                "Mechanical Engineering": ["Mechanical Engineer", "Product Designer", "Robotics Engineer"],
                "Electrical Engineering": ["Electrical Engineer", "Computer Hardware Engineer", "Renewable Energy Specialist"],
                "Civil Engineering": ["Civil Engineer", "Urban Planner", "Construction Manager"],
                "Chemical Engineering": ["Chemical Engineer", "Process Engineer", "Environmental Engineer"],
                "Computer Engineering": ["Computer Hardware Engineer", "Software Developer", "Network Administrator"],
                "Aerospace Engineering": ["Aerospace Engineer", "Satellite Technician", "Aviation Maintenance Technician"],
                "Biomedical Engineering": ["Biomedical Engineer", "Medical Device Designer", "Prosthetics Specialist"],
                "Environmental Engineering": ["Environmental Engineer", "Sustainability Consultant", "Renewable Energy Engineer"],
                "Industrial Engineering": ["Industrial Engineer", "Production Manager", "Logistics Coordinator"],
                "Software Engineering": ["Software Engineer", "Mobile App Developer", "Cybersecurity Specialist"],

                "Accounting": ["Chartered Accountant", "Financial Analyst", "Auditor"],
                "Finance": ["Financial Advisor", "Investment Banker", "Financial Analyst"],
                "Economics": ["Economist", "Policy Analyst", "Market Researcher"],
                "Business Management": ["Business Manager", "Entrepreneur", "Operations Manager"],
                "Marketing": ["Marketing Manager", "Brand Manager", "Digital Marketing Specialist"],
                "Human Resource Management": ["HR Manager", "Talent Acquisition Specialist", "Training and Development Coordinator"],
                "Supply Chain Management": ["Supply Chain Manager", "Logistics Coordinator", "Procurement Analyst"],
                "International Business": ["International Business Consultant", "Export-Import Manager", "Global Marketing Specialist"],
                "Entrepreneurship": ["Startup Founder", "Small Business Owner", "Social Entrepreneur"],
                "Corporate Law": ["Corporate Lawyer", "Compliance Officer", "Contract Negotiator"],
                "Organizational Behavior": ["Organizational Development Consultant", "Change Management Specialist", "HR Business Partner"],
                "Risk Management": ["Risk Analyst", "Insurance Underwriter", "Corporate Risk Manager"],
                "Business Analytics": ["Business Analyst", "Data Scientist", "Business Intelligence Consultant"],
                "Financial Planning": ["Financial Planner", "Wealth Manager", "Investment Advisor"],

                "History": ["Historian", "Museum Curator", "Archivist"],
                "Literature": ["Writer", "Editor", "Copywriter"],
                "Philosophy": ["Philosopher", "Ethics Consultant", "Policy Analyst"],
                "Art_History": ["Art Historian", "Curator", "Art Conservator"],
                "Cultural_Studies": ["Cultural Anthropologist", "Diversity and Inclusion Specialist", "Intercultural Trainer"],
                "Religious_Studies": ["Religious Scholar", "Chaplain", "Interfaith Coordinator"],
                "Linguistics": ["Linguist", "Language Translator", "Speech Therapist"],
                "Archaeology": ["Archaeologist", "Heritage Conservationist", "Museum Educator"],
                "Anthropology": ["Anthropologist", "Social Researcher", "Cultural Advisor"],
                "Performing_Arts": ["Performing Artist", "Drama Therapist", "Arts Administrator"]
            };
            const predictedProfession = "<?= $_POST['career'] ?>"; // Replace with the actual predicted profession
            const subjectElement = document.getElementById('subject');
            const careerButtonsElement = document.getElementById('career-buttons');

            // Set the subject in the card title
            subjectElement.textContent = predictedProfession;

            // Generate the career buttons
            const careers = career[predictedProfession];
            careers.forEach(career => {
                const button = document.createElement('a');
                button.classList.add('btn', 'btn-warning', 'btn-lg', 'm-1', 'career-button');
                button.textContent = career;
                button.href = '#';
                careerButtonsElement.appendChild(button);
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