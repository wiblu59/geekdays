<?php
/*
$ts = preg_split("/[\s,]+/",microtime());
$ts = $ts[1];
$pbKey = 'b3c4a8e3f91dcf2033e441539ba4c8a4';
$pvKey = '652074ab22b69660362cb53af82b9ea72ae43176';
$hash = md5($ts.$pvKey.$pbKey);

$year = '2001';
$month = '04';
$day = intval('09');
$minDay = $day - 3;
$maxDay = $day + 3;

#$response = file_get_contents('https://gateway.marvel.com/v1/public/comics?ts='.$ts.'&apikey='.$pbKey.'&hash='.$hash.'&limit=100&format=comic&formatType=comic&dateRange='.$year.'-'.$month.'-'.$minDay.','.$year.'-'.$month.'-'.$maxDay);
#$response = file_get_contents('https://gateway.marvel.com/v1/public/events?ts='.$ts.'&apikey='.$pbKey.'&hash='.$hash);
$response = json_decode($response);
print_r($response);
echo '-$-$-$-$-$-$';

$img_result = $response->data->results[0]->images[0]->path.'.'.$response->data->results[0]->images[0]->extension;
echo $img_result;
*/
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8"/>
        <title>Geek Days</title>
        <meta name="description" content=""/>
        <link rel="icon" href="icon.png"/>
        <link rel="apple-touch-icon" href="icon-192.png">
        <!--
<link rel="manifest" href="manifest.webmanifest">
-->
        <meta name=viewport content="width=device-width, initial-scale=1"/>
        <meta name="theme-color" content="#006AB3"/>
        <meta property="og:url" content="https://williamblu.me"/>
        <meta property="og:type" content="website"/>
        <meta property="og:title" content="Geek Days"/>
        <meta property="og:description" content=""/>
        <meta property="og:image" content=""/>
    </head>
    <body>
        <header>
            <h1 class="title">{ Epitech. }<br>Geek Days</h1>
        </header>
        <section class="marvel-logo"></section>
        <section class="form">
            <p class="legend">Découvrez le comic Marvel<br>sorti lors de votre naissance !</p>
            <form method="POST" action="picture.php" class="form-container" id="form">
                <label for="birth">Indiquez votre date de naissance</label>
                <input type="date" name="birth" id="birth" class="birth" required autofocus/>
                <div class="send-button">
                    <button class="btn waves-effect waves-light" type="submit" name="action" id="submit-btn">Découvrir le résultat</button>
                </div>
            </form>
        </section>
        <section class="marvel-img"></section>
    </body>
    <script src="jquery.js"></script>
    <script>
        var i = 0;
        $("#birth").keyup(function () {
            console.log(this.value.length);
            if (this.value.length == 10) {
                i += 1;
                if (i == 4) {
                    console.log("Done");
                    $(this).next('#submit-btn').focus();
                }
            }
            /*
            if (this.value.length == this.maxLength) {
                $(this).next('#birth').focus();
            }
            */
        });
    </script>
    <!--
<script async defer>
if ('serviceWorker' in navigator) {
navigator.serviceWorker.register('service-worker.js');
}
</script>
-->
    <!-- Materialize stylesheets -->
    <script src="materialize/materialize.min.js"></script>
    <link rel="stylesheet" href="materialize/materialize.min.css">

    <!-- Local Stylesheets -->
    <link type="text/css" media="screen" rel="stylesheet" href="style.css"/>

    <!-- Google Fonts stylesheet -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito|Quicksand|Alatsi|Baloo">

</html>