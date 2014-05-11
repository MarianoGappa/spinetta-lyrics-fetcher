<?php
date_default_timezone_set("Pacific/Auckland");

$artists = array(
    "http://www.rock.com.ar/bios/0/699.shtml",
    "http://www.rock.com.ar/bios/0/453.shtml",
    "http://www.rock.com.ar/artistas/luis-alberto-spinetta",
    "http://www.rock.com.ar/artistas/invisible",
    "http://www.rock.com.ar/artistas/pescado-rabioso",
    "http://www.rock.com.ar/artistas/almendra"
);

foreach($artists as $artist)
    getAllAlbumsFormArtist($artist);

function getAllAlbumsFormArtist() {
    $html = file_get_contents("http://www.rock.com.ar/artistas/luis-alberto-spinetta");
    preg_match_all("#<a href=\"(/discos/[\d]+/[\d]+\.shtml)#", $html, $matches, PREG_SET_ORDER);
    var_dump($matches);
    foreach($matches as $match) {
        getAllSongsFromAlbum($match[1]);
    }    
}

function getAllSongsFromAlbum($url) {
    $html = file_get_contents("http://www.rock.com.ar" . $url);
    preg_match_all("#<a href=\"(/letras/[\d]+/[\d]+\.shtml)#", $html, $matches, PREG_SET_ORDER);
    foreach($matches as $match) {
        getSong($match[1]);
    }
}

function getSong($url) {
    $html = file_get_contents("http://www.rock.com.ar" . $url);
    preg_match("#blanco\.gif.+<div class=\"nota\">(.*?)</div>#s", $html, $matches);
    echo str_replace("<br>", "", $matches[1]);
}