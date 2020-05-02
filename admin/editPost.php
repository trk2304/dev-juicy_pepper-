<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

<?php
    $post = new Post();

    if ( isset($_POST['editpost']) ) {

        // Undo HTML entity correction for apostrophes

        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);
        $id = $_POST['articleid'];

        // Be sure to remove slashes when drawing information from the Database!!
        if( $post->updatePost($title, $content, $id) )
            echo "<script>alert('Successfully Published Post Titled \"$title\"');</script>";
        else
            echo "<script>alert('Failed to Publish Post Titled \"$title\"');</script>";
    }
?>


<main class="col-md-10" style="padding: 15px;">
    <h1 class="display-4" style="color: white; padding-bottom: 3px; border-bottom: 1px solid white;">Edit Posts</h1>
    
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
                                <tr id='$id'>
                                    <td><a class='btn btn-primary' onclick='fillEditor($id)' href='#editForm'>Edit</button></a>
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

    <form method="POST" action="editPost.php" style="margin-top: 15px;" id="editForm" onsubmit="return check()">
            
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Title" name="title" id="title" required>
        </div>

        <div class="form-group">
            <input type="text" class="form-control" placeholder="Article ID" name="articleid" id="articleid" required hidden>
        </div>
        
        <textarea id="editor" cols="30" rows="10" style="width: 100%; height: 400px" name="content" placeholder="Place your Post Content Here"></textarea>
        <br>

        
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="editpost" value="Re-Publish"></button>
        </div>

    </form>

    <!-- Some form validation for editing posts. The admin shouldn't be able to submit when fields are empty -->
    <script>
        function check() {
            let content = tinymce.get('#editor').getContent();
            if(content == '') {
                alert("You cannot leave the content field blank. If you want to remove a post, do so through the 'Delete Existing Post' option.")
                return false;
            }
            return true;
        }
    </script>

</main>
</div>

<script>
      /**
       * This is the initializer for the TinyMCE iFrame
       */
      tinymce.init({
        selector: '#editor',
        plugins: "lists",
        toolbar: 'numlist bullist italic bold'
      });

      /**
       * This function is a quick remedy to combat the issue of the admin attempting to submit before filling out their blog content.
       */
      function check() {
        var editorContent = tinyMCE.get('editor').getContent();

        if(editorContent == '') {
            alert('You must fill out the blog post content.');
            return false;
        }

        let title = document.getElementById('title').value;

        if(title == '') {
            alert('You must fill out the blog post title');
            return false;
        }

        return true;
      }

      /**
      * Whena  row is clicked to edit, the content of that article is placed in the editor to be edited.
      */
      function fillEditor(rowID) {
        x = new XMLHttpRequest();
        x.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            let article = JSON.parse(this.responseText);

            console.log(article);

            document.getElementById('title').value = htmlDecode(article['title']);
            document.getElementById('articleid').value = article['id'];
            tinymce.get('editor').setContent(htmlDecode(article['content']));
        }
        };
        x.open("GET", "getPost.php?getPostById="+rowID, true);
        x.send();
      }

      /**
      * This is a neat function I found on CSS-Tricks.com. It's essentially the same as PHP's htmlspecialchars_decode(), but for JS.
      */
      function htmlDecode(input){
        var e = document.createElement('div');
        e.innerHTML = input;
        return e.childNodes.length === 0 ? "" : e.childNodes[0].nodeValue;
    }


</script>

<?php include 'footer.php'; ?>