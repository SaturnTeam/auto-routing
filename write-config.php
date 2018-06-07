<?php
$serverConfigPath = '/etc/openvpn/server.conf';

$ips = file_get_contents('ips.txt');
$ips = explode("\n", $ips);
$serverConfig = file_get_contents($serverConfigPath);
$pos = strpos($serverConfig, '#routes here');
if (!$pos) {
    throw new Exception('Where is fucking string?');
}
$serverConfig = substr($serverConfig, 0, $pos);
$serverConfig .= "#routes here\n";
foreach($ips as $ip)
{
    if ($ip) {
        $serverConfig .= "push \"route {$ip} 255.255.255.254\"\n";
    }
}
file_put_contents($serverConfigPath, $serverConfig);
