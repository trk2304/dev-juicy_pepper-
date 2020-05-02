<?php include 'header.php'; ?>

<div class="jumbotron jumbotron-fluid hero-api">
  <div class="container hero-container-api">
    <h1 class="display-4">r/Food Cooking Inspiration</h1>
  </div>
</div>

<br>

<!-- All API stuff is going here -->
<div class="container">

    <h3 style="text-align: center; margin-bottom: 5px;">Reddit is a great for finding creative recipes!</h3>
    <p class="lead" style="text-align: center; margin-bottom: 15px;">Click a button below to see food posts from that subreddit</p>

    <div class="subreddit-selection">
        <div class="row mx-auto">
            <div class="col-md-4">
                <button class="btn bg-sec" onclick="redditAPI(this);">r/Food</button>
            </div>
            
            <div class="col-md-4">
                <button class="btn bg-sec" onclick="redditAPI(this);">r/Cooking</button>
            </div>

            <div class="col-md-4">
                <button class="btn bg-sec" onclick="redditAPI(this)">r/RecipeClub</button>
            </div>
        </div>
    </div>

    <br><br>

    <div id="reddit-posts"> 

    </div>
</div>

<script>

    function redditAPI(button) {

        let selection = button.innerHTML;

        x = new XMLHttpRequest();
        x.onreadystatechange = function() {
            if(this.readyState == 4 && this.status == 200) {

                let results = JSON.parse(this.responseText);

                let refinedData = results['data']['children'];
                
                let content_string = '';

                console.log(refinedData);
                
                for(let i = 1; i < refinedData.length; i++) {
                    let post = refinedData[i]['data'];
                    
                    let title = post['title'];
                    let author = post['author'];
                    let body = post['selftext'];
                    let printable_body = post['selftext_html'];
                    let image = post['thumbnail'];
                    let link = post['url'];
                    
                    content_string += "<div class='row'>";
                    content_string += "<div class='col-md-12 id='reddit-post'>";
                    content_string += "<div class='card flex-md-row mb-4 box-shadow h-md-250 r-post'>";
                    content_string += "<div class='card-body d-flex flex-column align-items-start'>";
                    content_string += "<strong class='d-inline-block mb-2 text-prim'>" + selection + "</strong>";
                    content_string += "<h3 class='mb-0'>";
                    content_string += "<a class='text-dark' href='" + link + "' target='_blank'>" + title + "</a>";
                    content_string += "</h3>";
                    content_string += "<div class='mb-1 text-muted'>Posted by u/" + author + "</div>";
                    content_string += "<p class='card-text mb-auto'>" + body + "</p>";
                    content_string += "<a href='" + link + "'>" + "See Full Post" + "</a>";
                    content_string += "</div>";
                    
                    if(image != "null" && image != 'self' && image != '')
                        content_string += "<img class='card-img-right flex-auto d-none d-md-block' src='"+ image +"' alt='Card image cap'>";

                    content_string += "</div>";
                    content_string += "</div>";
                    content_string += "</div>";         
                }

                document.getElementById('reddit-posts').innerHTML = content_string;
            }
        };
        x.open(
            "GET",
            "http://www.reddit.com/" + selection + "/hot.json?sort=hot",
            true
        );
        x.send();
    }

    window.setInterval(redditAPI, 500);
</script>

<?php include 'footer.php'; ?>