<?php

// Prüfe, ob die Anfrage für die robots.txt-Datei ist
if (preg_match('/robots\.txt$/', $_SERVER['REQUEST_URI'])) {
    if ($_SERVER['REQUEST_URI'] !== '/robots.txt') {
        http_response_code(404);
        exit('Not Found');
    }

    // Setze den Header für den Textinhalt
    header('Content-Type: text/plain');
    
    // Hole die aktuelle Domain
    $domain = $_SERVER['HTTP_HOST'];

    // Dynamische Ausgabe der robots.txt
    echo "User-agent: *\n";
    echo "User-agent: AdsBot-Google\n";
    echo "Disallow: /\n\n";

    echo "### Sitemap\n";
    echo "Sitemap: https://$domain/sitemap.xml\n\n";

    echo "### Folders\n";
    echo "Allow: /storage/\n";
    echo "Disallow: /userstorage/\n";
    echo "Disallow: /app/\n";
    echo "Disallow: /packages/\n";
    echo "Disallow: /admin/\n";
    echo "Disallow: /node_modules/\n";
    echo "Disallow: /user/login\n";
    echo "Disallow: /tmp/\n\n";

    echo "### Files\n";
    echo "Disallow: /autoload.php\n";
    echo "Disallow: /config.php\n\n";

    echo "### Filetypes\n";
    echo "Disallow: *.db\n";
    echo "Disallow: *.json\n";
    echo "Disallow: *.lock\n";
    echo "Disallow: *.md\n";

    // Beende das Skript nach Ausgabe der robots.txt
    exit();
}

if (version_compare($ver = PHP_VERSION, $req = '7.2.0', '<')) {
    exit(sprintf('You are running PHP %s, but TTAGS System needs at least <strong>PHP %s</strong> to run.', $ver, $req));
}

if (PHP_SAPI == 'cli-server' && is_file(__DIR__.parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

if (!isset($_SERVER['HTTP_MOD_REWRITE']) && !isset($_SERVER['REDIRECT_HTTP_MOD_REWRITE'])) {
    $_SERVER['HTTP_MOD_REWRITE'] = 'Off';
} else {
    $_SERVER['HTTP_MOD_REWRITE'] = 'On';
}

date_default_timezone_set('UTC');

$env = 'system';
$path = __DIR__;
$config = array(
    'path'          => $path,
    'path.packages' => $path.'/packages',
    'path.storage'  => $path.'/storage',
    'path.temp'     => $path.'/tmp/temp',
    'path.cache'    => $path.'/tmp/cache',
    'path.logs'     => $path.'/tmp/logs',
    'path.vendor'   => $path.'/vendor',
    'path.artifact' => $path.'/tmp/packages',
    'config.file'   => realpath($path.'/config.php'),
    'system.api'    => 'https://ttags.de'
);

if (!$config['config.file']) {
    $env = 'installer';
}

if (PHP_SAPI == 'cli') {
    $env = 'console';
}

require_once "$path/app/$env/app.php";