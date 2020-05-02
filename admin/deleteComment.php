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
    $comment_object = new Comment();

    // Get the checked checkboxes.
    $selections = $_POST['id'];

    // If the selections aren't activated for some reason, don't delete them.
   
    // Set a counter to count how many rows are deleted.
    $i = 0;

    // Delete all rows selected
    foreach($selections as $choice) {
        $comment_object->deleteCommentById($choice);
        $i++;
    }

    // If $i does not equal the size of the checkbox array, something is missing.
    
    $missing = sizeof($selections) - $i;
    
    if($i != sizeof($selections)) {
        echo "<script>
            alert('Failed to remove $missing comments. Contact the web master.');
        </script>";
    } else {
        echo "<script>
            alert('Successfully removed $i comments.');
        </script>";
    }

    // Finish off by sending them back to deleteComment. Don't want to face POST resubmission problem.
    header('Location: deleteComment.php');
}
?>


<main class="col-md-10" style="padding: 15px;" id="top">

    <h1 class="display-4" style="color: white; border-bottom: 1px solid white; padding-bottom: 6px;">Remove Comments</h1>

    <!-- Display all Blog Posts -->

    <form method="POST" action="deleteComment.php" onsubmit='return formCheck();'>
        <div class="scrollTable">
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                    <th scope="col"></th>
                    <th scope="col">Comment ID</th>
                    <th scope="col">User</th>
                    <th scope="col">Comment</th>
                    <th scope="col">Commented on</th>
                    </tr>
                </thead>
                
                <tbody>
                    <?php
                        //Iterate through all rows in the database to display posts that can be deleted.

                        // 1. Get all posts in a multi-demensional array.
                        $all_comments = Comment::getAllComments();

                        $comment_count = sizeof($all_comments);

                        // 2. Display a row with checkbox, id, title, preview of content, and date.
                        for($i = 0; $i < $comment_count; $i++) {

                            $article_id = $all_comments[$i]['article_id'];
                            $comment_id = $all_comments[$i]['comment_id'];
                            $name = htmlspecialchars_decode($all_comments[$i]['name']);
                            $content = htmlspecialchars_decode($all_comments[$i]['content']);


                            // Check to see if the content has styles. If they do, remove them, as they're not needed when displaying a table.
                            if($content != strip_tags($content)) {
                                $content = strip_tags($content);
                            }

                            //Limit Content to N characters for the purpose of creating an excerpt.
                            $excerpt = (strlen($content) > 50 ?  substr($content, 0, 50).'...' : $content);
                            
                            $date = $all_comments[$i]['date'];

                            echo "
                                <tr>
                                    <td><input type='checkbox' name='id[]' value='$comment_id'></td>
                                    <td>$comment_id</td>
                                    <td>$name</td>
                                    <td>$excerpt</td>
                                    <td>$date</td>
                                </tr>
                            ";
                        }
                    ?>
                </tbody>
            </table>
        </div>

        <input type="submit" class="btn btn-warning" name="delete" value="Delete Comments">
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