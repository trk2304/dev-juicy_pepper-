<!-- Temporarily include header and hero. After, remove them and add features to index.php -->

<?php

/**
 * Focus on getting the first two posts' information for the features.
 */

 // Create a post object
 $post = new POST();

 $firstTwo = $post->getMostRecentTwo();

 $postOne = $firstTwo[0];
 $postTwo = $firstTwo[1];

 $oneID = $postOne['id'];
 $oneTitle = $postOne['title'];
 $oneContent = $postOne['content'];
 $oneDate = $postOne['date'];

 // Modify the dates and contents to excerpt.
 $oneTime = strtotime($oneDate);
 $one_formatted_date = date("m/d/y", $oneTime);

 $oneContent = htmlspecialchars_decode($oneContent);

 // Get excerpt
 if($oneContent != strip_tags($oneContent)) {
  $oneContent = strip_tags($oneContent);
}

//Limit Content to N characters for the purpose of creating an excerpt.
$oneExcerpt = (strlen($oneContent) > 300 ?  substr($oneContent, 0, 100).'...' : $oneContent);

 $twoID = $postTwo['id'];
 $twoTitle = $postTwo['title'];
 $twoContent = $postTwo['content'];
 $twoDate = $postTwo['date'];

 // Modify the dates and contents to excerpt.
 $twoTime = strtotime($twoDate);
 $two_formatted_date = date("m/d/y", $twoTime);

 $twoContent = htmlspecialchars_decode($twoContent);

  // Get excerpt
  if($twoContent != strip_tags($twoContent)) {
    $twoContent = strip_tags($twoContent);
  }
  
  //Limit Content to N characters for the purpose of creating an excerpt.
  $twoExcerpt = (strlen($twoContent) > 300 ?  substr($twoContent, 0, 100).'...' : $twoContent);
?>

<br>

<!-- Start featured posts section -->
<main id="feature-sec" class="container">
    <h2>Most recent posts</h2>
    <p class="lead">See what's been happening lately.</p>
    <hr><br>

    <!-- Featured Post Design borrowed from getbootstrap.com -->

    <div class="row mb-2">
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 box-shadow h-md-250">
            <div class="card-body d-flex flex-column align-items-start">
              <h3 class="mb-0">
                <a class="text-dark" href="view.php?id=<?php echo $oneID; ?>"><?php echo $oneTitle; ?></a>
              </h3>
              <div class="mb-1 text-muted">Posted on <?php echo $one_formatted_date; ?></div>
              <p class="card-text mb-auto"><?php echo $oneExcerpt; ?></p>
              <a href="view.php?id=<?PHP echo $oneID; ?>">Continue reading</a>
            </div>
            <img class="card-img-right flex-auto d-none d-md-block" src="https://via.placeholder.com/200x250.png" alt="Card image cap">
          </div>
        </div>
        <div class="col-md-6">
          <div class="card flex-md-row mb-4 box-shadow h-md-250">
            <div class="card-body d-flex flex-column align-items-start">
              <h3 class="mb-0">
                <a class="text-dark" href="view.php?id=<?PHP echo $twoID; ?>"><?php echo $twoTitle; ?></a>
              </h3>
              <div class="mb-1 text-muted">Posted on <?php echo $one_formatted_date; ?></div>
              <p class="card-text mb-auto"><?php echo $twoExcerpt; ?></p>
              <a href="view.php?id=<?PHP echo $twoID; ?>">Continue reading</a>
            </div>
            <img class="card-img-right flex-auto d-none d-md-block" src="https://via.placeholder.com/200x250.png" alt="Card image cap">
          </div>
        </div>
      </div>
    </div>
</main>

<br>