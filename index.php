<?php
use App\Social\Socialwall;
require __DIR__.'/app/App.php';
App::load();
require __DIR__.'/vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0">
    <title>Social Wall</title>
    <link rel="stylesheet" type="text/css" href="css/social.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>



<?php
/**
* DEMO ALL
**/
/*    $socialwall = new Socialwall('hashtag', 'facebook_name');
    foreach($socialwall->getAll() as $all){
        echo "Username : ".$all->username."<br>";
        echo "Date : ".$all->date_created."<br>";
        echo "Content : ".$all->content."<br>";
        echo "Likes : ".$all->likes."<br>";
        echo "RT : ".$all->rt."<br>";
        echo "Source : ".$all->source."<br>";
        echo "<img src='".$all->img."' alt='' title=''>";
        echo "<br><br>";
    }*/
/**
* DEMO INSTAGRAM
**/
/*    $socialwall = new Socialwall('hashtag', '');
    foreach($socialwall->getInstagram() as $instagram){
        echo "Username : ".$instagram->username."<br>";
        echo "Date : ".$instagram->date_created."<br>";
        echo "Content : ".$instagram->content."<br>";
        echo "Likes : ".$instagram->likes."<br>";
        echo "RT : ".$instagram->rt."<br>";
        echo "Source : ".$instagram->source."<br>";
        echo "<img src='".$instagram->img."' alt='' title=''>";
        echo "<br><br>";
    }*/
/**
* DEMO TWITTER
**/
/*    $socialwall = new Socialwall('hashtag', '');
    foreach($socialwall->getTwitter() as $twitter){
        echo "Username : ".$twitter->username."<br>";
        echo "Date : ".$twitter->date_created."<br>";
        echo "Content : ".$twitter->content."<br>";
        echo "Likes : ".$twitter->likes."<br>";
        echo "RT : ".$twitter->rt."<br>";
        echo "Source : ".$twitter->source."<br>";
        echo "<img src='".$twitter->img."' alt='' title=''>";
        echo "<br><br>";
    }*/
/**
* DEMO FACEBOOK
**/
/*    $socialwall = new Socialwall('', 'facebook_name');
    foreach($socialwall->getFacebook() as $facebook){
        echo "Username : ".$facebook->username."<br>";
        echo "Date : ".$facebook->date_created."<br>";
        echo "Content : ".$facebook->content."<br>";
        echo "Likes : ".$facebook->likes."<br>";
        echo "RT : ".$facebook->rt."<br>";
        echo "Source : ".$facebook->source."<br>";
        echo "<img src='".$facebook->img."' alt='' title=''>";
        echo "<br><br>";
    }*/
?>


<div class="content">

    <?php $socialwall = new Socialwall('hashtag', 'facebook_name'); ?>

    <section id="cd-timeline" class="cd-container">
        <?php foreach($socialwall->getAll() as $all){ ?>
        <div class="cd-timeline-block" id="slideUp">
            <div class="cd-timeline-social cd-<?= $all->source; ?>">
                <i class="fa fa-<?= $all->source; ?> fa-2x"></i>
            </div>
            <div class="cd-timeline-content">
                <?php if (!empty($all->img)){ ?>
                    <img src="<?= $all->img; ?>" alt="<?= $all->username; ?>" title="<?= $all->username; ?>">
                <?php } ?>
                <?php if (!empty($all->content)){ ?>
                    <p><?= $all->content; ?></p>
                <?php } ?>
                <small>
                    <time class="timeago" datetime="<?= $all->date_created; ?>"><?= $all->date_created; ?></time>
                </small>
                <div class="author-<?= $all->source; ?>">@<?= $all->username; ?></div>
                <div class="cb"></div>
            </div>
        </div>
        <?php } ?>
    </section>



</div>





<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.timeago.js"></script>
<script type="text/javascript" src="js/social.js"></script>

</body>
</html>