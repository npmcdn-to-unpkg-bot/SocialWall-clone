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
    <link rel="stylesheet" type="text/css" href="css/theme-2.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body>



<?php
$socialwall = new Socialwall('__REPLACE_THIS__HASHTAG__', '__REPLACE_THIS__FB_NAME__');
$i = 0;
?>


<div class="grid">
<?php foreach($socialwall->getAll() as $all){
    $i++;
    $gridSize = "";
    if($i%3 == 0 && !empty($all->img)){
        $gridSize = "grid-item--width2";
    }
    ?>
    <?php if($i == 5) { ?>
        <a href="__REPLACE_THIS__LINK_FACEBOOK__" class="grid-item sw-pub sw-pub-facebook" target="_blank">
            <div class="sw-pub-logo"><i class="fa fa-facebook fa-3x"></i></div>
            <span>Suivez-nous sur</span>
            <h4>Facebook</h4>
            <span class="sw-pub-name">__REPLACE_THIS__FACEBOOK_NAME</span>
        </a>
    <?php } ?>
    <?php if($i == 6) { ?>
        <a href="__REPLACE_THIS__LINK_TWITTER__" class="grid-item sw-pub sw-pub-twitter" target="_blank">
            <div class="sw-pub-logo"><i class="fa fa-twitter fa-3x"></i></div>
            <span>Suivez-nous sur</span>
            <h4>Twitter</h4>
            <span class="sw-pub-name">@__REPLACE_THIS__TWITTER_NAME</span>
        </a>
    <?php } ?>
    <?php if($i == 8) { ?>
        <a href="__REPLACE_THIS__LINK_INSTAGRAM__" class="grid-item sw-pub sw-pub-instagram" target="_blank">
            <div class="sw-pub-logo"><i class="fa fa-instagram fa-3x"></i></div>
            <span>Suivez-nous sur</span>
            <h4>Instagram</h4>
            <span class="sw-pub-name">__REPLACE_THIS__INSTAGRAM_NAME</span>
        </a>
    <?php } ?>




    <div class="grid-item <?= $gridSize.' '.$all->source; ?>">
        <?php if(!empty($all->img)): ?>
            <a href="<?= $all->link; ?>" target="_blank"><img src="<?= $all->img; ?>" alt="" title="" width="100%"></a>
        <?php endif; ?>
        <?php if(!empty($all->content)): ?>
            <p class="sw-text"><?= $all->content; ?></p>
        <?php endif; ?>
        <a href="<?= $all->link; ?>" class="sw-info" target="_blank"><i class="fa fa-<?= $all->source; ?>"></i> <?= $all->username; ?></a>
    </div>
<?php } ?>
</div>



<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="js/theme-2.js"></script>
<script src="https://unpkg.com/masonry-layout@4.0/dist/masonry.pkgd.min.js"></script>
<script type="text/javascript" src="js/imagesloaded.pkgd.min.js"></script>

</body>
</html>