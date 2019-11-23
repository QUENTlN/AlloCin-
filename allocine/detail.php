<?php

include_once('index.php');

//////////////////////////////////FONCTION/////////////////////////////////////////////

function file_get_contents_curl($url)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

    $data = curl_exec($ch);
    curl_close($ch);

    return $data;
}

function afficher_genre($allo)
{
    preg_match_all ('#<span class="ACrL2ZACrpbG1zL2dlbnJlLTEzMD[\w]{2,}Lw== blue-link">[-a-zA-Z*(é|è|à|ù)]*</span>#', $allo, $genres);
    
    if (count($genres[0]) > 1){
        echo "<b>Genres :</b> ";
    }else{
        echo "<b>Genre :</b> ";
    }

    for ($i = 0; $i < count($genres[0]); $i++) {
        preg_match ('#>[-a-zA-Z*(é|è|à|ù)]*<#', $genres[0][$i], $pGenre);
        preg_match ('#[-a-zA-Z*(é|è|à|ù)]+#', $pGenre[0], $genre);
        if ($i==(count($genres[0]))-1){
            echo $genre[0];
        }else{
            echo $genre[0].", ";
        }
       
    }

    echo "<br><br>";
}

$url = NULL;
$titre = NULL;
$description = NULL;
$realisateur = NULL;
$date = NULL;
$annee =  NULL;

/////////////////////////////////////URL///////////////////////////////////////

$lien = $_GET['film'];

$url = "http://www.allocine.fr".$lien;



//////////////////////////////DOMDOCUMENT PARSER/////////////////////////////////////////

$html = file_get_contents_curl($url);

$doc = new DOMDocument();
@$doc->loadHTML($html);

$metas = $doc->getElementsByTagName('meta');

foreach ($metas as $meta)
{
    if($meta->getAttribute('property') == 'og:title')
        $titre = $meta->getAttribute('content');
    if($meta->getAttribute('property') == 'video:director')
        $realisateur = $meta->getAttribute('content');
    if($meta->getAttribute('property') == 'og:description')
        $description = $meta->getAttribute('content');
    if($meta->getAttribute('property') == 'og:image')
        $image = $meta->getAttribute('content');
}

/////////////////////////////////////////////PREG PARSER//////////////////////////////////////////////////////////

$allo = file_get_contents($url);

preg_match ('#<span class="ACrL2ZACrpbG0vYW.*Lw== date blue-link">[\d]{1,2}.[-a-zA-Z*(é|è|à|ù)]{3,10}.[\d]{4}</span>#', $allo, $lDate);

if (isset($lDate[0])){
    
    preg_match ('#[\d]{1,2}.[-a-zA-Z*(é|è|à|ù)]{3,10}.[\d]{4}#', $lDate[0], $date);

    preg_match ('#[\d]{4}#', $date[0], $annee);
}

//////////////////////////////////////////Affichage/////////////////////////////////////////////////////////////

echo "<div class='row container'>";
echo "<div class='col-4'>";
echo "<img src='$image' class='img-fluid'>";
echo "</div>";
echo "<div class='col-8'>";
if ($annee == NULL){
    echo "<h1>$titre</h1>". '<br/>';
}else{
    echo "<h1>$titre ($annee[0])</h1>". '<br/>';
}           
echo "<b>Date de sortie :</b> $date[0]". '<br/><br/>';
echo "<b>Réalisateur :</b> $realisateur". '<br/><br/>';
afficher_genre($allo);
echo "<b>Description :</b> $description". '<br/><br/>';
echo "</div></div>";

?>

</body>

</html>