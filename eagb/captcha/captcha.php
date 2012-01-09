<?php
// Session starten
require_once '../eaGB/Session.php';
eaGB_Session::start('eaGB');
eaGB_Session::write('captcha_code', null);
//session_start();
// Alten CAPTCHA-Code aus der Session loeschen
//unset( $_SESSION['captcha_code'] );


// Das Cachen der Grafik verhindern
header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
header( "Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" );
header( "Cache-Control: no-store, no-cache, must-revalidate" );
header( "Cache-Control: post-check=0, pre-check=0", false );
header( "Pragma: no-cache" );

// Dem Browser mitteilen das es sich hierbei um ein JPG handelt.
header( 'Content-type: image/jpeg' );

// Sicherheitscode generieren
$AlphaNumerischerString = "ABCDEFGH2345689";
$ZufallString1 = substr( str_shuffle( $AlphaNumerischerString ), 0, 2 );
$ZufallString2 = substr( str_shuffle( $AlphaNumerischerString ), 0, 2 );
$ZufallString3 = substr( str_shuffle( $AlphaNumerischerString ), 0, 2 );
$ZufallStringKomplett = $ZufallString1.$ZufallString2.$ZufallString3;

// Sicherheitscode in der Session speichern
//$_SESSION['captcha_code'] = md5( $ZufallStringKomplett );
eaGB_Session::write('captcha_code', md5( strtolower($ZufallStringKomplett) ));

// Grafik erzeugen und an den Browser senden
$Schriftarten = array( "./XFILES.TTF", "./XFILES.TTF", "./XFILES.TTF");
$Bilddatei = imagecreatefrompng( "captcha.PNG" );
$TextFarbe1 = imagecolorallocate( $Bilddatei, 0, 125, 0 );
$TextFarbe2 = imagecolorallocate( $Bilddatei, 130, 70, 90 );
$TextFarbe3 = imagecolorallocate( $Bilddatei, 180, 90, 190 );
imagettftext( $Bilddatei, 12, 15, 3, 24, $TextFarbe1, $Schriftarten[0], $ZufallString1 );
imagettftext( $Bilddatei, 16, 0, 26, 15, $TextFarbe2, $Schriftarten[1], $ZufallString2 );
imagettftext( $Bilddatei, 14, -20, 53, 18, $TextFarbe3, $Schriftarten[2], $ZufallString3 );
imagejpeg( $Bilddatei );

// Grafik zerstören und Speicher freigeben
imagedestroy( $Bilddatei );