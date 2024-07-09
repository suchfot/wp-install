<?php

/**
 * WordPress Installationsskript
 *
 * Dieses Skript lädt die neueste WordPress-Version herunter,
 * entpackt sie und kopiert alle Dateien in das aktuelle Verzeichnis.
 * Anschließend wird die WordPress-Installation gestartet.
 *
 * Hinweis: Dieses Skript sollte nur auf einem leeren Server ausgeführt werden,
 * da es alle Dateien im aktuellen Verzeichnis löscht.
 *
 * @category WordPress
 * @package  Installation
 * @author   Christian Suchanek
 * @license  MIT
 * @version  PHP > 7.4
 */




/**
 * Function to provide translations.
 *
 *  @param string  $string   The string to be translated.
 *  @return string
 * Translated string.
 */
function __($string)
{

    if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {

        $accepted_languages = preg_split('/,\s*/', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
        $preferred_language = explode(';', $accepted_languages[0])[0];

        $languages = $preferred_language;
    } else {
        return $string;
    }
    $translations = [
        'en-US' => [
            'WordPress ZIP file downloaded and extracted successfully.' => 'WordPress ZIP file downloaded and extracted successfully.',
            'Error unpacking WordPress ZIP file.' => 'Error unpacking WordPress ZIP file.',
            'WordPress folder deleted successfully.' => 'WordPress folder deleted successfully.',
            'The WordPress folder could not be found.' => 'The WordPress folder could not be found.',
            'Copying files with PHP shell_exec is not possible. Please copy manually.' => 'Copying files with PHP shell_exec is not possible. Please copy manually.'
        ],

        'en-GB' => [
            'WordPress ZIP-Datei erfolgreich heruntergeladen und entpackt.' => 'WordPress ZIP file downloaded and extracted successfully.',
            'Fehler beim Entpacken der WordPress ZIP-Datei.' => 'Error unpacking WordPress ZIP file.',
            'WordPress-Ordner erfolgreich gelöscht.' => 'WordPress folder deleted successfully.',
            'Der WordPress-Ordner konnte nicht gefunden werden.' => 'The WordPress folder could not be found.',
            'Das Kopieren der Dateien mit PHP shell_exec ist nicht möglich. Bitte manuell kopieren.' => 'Copying files with PHP shell_exec is not possible. Please copy manually.'
        ],
        'pl-PL' => [
            'WordPress ZIP-Datei erfolgreich heruntergeladen und entpackt.' => 'Plik ZIP WordPress został pomyślnie pobrany i rozpakowany.',
            'Fehler beim Entpacken der WordPress ZIP-Datei.' => 'Błąd podczas rozpakowywania pliku ZIP WordPress.',
            'WordPress-Ordner erfolgreich gelöscht.' => 'Folder WordPress został pomyślnie usunięty.',
            'Der WordPress-Ordner konnte nicht gefunden werden.' => 'Nie można znaleźć folderu WordPress.',
            'Das Kopieren der Dateien mit PHP shell_exec ist nicht möglich. Bitte manuell kopieren.' => 'Kopiowanie plików za pomocą PHP shell_exec nie jest możliwe. Proszę skopiować ręcznie.'
        ],

        'es-ES' => [
            'WordPress ZIP-Datei erfolgreich heruntergeladen und entpackt.' => 'Archivo ZIP de WordPress descargado y descomprimido correctamente.',
            'Fehler beim Entpacken der WordPress ZIP-Datei.' => 'Error al descomprimir el archivo ZIP de WordPress.',
            'WordPress-Ordner erfolgreich gelöscht.' => 'Carpeta de WordPress eliminada correctamente.',
            'Der WordPress-Ordner konnte nicht gefunden werden.' => 'No se pudo encontrar la carpeta de WordPress.',
            'Das Kopieren der Dateien mit PHP shell_exec ist nicht möglich. Bitte manuell kopieren.' => 'No es posible copiar archivos con PHP shell_exec. Por favor, copie manualmente.'
        ],

        'fr-FR' => [
            'WordPress ZIP-Datei erfolgreich heruntergeladen und entpackt.' => 'Fichier ZIP WordPress téléchargé et extrait avec succès.',
            'Fehler beim Entpacken der WordPress ZIP-Datei.' => 'Erreur lors de la décompression du fichier ZIP WordPress.',
            'WordPress-Ordner erfolgreich gelöscht.' => 'Dossier WordPress supprimé avec succès.',
            'Der WordPress-Ordner konnte nicht gefunden werden.' => 'Le dossier WordPress n\'a pas pu être trouvé.',
            'Das Kopieren der Dateien mit PHP shell_exec ist nicht möglich. Bitte manuell kopieren.' => 'La copie des fichiers avec PHP shell_exec n\'est pas possible. Veuillez copier manuellement.'
        ],

        'it-IT' => [
            'WordPress ZIP-Datei erfolgreich heruntergeladen und entpackt.' => 'File ZIP di WordPress scaricato ed estratto correttamente.',
            'Fehler beim Entpacken der WordPress ZIP-Datei.' => 'Errore durante l\'estrazione del file ZIP di WordPress.',
            'WordPress-Ordner erfolgreich gelöscht.' => 'Cartella WordPress eliminata correttamente.',
            'Der WordPress-Ordner konnte nicht gefunden werden.' => 'Impossibile trovare la cartella di WordPress.',
            'Das Kopieren der Dateien mit PHP shell_exec ist nicht möglich. Bitte manuell kopieren.' => 'Copying files with PHP shell_exec is not possible. Please copy manually.'
        ],

        'zh-CN' => [
            'WordPress ZIP-Datei erfolgreich heruntergeladen und entpackt.' => 'WordPress ZIP文件下载并成功解压。',
            'Fehler beim Entpacken der WordPress ZIP-Datei.' => '解压WordPress ZIP文件时出错。',
            'WordPress-Ordner erfolgreich gelöscht.' => '成功删除WordPress文件夹。',
            'Der WordPress-Ordner konnte nicht gefunden werden.' => '找不到WordPress文件夹。',
            'Das Kopieren der Dateien mit PHP shell_exec ist nicht möglich. Bitte manuell kopieren.' =>  '使用PHP shell_exec无法复制文件，请手动复制。'
        ],

        'ru-RU' => [
            'WordPress ZIP-Datei erfolgreich heruntergeladen und entpackt.' => 'WordPress ZIP-файл успешно загружен и распакован.',
            'Fehler beim Entpacken der WordPress ZIP-Datei.' => 'Ошибка при распаковке ZIP-файла WordPress.',
            'WordPress-Ordner erfolgreich gelöscht.' => 'Папка WordPress успешно удалена.',
            'Der WordPress-Ordner konnte nicht gefunden werden.' => 'Не удалось найти папку WordPress.',
            'Das Kopieren der Dateien mit PHP shell_exec ist nicht möglich. Bitte manuell kopieren.' => 'Копирование файлов с помощью PHP shell_exec невозможно. Пожалуйста, скопируйте вручную.'
        ],
    ];

    return $translations[$languages][$string];
}


// WordPress herunterladen und installieren
$zip_url = 'https://wordpress.org/latest.zip';
$zip_file = 'wordpress.zip';
$extract_path = __DIR__;

file_put_contents($zip_file, file_get_contents($zip_url));
$zip = new ZipArchive;
if ($zip->open($zip_file) === TRUE) {
    $zip->extractTo($extract_path);
    $zip->close();
    echo __('WordPress ZIP-Datei erfolgreich heruntergeladen und entpackt.') . '<br>';
} else {
    echo __('Fehler beim Entpacken der WordPress ZIP-Datei.') . '<br>';
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
        echo __('WordPress-Ordner erfolgreich gelöscht.') . '<br>';
    } else {
        echo __('Der WordPress-Ordner konnte nicht gefunden werden.') . '<br>';
    }
} else {
    echo __('Das Kopieren der Dateien mit PHP shell_exec ist nicht möglich. Bitte manuell kopieren.') . '<br>';
}

// Installation starten
header("Location: /wp-admin/install.php");
exit;
