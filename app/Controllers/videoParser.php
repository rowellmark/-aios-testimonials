<?php

function parseVideos($url)
{
        //This is a general function for generating an embed link of an FB/Vimeo/Youtube Video.
        $finalUrl = '';
        if(strpos($url, 'facebook.com/') !== false) {
            //it is FB video
            $finalUrl.='https://www.facebook.com/plugins/video.php?href='.rawurlencode($url).'&show_text=1&width=200';
        }else if(strpos($url, 'vimeo.com/') !== false) {
            //it is Vimeo video
            $videoId = explode("vimeo.com/",$url)[1];
            if(strpos($videoId, '&') !== false){
                $videoId = explode("&",$videoId)[0];
            }
            $finalUrl.='https://player.vimeo.com/video/'.$videoId.'?loop=false&autoplay=false&muted=false&gesture=media&playsinline=true&byline=false&portrait=false&title=false&speed=true&transparent=false&customControls=true';
        }else if(strpos($url, 'youtube.com/') !== false) {
            //it is Youtube video
            $videoId = explode("v=",$url)[1];
            if(strpos($videoId, '&') !== false){
                $videoId = explode("&",$videoId)[0];
            }
            $finalUrl.='https://www.youtube.com/embed/'.$videoId;
        }else if(strpos($url, 'youtu.be/') !== false){
            //it is Youtube video
            $videoId = explode("youtu.be/",$url)[1];
            if(strpos($videoId, '&') !== false){
                $videoId = explode("&",$videoId)[0];
            }
            $finalUrl.='https://www.youtube.com/embed/'.$videoId;
        }else{
            //Enter valid video URL
        }
        return $finalUrl;
}