<?php include 'header.php'; ?>
<?php include 'sidebar.php'; ?>

<?php

    $post = new Post();

    //Ensure that all form items are filled.

    if ( isset($_POST['addpost']) ) {
        $success = false;

        $title = htmlspecialchars($_POST['title']);
        $content = htmlspecialchars($_POST['content']);

        // Be sure to remove slashes when drawing information from the Database!!
        if( $post->insertPost($title, $content) )
            $success = true;

        // Redirect back to same page. This will fix the POST re-submission problem on refresh.
        header("Location: addPost.php");
    }
?>

<main class="col-md-10" style="padding: 15px;">
    <h1 class="display-4" style="color: white; border-bottom: 1px solid white; padding-bottom: 6px;">Add a Post</h1>

    <div id="success">
        <?php
            if( isset($success) && $success == true ) {
                echo "<h4>Successfully Published New Blog Post</h4>";
            }
        ?>
    </div>

    <form method="POST" action="addPost.php" style="margin-top: 15px;" onsubmit="return check()">
            
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Title" name="title" id="title" required>
        </div>
        
        <textarea id="editor" cols="30" rows="10" style="width: 100%; height: 400px" name="content" placeholder="Place your Post Content Here"></textarea>
        <br>

        
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="addpost" value="Publish"></button>
        </div>

    </form>

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
    </script>

    
</main>
</div> <!-- to close off the div in sidebar.php -->

<?php include 'footer.php'; ?>