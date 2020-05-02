<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

<?php

if(isset($_POST['delete'])) {

    if(!isset($_POST['id'])) {
        echo "<script>
            alert('Uh oh...Something went wrong. Contact your web master.');
        </script>";

        // Force log out in the future.
        header('Location: deletePost.php');
    }
    
    // Make a post class instance.
    $post = new Post();

    // Get the checked checkboxes.
    $selections = $_POST['id'];

    // If the selections aren't activated for some reason, don't delete them.
   
    // Set a counter to count how many rows are deleted.
    $i = 0;

    // Delete all rows selected
    foreach($selections as $choice) {
        $post->deletePost($choice);
        $i++;
    }

    // If $i does not equal the size of the checkbox array, something is missing.
    
    $missing = sizeof($selections) - $i;
    
    if($i != sizeof($selections)) {
        echo "<script>
            alert('Failed to remove $missing posts. Contact the web master.');
        </script>";
    } else {
        echo "<script>
            alert('Successfully removed $i posts.');
        </script>";
    }

    //On success, redirect to deletePost.php
    header("Location: deletePost.php");
}
?>


<main class="col-md-10" style="padding: 15px;" id="top">

    <h1 class="display-4" style="color: white; border-bottom: 1px solid white; padding-bottom: 6px;">Remove a Post</h1>

    <!-- Display all Blog Posts -->

    <form method="POST" action="deletePost.php" onsubmit='return formCheck();'>
        <div class="scrollTable">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                    <th scope="col"></th>
                    <th scope="col">Post ID</th>
                    <th scope="col">Title</th>
                    <th scope="col">Excerpt</th>
                    <th scope="col">Published Date</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php
                        //Iterate through all rows in the database to display posts that can be deleted.

                        // 1. Get all posts in a multi-demensional array.
                        $all_posts = Post::getAllPosts();

                        $post_count = sizeof($all_posts);

                        // 2. Display a row with checkbox, id, title, preview of content, and date.
                        for($i = 0; $i < $post_count; $i++) {

                            $id = $all_posts[$i]['id'];
                            $title = htmlspecialchars_decode($all_posts[$i]['title']);
                            $content = htmlspecialchars_decode($all_posts[$i]['content']);


                            // Check to see if the content has styles. If they do, remove them, as they're not needed when displaying a table.
                            if($excerpt != strip_tags($excerpt)) {
                                $content = strip_tags($content);
                            }

                            //Limit Content to N characters for the purpose of creating an excerpt.
                            $excerpt = (strlen($content) > 50 ?  substr($content, 0, 50).'...' : $content);
                            
                            $date = $all_posts[$i]['date'];

                            echo "
                                <tr>
                                    <td><input type='checkbox' name='id[]' value='$id'></td>
                                    <td>$id</td>
                                    <td>$title</td>
                                    <td>$excerpt</td>
                                    <td>$date</td>
                                </tr>
                            ";
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <input type="submit" class="btn btn-warning" name="delete" value="Delete Posts">
        <a href="#top" class="btn btn-secondary">Back to top</a>
    </form>

</main>
</div> <!-- to close off sidebar -->

<script>
    // Check to see if anything was selected.
   
    // Code from stackoverflow.
    function formCheck() {
        var textinputs = document.querySelectorAll('input[type=checkbox]'); 
        var empty = [].filter.call( textinputs, function( el ) {
        return !el.checked
        });

        if (textinputs.length == empty.length) {
            alert("None filled");
            return false;
        }
        return true;
    }

</script>


<?php include 'footer.php'; ?>