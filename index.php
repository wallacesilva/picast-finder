<?php 
require_once 'vendor/autoload.php';
require_once 'config.php';
require_once 'functions.php';

$DEVELOPER_KEY = GOOGLE_DEVELOPER_KEY; 

/*$client = new Google_Client();
$client->setApplicationName("PersonalTube");
$client->setDeveloperKey($DEVELOPER_KEY);

$service = new Google_Service_Books($client);
$optParams = array('filter' => 'free-ebooks');
$results = $service->volumes->listVolumes('Henry David Thoreau', $optParams);

foreach ($results as $item) {
  echo $item['volumeInfo']['title'], "<br /> \n";
}*/


$client = new Google_Client();
$client->setDeveloperKey($DEVELOPER_KEY);

// Define an object that will be used to make all API requests.
$youtube = new Google_Service_YouTube($client);

try {

    if (file_exists(YTC_CACHEPATH.'/searchResponse.txt')) {

        $searchResponse = unserialize(file_get_contents(YTC_CACHEPATH.'/searchResponse.txt'));
        $videosResponse = unserialize(file_get_contents(YTC_CACHEPATH.'/videosResponse.txt'));

    } else {

        // Call the search.list method to retrieve results matching the specified
        // query term.
        /*$searchResponse = $youtube->search->listSearch('id,snippet', array(
          'q' => $_GET['q'],
          'maxResults' => 100, //$_GET['maxResults'],
        ));*/
//UCtZDwVDzc3mjZiMjhVuuklQ
        $searchResponse = $youtube->search->listSearch('id,snippet', array(
            'type'          => 'video',
            'channelId'     => 'UCpCJ1AS4afAWOJ5pNMFh4Dw',
            'q'             => $_GET['q'],
            'order'         => 'rating', // viewCount
            'maxResults'    => 30, //$_GET['maxResults'],
        ));
        $videoResults = array();
        # Merge video ids
        foreach ($searchResponse['items'] as $searchResult) {
            array_push($videoResults, $searchResult['id']['videoId']);
        }
        $videoIds = join(',', $videoResults);
        # Call the videos.list method to retrieve location details for each video.
        $videosResponse = $youtube->videos->listVideos('snippet,contentDetails', array(
            'id' => $videoIds,
        ));

        file_put_contents(YTC_CACHEPATH.'/searchResponse.txt', serialize($searchResponse));
        file_put_contents(YTC_CACHEPATH.'/videosResponse.txt', serialize($videosResponse));
    }

    $videos = '';
    $channels = '';
    $playlists = '';
    $videosArr = array();

    // Add each result to the appropriate list, and then display the lists of
    // matching videos, channels, and playlists.
    foreach ($searchResponse['items'] as $searchResult) {
        /*echo '<pre>';
        print_r($searchResult);
        echo '</pre>';
        continue;*/
        switch ($searchResult['id']['kind']) {
            case 'youtube#video':
                $videosArr[] = $searchResult;
                $videos .= sprintf('<li>%s (%s) <img src="%s"></li>',
                $searchResult['snippet']['title'], $searchResult['id']['videoId'], str_replace('default', '0', $searchResult['snippet']['thumbnails']['default']['url']));
                //print_r($searchResult['id']['videoId']);
                break;
            case 'youtube#channel':
                $channels .= sprintf('<li>%s (%s)</li>',
                $searchResult['snippet']['title'], $searchResult['id']['channelId']);
                break;
            case 'youtube#playlist':
                $playlists .= sprintf('<li>%s (%s)</li>',
                $searchResult['snippet']['title'], $searchResult['id']['playlistId']);
                break;
        }
    }

$htmlBody = '';
$htmlBody .= <<<END
    <h3>Videos</h3>
    <ul>$videos</ul>
    <h3>Channels</h3>
    <ul>$channels</ul>
    <h3>Playlists</h3>
    <ul>$playlists</ul>
END;

} catch (Google_Service_Exception $e) {
    $htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
    htmlspecialchars($e->getMessage()));
} catch (Google_Exception $e) {
    $htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
    htmlspecialchars($e->getMessage()));
}


include 'template/index.php';