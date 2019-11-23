<?php

include_once('index.php');

echo "<br><div class='container' id='result' >";

//////////////////////////////FONCTION//////////////////////////////////////////

// function file_get_contents_curl($url)
// {
//     $ch = curl_init();

//     curl_setopt($ch, CURLOPT_HEADER, 0);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

//     $data = curl_exec($ch);
//     curl_close($ch);

//     return $data;
// }

/////////////////////////////URL/////////////////////////////////////

$recherche = rawurlencode(htmlspecialchars($_GET['film']));
$newNom = str_replace(' ', '+', $recherche);
$url = "http://www.allocine.fr/recherche/1/?q=".$newNom;


$allo = file_get_contents($url);

preg_match_all ('#<div style="margin-top:-5px;">[\n]<a href=./film/fichefilm_gen_cfilm=[0-9]*\.html.>[\n].*[\n]?.*?[\n]<br />[\n]<span class=.fs11.>[\n].*[\n].*[\n].*[\n]#', $allo, $films);

preg_match_all ('#<img[\n]src=.http://fr\.web\.img[\d]\.acsta.net/r_75_106/.*\..{3}#', $allo, $images);


for ($i = 0; $i < count($films[0]); $i++) {
    $titre = '';
    $realisateur = '';

    ////////////////////////////Titre///////////////////////////////////
    
    preg_match ('#[-a-zA-Z*(é|è|à|ù)]*.*</a>#', $films[0][$i], $titre);
    $titre = str_replace('<b>', '', $titre);
    $titre = str_replace('</b>', '', $titre);
    $titre = str_replace('</a>', '', $titre);
    $aTitre = $titre[0];

    /////////////////////////////Année//////////////////////////////////

    preg_match ('#[0-9]{4}<br />#', $films[0][$i], $annee);
    $annee = str_replace('<br />', '', $annee);
    if (isset($annee[0])) {
        $aAnnee = $annee[0];
    }

    ///////////////////////////Réalisateur//////////////////////////////

    preg_match ('#de ([\w,]+.?)+<br />[\n](avec)?#', $films[0][$i], $real);
    if (isset($real[0])){
        $realisateur = $real[0];
        $realisateur = preg_replace('/\\n.*/', '', $realisateur);
        $realisateur = preg_replace('/<br \/>/', '', $realisateur);
        $realisateur = str_replace('avec ', '', $realisateur);
        $aRealisateur = $realisateur;
    }
    /////////////////////////////Lien///////////////////////////////////

    preg_match ('#/film/fichefilm_gen_cfilm=[0-9]+.html#', $films[0][$i], $href);
    $aHref = $href[0];

    ////////////////////////////Image///////////////////////////////////

    $image = preg_replace('/<img[\n]src=./', '', $images[0][$i]);

    //Fonctionne mais charge trop de html

    // $lien = "http://www.allocine.fr".$aHref;

    // $html = file_get_contents_curl($lien);

    // $doc = new DOMDocument();
    // @$doc->loadHTML($html);
    
    // $metas = $doc->getElementsByTagName('meta');
    
    // $image = '';
    // foreach ($metas as $meta)
    // {
    //     if($meta->getAttribute('property') == 'og:image')
    //         $image = $meta->getAttribute('content');
    // }

    ///////////////////////////////Affichage///////////////////////////////////

    echo "<div class='row'>";
    echo "<div class='col-2'>";
    echo "<img src='$image' class='img-fluid'>";
    echo "</div>";
    echo "<div class='col-3'>";
    echo $aTitre." (".$aAnnee.") <br>";
    echo $aRealisateur." <br>";
    echo "<a href='detail.php?film=".$aHref."'>Plus de details</a><br>";
    echo "<br>";
    echo "</div>";
    echo "</div><hr><br>";
       
}

echo "<br><br>";
?>

</div>

</body>

</html>


