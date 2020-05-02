<?php
    require_once('../classes/post.php');
    if(isset($_GET['getPostById'])) {
        $post = new Post();
        $requested_article = $post->getPost($_GET['getPostById']);

        $json_object = array("title" => $requested_article['title'], "id" => $requested_article['id'], "content" => $requested_article['content'], "date" => $requested_article['date']);

        echo json_encode($json_object);
    }
?>