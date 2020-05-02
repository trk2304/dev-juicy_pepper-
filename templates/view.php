<?php include 'header.php'; ?>
<?php 
    require_once('../classes/post.php');
    require_once('../classes/comment.php');

    // Create new post instance and a new comment instance.
    $post = new Post();

    // Was the get request even sent?
    if( !isset($_GET['id']) ) {
        header("Location: archive.php");
    }

    // If so...
    $id = $_GET['id'];

    //Get ready to grab article info based on value of $id.
    $blog_post = $post->getPost($id);

    //Assign appropriate values
    $title = htmlspecialchars_decode($blog_post['title']);
    $content = htmlspecialchars_decode($blog_post['content']);
    $date = $blog_post['date'];
    
    // Format Date correctly (Code from stack overflow)
    $time = strtotime($date);
    $formatted_date = date("m/d/y", $time);

    /**
     * You can also go ahead and get all comments that have already been associated with this particular view.
     * Do this with AJAX.
     * 
     * Start by sending the XMLHttpRequest via GET to a PHP script. You can send the article_id to that script.
     * 
     * In that script, you'll create an associative array to house the results of
     * a preceding query (which has been defined in the Comments class.)
     * 
     * From there, you can organize that information into a JSON object, shit it back out to the client, and display that 
     * information in a <div class=""></div> tag with Javascript.
     * 
     *
     * 
     */
    
    /**
     * Now focus on dealing with the form...
     * 
     */

    if( isset($_POST['comment_posted']) ) {
        
        $comment_name = $_POST['screen_name'];
        $comment_content = $_POST['comment_content'];

        // Halt any injection attempts. This will also be handled client-side.
        $comment_name = htmlspecialchars($comment_name, ENT_QUOTES, "UTF-8");
        $comment_content = htmlspecialchars($comment_content, ENT_QUOTES, "UTF-8");

        $comment_object = new Comment();

        $comment_object->addComment($id, $comment_name, $comment_content);

        header("Location: view.php?id=$id");
    }
?>

<div class="container" id="view">
    <h1><?php echo $title;?></h1>

    <p><small>Written by Caitlin Ledford on <?php echo $formatted_date; ?></small></p>

    <p><?php echo $content; ?></p>

    <br>
    <hr>
    <br>

    <h3>Comments <span id="comment-count"></span></h3>
    <br>

    <!-- This is where all of the comments will be written to in AJAX -->
    <div id="all-comments">

    </div>

    <br><br>

    <h3>Leave a comment!</h3>
    <div class="comment-form">
        <form method="POST" onsubmit="return checkComment();">
            <input type="text" class="form-control" id="screen_name" name='screen_name' placeholder='Name' required>
            <small class="form-text text-muted">Don't worry, you don't need an account to comment.</small>
            <br>

            <div class="form-group">
                <textarea class="form-control" id="comment_content" name="comment_content" maxlength="500" placeholder="Tell me what you think!" rows="3" required></textarea>
            </div>

            <input type="submit" class="btn bg-prim" value="Post comment" name="comment_posted">
        </form>
    </div>

    <script>

        /**
        * This function is going to make an AJAX call every 500ms to get all comments for THIS blog post.
        */
        function getCommentsById() {
            let id = "<?php echo $id; ?>";
            x = new XMLHttpRequest();
            x.onreadystatechange = function() {
                if(this.readyState == 4 && this.status == 200) {
                    let comments = JSON.parse(this.responseText);

                    /**
                    * Unpack data from php script and organize it to be printed in HTML
                    */
                    let commentString = "";

                    for(let i = 0; i < comments.length; i++) {
                        let user = comments[i]['name'];
                        let content = comments[i]['content'];
                        let date = comments[i]['date'];

                        // This method of converting the timestamp from MySQL format to
                        // a more readable one comes from stackoverflow.

                        // Split timestamp into [ Y, M, D, h, m, s ]
                        let t = date.split(/[- :]/);

                        // Apply each element to the Date function
                        let d = new Date(Date.UTC(t[0], t[1]-1, t[2], t[3], t[4], t[5]));



                        commentString += "<div class='comment'>";
                        commentString += "<h4>" + user + "</h4>";
                        commentString += "<p><small>Commented on " + d + "</small></p>";
                        commentString += "<p>" + content + "</p>";

                        commentString += "</div>";
                    }

                    // Write the comments to the appropriate comment section div
                    document.getElementById('all-comments').innerHTML = commentString;
                    document.getElementById('comment-count').innerHTML = "(" + String(comments.length) + ")";
                }
            };
            x.open("GET", "../classes/view_commenthandler.php?viewid="+id, true);
            x.send();
        }

      

        /**
        * This will be used to validate the comment form on the client's side.
        */
        function checkComment() {
            let name = document.getElementById('screen_name');
            let content = document.getElementById('comment_content');

            // Start by checking the name.
            if( name.match(/(<([^>]+)>)/g) ) {
                alert('You have illegal characters in your input.');
                return false;
            }

            if( content.match(/(<([^>]+)>)/g) ) {
                alert('Your comment content has illegal input.');
                return false;
            }
            return true;
        }

        /**
        * Setting an interval, as this should be constantly looking to retrieve comments without the user having to refresh.
        */
        window.setInterval(getCommentsById, 500);

    </script>

</div>

<br>

<?php include 'footer.php'; ?>