<?php
    require_once('../classes/post.php');
    session_start();
?>

<!doctype html>
<html lang="en">
<head>

    <title>Welcome to The Juicy Pepper</title>

    <!-- DON'T FORGET TO ADD BOOTSTRAP CORE JS -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Media Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/custom.css">

    

</head>
<body>

<!-- Be sure to include navigation bar here too -->

<!-- Navigation -->
<!-- Borrowed from getbootstrap.com component documentation -->
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-prim">
    <div class="container">
        <a class="navbar-brand" href="#">The Juicy Pepper</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
                <li class="nav-item active">
                    <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="archive.php">Archive</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="foodApp.php">New Recipe Ideas</a>
                </li>

                <?php
                    if( !isset($_SESSION['user']) || $_SESSION['user'] != 'admin' ) {
                    
                        echo "
                        <li class='nav-item active'>
                            <a class='nav-link' href='login.php'>Admin Log in</a>
                        </li>
                        ";

                    }
                ?>

                <?php 
                    if ( isset($_SESSION['user']) && $_SESSION['user'] == 'admin' ) {
                        echo "<li class='nav-item active'>
                                <a class='nav-link' href='../admin/addPost.php'>Admin Dash</a>
                              </li>";
                    }
                ?>

            </ul>
            
        </div>
    </div>
</nav>