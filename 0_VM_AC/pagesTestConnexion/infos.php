<?php
function get_client_info() {
    $ip = $_SERVER['REMOTE_ADDR'];
    $hostname = gethostbyaddr($ip);
    $user_agent = $_SERVER['HTTP_USER_AGENT'];

    function get_os($user_agent) {
        $os_array = [
            '/windows nt 10/i'     => 'Windows 10',
            '/windows nt 6.3/i'    => 'Windows 8.1',
            '/windows nt 6.2/i'    => 'Windows 8',
            '/windows nt 6.1/i'    => 'Windows 7',
            '/macintosh|mac os x/i'=> 'Mac OS',
            '/linux/i'             => 'Linux',
            '/iphone/i'            => 'iPhone',
            '/android/i'           => 'Android',
        ];
        foreach ($os_array as $regex => $value) {
            if (preg_match($regex, $user_agent)) return $value;
        }
        return "OS Inconnu";
    }

    $location_data = @file_get_contents("http://ipinfo.io/{$ip}/json");
    $location = json_decode($location_data, true);

    return [
        'Adresse IP' => $ip,
        'Nom de l\'hôte' => $hostname,
        'Navigateur' => $user_agent,
        'Système d\'exploitation' => get_os($user_agent),
        'Ville' => $location['city'] ?? 'Inconnu',
        'Pays' => $location['country'] ?? 'Inconnu',
        'Position' => $location['loc'] ?? 'Inconnue',
    ];
}

$infos = get_client_info();
foreach ($infos as $cle => $valeur) {
    echo "<p><strong>$cle :</strong> $valeur</p>";
}
?>
