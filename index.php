<?php
session_start();
include_once("includes/config.php");
include_once("includes/functions.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PodPlay - Podcasts Platform</title>
    <link href="assets/css/output.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="min-h-screen flex flex-col bg-gray-50 pb-24">
    <?php include("includes/navbar.php"); ?>
    
    <main class="flex-grow container mx-auto px-4 py-6 space-y-6" id="mainContent">
        <?php 
        $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        
        // Authentication check for restricted pages
        $restricted_pages = ['listen'];
        if (in_array($page, $restricted_pages) && !isset($_SESSION['user_id'])) {
            echo "<script>
                alert('Please login to access this feature');
                window.location.href = 'index.php?page=login';
            </script>";
            exit;
        }
        
        switch($page) {
            case 'home':
                include("pages/home.php");
                break;
            case 'login':
                include("pages/login.php");
                break;
            case 'register':
                include("pages/register.php");
                break;
            case 'listen':
                include("pages/listen.php");
                break;
            case 'podcast':
                include("pages/podcast.php");
                break;
            default:
                include("pages/home.php");
                break;
        }
        ?>
    </main>
    
    <?php 
    // Only include player if user is logged in
    if(isset($_SESSION['user_id'])) {
        include("includes/player.php");
    }
    ?>

    <script src="assets/js/app.js"></script>
</body>
</html>
