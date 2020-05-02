<?php require_once('../classes/post.php'); ?>
<?php include 'header.php'; ?>

<?php 
    // Create a new post instance.
    $post_obj = new Post();

    // Get all posts
    $all_posts = Post::getAllPosts();

    // Be prepared to print the design of each post object in php soon.
?>

<!-- Jumbotron -->
<div class="jumbotron jumbotron-fluid hero-archive">
  <div class="container hero-container-archive">
    <h1 class="display-4">Post Archive</h1>
  </div>
</div>

<!-- List of all posts -->
<div class="container post-list">
    
   <!-- <div class="post">
        <h2>Title of Post</h2>
        <p><small>Written by Caitlin Ledford</small></p>

        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Accusantium est, veniam iure deserunt incidunt atque nesciunt necessitatibus dolores sequi, labore unde voluptatum facere aspernatur nobis velit at sint corporis nemo...</p>
        <a class="btn btn-primary" href="view.php?id=?">Read more</a>
    </div> -->

    <?php

        foreach($all_posts as $blog_post) {
            $id = $blog_post['id'];
            $title = htmlspecialchars_decode($blog_post['title']);
            $content = htmlspecialchars_decode($blog_post['content']);
            $date = $blog_post['date'];

            // Get excerpt
            if($content != strip_tags($content)) {
                $content = strip_tags($content);
            }

            //Limit Content to N characters for the purpose of creating an excerpt.
            $excerpt = (strlen($content) > 300 ?  substr($content, 0, 300).'...' : $content);

            // Format Date correctly (Code from stack overflow)
            $time = strtotime($date);
            $formatted_date = date("m/d/y", $time);

            echo "<div class='post'>
                    <h2>$title</h2>
                    <p><small>Written by Caitlin Ledford on $formatted_date</small></p>

                    <p>$excerpt</p>

                    <a class='btn bg-prim' style='color: white;' href='view.php?id=$id'>Read More</a>
                  </div> <hr>";
        }

    ?>

</div>

<?php include 'footer.php'; ?>