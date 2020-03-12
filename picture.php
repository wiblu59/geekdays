<?php
error_reporting(0);

$clientip = (string)$_SERVER['REMOTE_ADDR'];
if (isset($_POST)) {
    $birth = htmlspecialchars($_POST['birth']);
}


$year = date('Y', strtotime($birth));
$month = date('m', strtotime($birth));
$day = date('d', strtotime($birth));
$minDay = $day - 2;
$maxDay = $day + 2;

$ts = preg_split("/[\s,]+/",microtime());
$ts = $ts[1];
$pbKey = 'b3c4a8e3f91dcf2033e441539ba4c8a4';
$pvKey = '652074ab22b69660362cb53af82b9ea72ae43176';
$hash = md5($ts.$pvKey.$pbKey);

$response = file_get_contents('https://gateway.marvel.com/v1/public/comics?ts='.$ts.'&apikey='.$pbKey.'&hash='.$hash.'&limit=100&format=comic&formatType=comic&dateRange='.$year.'-'.$month.'-'.$minDay.','.$year.'-'.$month.'-'.$maxDay);
$response = json_decode($response);
#print_r($response);

if ($response->data->total == 0) {
    $minDay = $day - 3;
    $maxDay = $day + 3;
    $response = file_get_contents('https://gateway.marvel.com/v1/public/comics?ts='.$ts.'&apikey='.$pbKey.'&hash='.$hash.'&limit=100&format=comic&formatType=comic&dateRange='.$year.'-'.$month.'-'.$minDay.','.$year.'-'.$month.'-'.$maxDay);
    $response = json_decode($response);
    #print_r($response);
    if ($response->data->total > 1) {
        $img_result = $response->data->results[0]->images[0]->path.'.'.$response->data->results[0]->images[0]->extension;
        $title = $response->data->results[0]->title;
        $description = $response->data->results[0]->description;
    } else {
        $img_result = 'https://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg';
    }

} else {
    $img_result = $response->data->results[0]->images[0]->path.'.'.$response->data->results[0]->images[0]->extension;
    $title = $response->data->results[0]->title;
    $description = $response->data->results[0]->description;
}
setlocale(LC_ALL, 'fr_FR');

$attrib = $response->attributionHTML;
$date = new DateTime($year.'-'.$month);
$date = utf8_encode(strftime('%B %G', $date->format('U')));
#print_r($response->data->results[0]->dates[0]->date);

if (strlen($img_result) <= 1) {
    $img_result = 'https://i.annihil.us/u/prod/marvel/i/mg/b/40/image_not_available.jpg';
}


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
    <body style="height: 175vw">
        <header>
            <h1 class="title">Sorti en <?php echo $date; ?></h1>
            <?php echo $attrib ?>
        </header>
        <section class="main-container">
            <div class="img-result">     
                <img src="<?php echo $img_result; ?>" height="250%">
            </div>
            <p class="title-res name-legend"><?php echo $title; ?></p>
            <p class="desc-res name-legend"><?php echo $description; ?></p>
            <section class="form form-picture" style="display: none;">
                <form method="POST" action="email.php" class="form-container" id="form">
                    <label for="email">Recevez cette couverture !</label>
                    <input type="email" name="email" id="email" placeholder="votre@email.fr" required/>
                    <input type="text" name="url" id="url" value="<?php echo $img_result ?>" hidden/>
                    <div class="send-button">
                        <button class="btn waves-effect waves-light" type="submit" name="action">Envoyer l'email</button>
                    </div>
                </form>
            </section>
            <section class="marvel-logo" style="margin-top: 5vh;"></section>
        </section>
    </body>
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

<?php
    /*
    try {
        #$bdd = new PDO('mysql:host=localhost;port=3306;dbname=williamblu;charset=utf8', 'root', '');
        $bdd = new PDO('mysql:host=localhost;port=3306;dbname=blup_contact;charset=utf8', 'blup_fiblu', 'Fgm#68?(VaA9%,7DvD');
        $request = $bdd->prepare("INSERT INTO `fiblu_form` (`id`, `time`, `nom`, `email`, `tel`, `objet`, `message`, `service`, `ip`, `recaptcha`) VALUES (NULL, NOW(), :nom, :email, :tel, :objet, :message, :service, :ip, :recaptcha)");
        $request->execute(array(
            "nom" => $nom,
            "email" => $email,
            "tel" => $tel,
            "objet" => $objet,
            "message" => $message,
            "service" => $service,
            "ip" => $clientip,
            "recaptcha" => $recaptcha_json
        ));
        $bdd = NULL;
    }
    catch (PDOException $error) {
        die ('Erreur : ' . $error->getMessage());
    }

    $user_mail = $email;
    $email = 'contact@williamblu.me';
    $headers = 'From: "williamblu.me"<'.'contact@williamblu.me'.'>'."\n";; 
    $headers .= 'Reply-To: '.$user_mail."\n";
    $headers .= 'Content-Type: text/html; charset="iso-8859-1"'."\n"; 
    $headers .= 'Content-Transfer-Encoding: 8bit';
    $objet = 'Demande : ' . $objet;
    $msg ="<html><body><strong>Nom : </strong>".$nom."<br><strong>Email : </strong>".$user_mail."<br><strong>Téléphone : </strong>".$tel."<br><strong>Message :<br>---------</strong><br>".$message."<strong><br>---------<br></strong></body></html>"; 

    if ($recaptcha->score >= 0.65 && $recaptcha->success= true) {
        mail($email, $objet, $msg, $headers);
        header('Location: https://fiblu.williamblu.me/#thank-you');
    }
    else {
        header('Location: https://williamblu.me/errors/spam.shtml');
    }
    */
    #header('Location: localhost/geekdays/');
?>