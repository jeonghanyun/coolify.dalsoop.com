<?php
/**
 * Download and Install Korean Language Pack
 */

define('WP_INSTALLING', true);
require_once('/var/www/html/wp-load.php');
require_once('/var/www/html/wp-admin/includes/translation-install.php');
require_once('/var/www/html/wp-admin/includes/file.php');

$language = 'ko_KR';

echo "Downloading Korean language pack...\n";

// Download Korean language
$result = wp_download_language_pack($language);

if (is_wp_error($result)) {
    echo "Error downloading language pack: " . $result->get_error_message() . "\n";
    exit(1);
}

echo "Language pack downloaded: $result\n";

// Set Korean as site language
echo "Setting Korean as site language...\n";
update_option('WPLANG', $language);

// Verify
$current_lang = get_option('WPLANG');
echo "Current language setting: $current_lang\n";

// Check language files
$lang_dir = WP_CONTENT_DIR . '/languages';
if (is_dir($lang_dir)) {
    echo "\nLanguage files in $lang_dir:\n";
    $files = scandir($lang_dir);
    foreach ($files as $file) {
        if (strpos($file, 'ko_KR') !== false) {
            echo "  - $file\n";
        }
    }
}

echo "\nKorean language pack installed successfully!\n";
