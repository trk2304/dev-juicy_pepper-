<?php
    require_once('comment.php');

    // Check to see that the id is set.
    if( isset($_GET['viewid']) ) {
        
        // Create a new comment object
        $comment_object = new Comment();

        // Assign the article id to a variable to be passed cleanly into the object's method
        $article_id = $_GET['viewid'];

        // Call the method, store the comments for the blog post in $comments
        $comments = $comment_object->getCommentsById($article_id);

        // Encode and send off.
        echo json_encode($comments);
    }
?>