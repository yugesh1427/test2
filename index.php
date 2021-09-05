<?php
    $API_key = 'AIzaSyA65uTGVOywhNfSFCO9rqrucyEq8t5-K3s';
    $channelID = 'UCBUMECQziGFpSn85UXl7-vw';
    $maxResult = 1;

    $apiError = 'Video not Found';
    try{
        $apiData = @file_get_contents('https://www.googleapis.com/youtube/v3/search?order=date&part=snippet&channelId='.$channelID.'&maxResults='.$maxResult.'&key='.$API_key.''); 

        if($apiData){ 
            $videoList = json_decode($apiData); 
        }else{ 
            throw new Exception('Invalid API key or channel ID.');
        }   
    }catch(Exception $e){
        $apiError = $e->getMessage();
    }   
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Get Videos from YouTube Channel using Data API v3 and PHP</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <h2 class="text-center mt-3">Get Videos from YouTube Channel using Data API v3 and PHP</h2>
        <div class="row">
            <div class="col-md-12">
                <?php 
                    if(!empty($videoList->items)){ 
                        foreach($videoList->items as $item){ 
                            if(isset($item->id->videoId)){ 
                                ?>
                                <div class="yvideo-box"> 
                                    <iframe width="280" height="150" src="https://www.youtube.com/embed/<?php echo $item->id->videoId; ?>" frameborder="0" allowfullscreen></iframe> 
                                    <h4><?php echo $item->snippet->title; ?> </h4> 
                                </div>
                                <?php 
                            } 
                        } 
                    }else{ 
                        echo '<p class="error">'.$apiError.'</p>'; 
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
