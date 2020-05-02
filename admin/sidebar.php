
<div class="row h-100">
    <aside class="col-12 col-md-2 p-0 bg-dark" id='sidebar'>
        <nav class="navbar navbar-expand navbar-dark bg-dark flex-md-column flex-row align-items-start">
            <a class="navbar-brand" href="addPost.php">Admin Dashboard</a>
            <div class="collapse navbar-collapse" id="link-container">
                <ul class="flex-md-column flex-row navbar-nav w-100 justify-content-between">
                    
                    <li class="nav-item">
                        <a class="nav-link pl-0" href="addPost.php">Add a New Post</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link pl-0" href="editPost.php">Edit an Existing Post</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link pl-0" href="deletePost.php">Delete an Existing Post</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link pl-0" href="deleteComment.php">Delete an Existing Comment</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link pl-0" href="../templates/index.php">Visit Site</a>
                    </li>

                    <!-- <li class="nav-item">
                        <a class="nav-link pl-0" href="#">Log Out</a>
                    </li> -->

                    <form action="logout.php" method="POST" id="logout">
                        <input type="submit" class="btn btn-warning" id="logout-btn" name=logout" value="Log Out">
                    </form>
                    
                </ul>
            </div>
        </nav>
    </aside>
    

<!-- There's a closing div tag that should end here to close off <div class="row h-100">. Be sure to include it in either the footer or each page that contains content   -->
