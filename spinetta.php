<?php

/************************************************************************************************
This file is part of spinetta-lyrics-fetcher.
 
spinetta-lyrics-fetcher is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.
 
spinetta-lyrics-fetcher is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with spinetta-lyrics-fetcher.  If not, see <http://www.gnu.org/licenses/>.

@author Mariano Gappa <spinetta@gmail.com>
************************************************************************************************/

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

function getAllAlbumsFormArtist($artist) {
    $html = file_get_contents($artist);
    preg_match_all("#<a href=\"(/discos/[\d]+/[\d]+\.shtml)#", $html, $matches, PREG_SET_ORDER);
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