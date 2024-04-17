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

    if (isset($_GET['Environmental_Science'], $_GET['Mathematics'], $_GET['Medicine'], $_GET['Pharmacology'], $_GET['Physics'], $_GET['Biology'], $_GET['Biochemistry'], $_GET['Astronomy'], $_GET['Chemistry'])) {
        $physics = $_GET['Physics'];
        $environmentalScience = $_GET['Environmental_Science'];
        $mathematics = $_GET['Mathematics'];
        $medicine = $_GET['Medicine'];
        $pharmacology = $_GET['Pharmacology'];
        $biology = $_GET['Biology'];
        $biochemistry = $_GET['Biochemistry'];
        $astronomy = $_GET['Astronomy'];
        $chemistry = $_GET['Chemistry'];

        $scienceArray = [$physics, $chemistry, $biology, $mathematics, $environmentalScience, $astronomy, $medicine, $pharmacology, $biochemistry];
        $arrayString = implode(',', $scienceArray);

        $command = escapeshellcmd('python ml/scienceRecommend.py ' . escapeshellarg($arrayString));
        $predictedProfession = shell_exec($command);
        echo $predictedProfession;
        $predictedProfession = trim($predictedProfession);

        echo '<form id="career-form" method="post" action="career_result.php">';
        echo '<input type="hidden" name="career" value="' . $predictedProfession . '">';
        echo '</form>';

        echo '<script>
    document.getElementById("career-form").submit();
</script>';
    } elseif (isset($_GET['Software_Engineering'], $_GET['Mechanical_Engineering'], $_GET['Chemical_Engineering'], $_GET['Civil_Engineering'], $_GET['Aerospace_Engineering'], $_GET['Biomedical_Engineering'], $_GET['Industrial_Engineering'], $_GET['Electrical_Engineering'], $_GET['Computer_Engineering'], $_GET['Environmental_Engineering'])) {
        $softwareEngineering = $_GET['Software_Engineering'];
        $mechanicalEngineering = $_GET['Mechanical_Engineering'];
        $chemicalEngineering = $_GET['Chemical_Engineering'];
        $civilEngineering = $_GET['Civil_Engineering'];
        $aerospaceEngineering = $_GET['Aerospace_Engineering'];
        $biomedicalEngineering = $_GET['Biomedical_Engineering'];
        $industrialEngineering = $_GET['Industrial_Engineering'];
        $electricalEngineering = $_GET['Electrical_Engineering'];
        $computerEngineering = $_GET['Computer_Engineering'];
        $environmentalEngineering = $_GET['Environmental_Engineering'];

        $engArray = [$mechanicalEngineering, $electricalEngineering, $civilEngineering, $chemicalEngineering, $computerEngineering, $aerospaceEngineering, $biomedicalEngineering, $environmentalEngineering, $industrialEngineering, $softwareEngineering];
        $arrayString = implode(',', $engArray);

        $command = escapeshellcmd('python ml/engineeringRecommend.py ' . escapeshellarg($arrayString));
        $predictedProfession = shell_exec($command);
        echo $predictedProfession;
        $predictedProfession = trim($predictedProfession);

        echo '<form id="career-form" method="post" action="career_result.php">';
        echo '<input type="hidden" name="career" value="' . $predictedProfession . '">';
        echo '</form>';

        echo '<script>
            document.getElementById("career-form").submit();
        </script>';
    } elseif (isset($_GET['Organizational_Behavior'], $_GET['Business_Analytics'], $_GET['International_Business'], $_GET['Economics'], $_GET['Financial_Planning'], $_GET['Business_Management'], $_GET['Entrepreneurship'], $_GET['Corporate_Law'], $_GET['Accounting'], $_GET['Supply_Chain_Management'], $_GET['Risk_Management'], $_GET['Finance'], $_GET['Human_Resource_Management'], $_GET['Marketing'])) {
        $organizationalBehavior = $_GET['Organizational_Behavior'];
        $businessAnalytics = $_GET['Business_Analytics'];
        $internationalBusiness = $_GET['International_Business'];
        $economics = $_GET['Economics'];
        $financialPlanning = $_GET['Financial_Planning'];
        $businessManagement = $_GET['Business_Management'];
        $entrepreneurship = $_GET['Entrepreneurship'];
        $corporateLaw = $_GET['Corporate_Law'];
        $accounting = $_GET['Accounting'];
        $supplyChainManagement = $_GET['Supply_Chain_Management'];
        $riskManagement = $_GET['Risk_Management'];
        $finance = $_GET['Finance'];
        $humanResourceManagement = $_GET['Human_Resource_Management'];
        $marketing = $_GET['Marketing'];

        $commArray = [$accounting, $finance, $economics, $businessManagement, $marketing, $humanResourceManagement, $supplyChainManagement, $internationalBusiness, $entrepreneurship, $corporateLaw, $organizationalBehavior, $riskManagement, $businessAnalytics, $financialPlanning];
        $arrayString = implode(',', $commArray);

        $command = escapeshellcmd('python ml/commerceRecommend.py ' . escapeshellarg($arrayString));
        $predictedProfession = shell_exec($command);
        echo $predictedProfession;
        $predictedProfession = trim($predictedProfession);

        echo '<form id="career-form" method="post" action="career_result.php">';
        echo '<input type="hidden" name="career" value="' . $predictedProfession . '">';
        echo '</form>';

        echo '<script>
            document.getElementById("career-form").submit();
        </script>';
    } elseif (isset($_GET['Literature'], $_GET['Cultural_Studies'], $_GET['Philosophy'], $_GET['Anthropology'], $_GET['History'], $_GET['Linguistics'], $_GET['Performing_Arts'], $_GET['Art_History'], $_GET['Religious_Studies'], $_GET['Archaeology'])) {
        $literature = $_GET['Literature'];
        $culturalStudies = $_GET['Cultural_Studies'];
        $philosophy = $_GET['Philosophy'];
        $anthropology = $_GET['Anthropology'];
        $history = $_GET['History'];
        $linguistics = $_GET['Linguistics'];
        $performingArts = $_GET['Performing_Arts'];
        $artHistory = $_GET['Art_History'];
        $religiousStudies = $_GET['Religious_Studies'];
        $archaeology = $_GET['Archaeology'];

        $humanitiesArray = [$history, $literature, $philosophy, $artHistory, $culturalStudies, $religiousStudies, $linguistics, $archaeology, $anthropology, $performingArts];
        $arrayString = implode(',', $humanitiesArray);

        $command = escapeshellcmd('python ml/humanitiesRecommend.py ' . escapeshellarg($arrayString));
        $predictedProfession = shell_exec($command);
        echo $predictedProfession;
        $predictedProfession = trim($predictedProfession);

        echo '<form id="career-form" method="post" action="career_result.php">';
        echo '<input type="hidden" name="career" value="' . $predictedProfession . '">';
        echo '</form>';
        
        echo '<script>
            document.getElementById("career-form").submit();
        </script>';
    } else {
        echo "Complete the quiz";
    }

    // Define the subjects and their corresponding careers



} else
    header("Location: index.php");

