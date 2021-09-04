<?php

$apiKey = 'AIzaSyChw0CecP11cOYRSnOTlqCbYZonpYSiQx0';
$channelId = 'UCuVUruvTCCX8GAwV0jRfWdA';
$resultsNumber = '10';
 
$requestUrl = 'https://www.googleapis.com/youtube/v3/search?key=' . $apiKey . '&channelId=' . $channelId . '&part=snippet,id&maxResults=' . $resultsNumber .'&order=date';


// Try file_get_contents first
if( function_exists( file_get_contents ) ) {
    $response = file_get_contents( $requestUrl );
    $json_response = json_decode( $response, TRUE );
     
} else {
    // No file_get_contents? Use cURL then...
    if( function_exists( 'curl_version' ) ) {
        $curl = curl_init();
        curl_setopt( $curl, CURLOPT_URL, $requestUrl );
        curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, TRUE );
        $response = curl_exec( $curl );
        curl_close( $curl );
        $json_response = json_decode( $response, TRUE );
         
    } else {
        // Unable to get response if both file_get_contents and cURL fail
        $json_response = NULL;
    }
}
 
// If there's a JSON response
if( $json_response ) {
    $i = 1;
    echo '<div class="youtube-channel-videos">';
    foreach( $json_response['items'] as $item ) {
        $videoTitle = $item['snippet']['title'];
        $videoID = $item['id']['videoId'];
        //$videoThumbnail = $item['snippet']['thumbnails']['high']['url'];
 
        if( $videoTitle && $videoID ) {
            echo '<div class="youtube-channel-video-embed vid-' . $videoID . ' video-' . $i++ . '"><iframe width="500" height="300" src="https://www.youtube.com/embed/' . $videoID . '" frameborder="0" allowfullscreen>' . $videoTitle . '</iframe></div>';
        }
    }
    echo '</div><!-- .youtube-channel-videos -->';
 
// If there's no response   
} else {
    // Display error message
    echo '<div class="youtube-channel-videos error"><p>No videos are available at this time from the channel specified!</p></div>';
    }
}

?>
