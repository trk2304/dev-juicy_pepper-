<?php

require_once("classes/post.php");

$post = new Post();

?>

<!doctype html>
<html lang="en">
<head>
    <title>PHP and MySQL Testing Environment</title>
</head>

<body>
    <h1>Test of TinyMCE Content Storage in Database</h1>


    <?php
        $article = $post->getPost(27);

        $content = $article['content'];

        $title = $article['title'];

        $content = htmlspecialchars_decode($content);
        $title = htmlspecialchars_decode($title);

        echo "<h3>$title</h3><br>";
        echo "<p>$content</p>";

    ?>

    <h1>Testing Display of All Rows</h1>

    <?php

        $posts = Post::getAllPosts();
        
        echo "<pre>";
        print_r($posts);
        echo "</pre>";
        
    ?>
</body>
</html>