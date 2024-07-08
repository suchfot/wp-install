<?php
/**
 * WordPress Installationsskript
 *
 * Dieses Skript lädt die neueste WordPress-Version herunter, entpackt sie und kopiert alle Dateien in das aktuelle Verzeichnis.
 * Anschließend wird die WordPress-Installation gestartet.
 *
 * Hinweis: Dieses Skript sollte nur auf einem leeren Server ausgeführt werden, da es alle Dateien im aktuellen Verzeichnis löscht.
 *
 * @link https://gist.github.com/derpixeldan/6f4f3f3b1e1f3d0f7b3b
 */
// WordPress herunterladen und installieren
$zip_url = 'https://wordpress.org/latest.zip';
$zip_file = 'wordpress.zip';
$extract_path = __DIR__;

file_put_contents($zip_file, file_get_contents($zip_url));
$zip = new ZipArchive;
if ($zip->open($zip_file) === TRUE) {
    $zip->extractTo($extract_path);
    $zip->close();
    echo 'WordPress ZIP-Datei erfolgreich heruntergeladen und entpackt.<br>';
} else {
    echo 'Fehler beim Entpacken der WordPress ZIP-Datei.<br>';
}

// Alle Dateien kopieren
$source = 'wordpress/';
$destination = __DIR__;
if (function_exists('shell_exec')) {
    echo shell_exec("cp -r $source* $destination");
    if (is_dir($source)) {
        $files = glob($source . '*');
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
        rmdir($source);
        echo 'WordPress-Ordner erfolgreich gelöscht.<br>';
    } else {
        echo 'Der WordPress-Ordner konnte nicht gefunden werden.<br>';
    }
} else {
    echo 'Das Kopieren der Dateien mit PHP shell_exec ist nicht möglich. Bitte manuell kopieren.<br>';
}

// Installation starten
header("Location: /wp-admin/install.php");
exit;
?>
