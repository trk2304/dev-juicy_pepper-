<?php

    require_once('../classes/post.php');
    require_once('../classes/comment.php');
    

    session_start();
    
    if( isset($_SESSION['user']) ) {
        if( $_SESSION['user'] != 'admin' ) {
            session_destroy();
            header('Location: ../templates/index.php');
        }
    }

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
    <link rel="stylesheet" href="adminstyle.css">

    <!-- Tiny MCE -->
    <!-- If free trial runs out, replace the long string of text with 'no-api-key' -->
    <script src="https://cdn.tiny.cloud/1/qqp7tw1f6mpzzd58de4yvwi6iyin9fcwysfspsn7e547xb0a/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>


</head>
<body>

<div class="container-fluid h-100" id="main-container">
