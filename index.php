<?php
session_start();
$url_array = explode('?', 'http://'.$_SERVER ['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$url = $url_array[0];

require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_DriveService.php';
$client = new Google_Client();
$client->setClientId('558376972847-45apenrnb0gopgtt8jdeiudrdo2ikpb1.apps.googleusercontent.com');
$client->setClientSecret('rfqG5gcRU4RLnkFq5Wmhph94');
$client->setRedirectUri($url);
$client->setScopes(array('https://www.googleapis.com/auth/drive'));
if (isset($_GET['code'])) {
    $_SESSION['accessToken'] = $client->authenticate($_GET['code']);
    header('location:'.$url);exit;
} elseif (!isset($_SESSION['accessToken'])) {
    $client->authenticate();
}
$files= array();
$dir = dir('files');
while ($file = $dir->read()) {
    if ($file != '.' && $file != '..') {
        $files[] = $file;
    }
}
$dir->close();
if (!empty($_POST)) {
    $client->setAccessToken($_SESSION['accessToken']);
    $service = new Google_DriveService($client);
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $filenames = $_FILES['file-up']['name'];
    $file = new Google_DriveFile();

        $file_path = $_FILES['file-up']['tmp_name'];
        $mime_type = finfo_file($finfo, $file_path);
        $file->setTitle($filenames);
        $file->setDescription('This is a '.$mime_type.' document');
        $file->setMimeType($mime_type);
        $service->files->insert(
            $file,
            array(
                'data' => file_get_contents($file_path),
                'mimeType' => $mime_type
            )
        );
    finfo_close($finfo);

    echo '<script type="text/javascript">alert("File Telah Di Upload, Cek Google Drive Mu")</script>';
    echo '<script type="text/javascript">window.location = '.$url.';</script>';


}
include 'index.phtml';
