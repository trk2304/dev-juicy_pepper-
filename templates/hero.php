<!-- Temporarily include header.php so that you can see changes being made. When everything is set how you want, go ahead and remove it from this file -->

<div class="jumbotron jumbotron-fluid hero-main">
  <div class="container hero-container-main">
    <h1 class="display-4">The Juicy Pepper</h1>
    <p class="lead">A blog for all things food, friends, fitness, & fun.</p>

    <!-- Redirect to login -->
    <?php
      if ( !isset( $_SESSION['user'] ) || $_SESSION['user'] != 'admin' ) {
        echo "<a href='archive.php' class='btn bg-sec btn-lg btn-hero'>Let's Dive In!</a>";
      }
    ?>
  </div>
</div>