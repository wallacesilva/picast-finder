<?php 

function ytc_play_url($video_id)
{
    return YTC_URL.'yt-stream/'.$video_id;
}

function base_url($uri='')
{
    return BASE_URL. '/'. ltrim($uri, '/');
}
function app_convert_duration($string)
{
    $duration = explode('M', ltrim($string, "PT"));
    $duration[1] = rtrim($duration[1], 'S');
    $duration[1] = (strlen($duration[1]) === 1) ? '0'.$duration[1] : $duration[1];
    $duration_str = $duration[0].':'.$duration[1];
    return $duration_str;
    //return rtrim(ltrim(str_replace('M', ':', $string), 'PT'), 'S');
}