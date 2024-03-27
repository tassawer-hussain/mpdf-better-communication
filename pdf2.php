<?php

require_once __DIR__ . '/vendor/autoload.php';


$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
$fontDirs = $defaultConfig['fontDir'];

$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
$fontData = $defaultFontConfig['fontdata'];

$font_config = array(
	'fontDir' => array_merge($fontDirs, [
        __DIR__ . '/fonts',
    ]),
    'fontdata' => $fontData + [
        'montextralight' => [
            'R' => 'Montserrat-ExtraLight.ttf',
		],
		'montsemibold' => [
            'R' => 'Montserrat-SemiBold.ttf',
		],
		'montsemibolditalic' => [
            'R' => 'Montserrat-SemiBoldItalic.ttf',
		],
		'montextrabold' => [
            'R' => 'Montserrat-ExtraBold.ttf',
		],
		'montextrabolditalic' => [
            'R' => 'Montserrat-ExtraBoldItalic.ttf',
		],
		'montblack' => [
            'R' => 'Montserrat-Black.ttf',
		],
		'shelby' => [
            'R' => 'Shelby-Script-Regular.otf',
        ]
    ],
    'default_font' => 'montserrat'
);

$mpdf = new \Mpdf\Mpdf($font_config);
$mpdf->showImageErrors = true;
$mpdf->curlAllowUnsafeSslRequests = true;

$arrContextOptions=array(
    "ssl"=>array(
        "verify_peer"=>false,
        "verify_peer_name"=>false,
    ),
); 

$page = file_get_contents("http://localhost/team/pdf_test/report2.php",false,stream_context_create($arrContextOptions));

$mpdf->defaultheaderline = 0;
$mpdf->defaultfooterline = 0;
$mpdf->setFooter('{PAGENO}');
ob_get_clean();
$mpdf->WriteHTML($page);
$mpdf->Output("Assesment.pdf","I");
