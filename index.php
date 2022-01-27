<!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="style.css" type="text/css">
            <title>RSS Reader</title>
        </head>
        <body>
            <form method='post' action="">
                <input type="text" name="feedurl" placeholder="Enter website feed URL">
                <input type="submit" name="submit" value="Submit">

            </form>
            <?php 
                $url ="http://feeds.bbci.co.uk/news/england/rss.xml";
                if(isset($_POST['submit'])){
                    if($_POST['feedurl'] != ''){
                        $url = $_POST['feedurl'];
                    }
                }
                
                $invalidurl = false;
                if(@simplexml_load_file($url)){
                    $feeds = simplexml_load_file($url);
                } else {
                    $invalidurl=true;
                    echo "<h3>Invalid RSS feed URL.</h3>";
                }

                $i =0;
                if(!empty($feeds)){

                    $site = $feeds->channel->title;
                    $sitelink = $feeds->channel->link;

                    echo "<h1>".$site."</h1>";

                    foreach($feeds->channel->item as $item){
                        $title = $item->title;
                        $link = $item->link;
                        $description = $item->description;
                        $postDate = $item->pubDate;
                        $pubDate = date('D,d M Y',strtotime($postDate));

                        if($i>=5){
                            break;
                        }
                        ?>

                    <div class="post">
                        <div class="post-head">
                            <h2><a class="feed-title" href="<?=$link ?>"><?=$title ?></a></h2>
                            <span><?=$pubDate?></span>
                        </div>
                        
                        <div class="post-content">
                            <?= implode(" ",array_slice(explode(' ',$description), 0,20)) ?>
                        </div>                        
                    </div>
                        <?php
                        $i++;
                    }

                }else{
                    if(!$invalidurl){
                        echo "<h2>No item found.</h2>";
                    }

                }


            ?>
        </body>
    </html>