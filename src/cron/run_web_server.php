<?php
$path    = "/home/pi/pi-announcer/src/web";
$user    = 'pi';
$ip      = "192.168.11.137";

/*********************************************************************************/
/*********************************************************************************/
/*********************************************************************************/

$path    = realpath($path);
$command = "nohup php {$path}/artisan serve --host={$ip}  >/dev/null 2>&1 &";

$commandKeys = ["artisan serv"];

$lines = explode("\n", trim(
    shell_exec('ps -C php -f')
));

$isRunning = false;
foreach ($lines as $line) {
    foreach ($commandKeys as $commandKey) {
        if (strpos($line, $commandKey) !== false) {
            print "\n\n{$line}\n\n";
            $isRunning = true;
        }
    }
}
if (!$isRunning) {
    exec($command);
}