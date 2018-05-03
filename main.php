<?php
$serverConfigPath = '/etc/openvpn/server.conf';
$avoid = '178.62.';
$exclude = [192];

$ips = file_get_contents('ips.txt');
$ips = explode("\n", $ips);
$serverConfig = file_get_contents($serverConfigPath);
$pos = strpos($serverConfig, '#routes here');
if (!$pos) {
    throw new Exception('Where is fucking string?');
}
$serverConfig = substr($serverConfig, 0, $pos);
$serverConfig .= "#routes here\n";
$serverConfig .= "push \"route 35.231.0.0 255.255.0.0\"\n"; // bandcamp
$serverConfig .= "push \"route 35.226.0.0 255.255.0.0\"\n";
foreach($ips as $ip)
{
    if (strlen($ip) && $ip !== $avoid) {
        $serverConfig .= "push \"route {$ip}0.0 255.255.0.0\"\n";
    }
    if ($ip === $avoid) {
        for($i = 1; $i <= 255; $i++) {
            if ($i !== $exclude[0])
            {
                $serverConfig .= "push \"route {$ip}{$i}.0 255.255.255.0\"\n";
            }
        }
    }
}
file_put_contents($serverConfigPath, $serverConfig);
