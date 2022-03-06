<?php
define('DROP_FOLDER', '/home/jtodd/projects/pi-announcer/drops');
while (true) {
    quitIfRunningAlready();

    foreach (getDropFiles() as $file) {
        playFile($file);
        sleep(5);
    }

    sleep(5);
}

function playFile($file)
{

    $contents = file_get_contents($file);
    $text     = (str_replace(["\n", "\""], [" ", ""], $contents));
    $command  = 'espeak "' . $text . '"';
    exec($command);
    unlink($file);
}

function getDropFiles()
{
    quitIfDropsDontExist();
    $files = [];
    foreach (scandir(DROP_FOLDER) as $file) {
        $dropFolder = DROP_FOLDER;
        if (substr($dropFolder, -1) == '/') {
            $dropFolder = substr($dropFolder, 0, strlen($dropFolder) - 1);
        }

        $fullPath = "{$dropFolder}/$file";
        if (substr($file, 0, 1) == '.' || is_dir($fullPath)) {
            continue;
        }
        $files[] = $fullPath;
    }
    return $files;
}

function quitIfDropsDontExist()
{
    if (!file_exists(DROP_FOLDER)) {
        print "\nDrop Folder not defined or does not exist\n\n";
        exit;
    }
}

function quitIfRunningAlready()
{
    $fileName = pathinfo(__FILE__, PATHINFO_FILENAME);
    $tmpPath  = "/tmp/{$fileName}.pid";
    $pid      = getmypid();
    $filePid  = getFilePid($tmpPath);
    if ($pid == $filePid) {
        // print "\nalready running, don't check\n\n";
        return;
    }
    $pids = getRunningPids();
    if (in_array($filePid, $pids)) {
        print "\nrunning somewhere else, quit now\n\n";
        exit;
        return;
    }
    deleteFilePid($tmpPath);
    setFilePid($tmpPath, $pid);
    // print "\n not running, set new pid\n\n";

}

function getRunningPids()
{

    $pids  = [];
    $lines = explode("\n", trim(
        shell_exec('ps -C php -f')
    ));

    $headings = preg_split('/\s+/', $lines[0]);
    for ($x = 1; $x < count($lines); $x++) {
        $values = preg_split('/\s+/', $lines[$x]);
        $row    = [];
        foreach ($headings as $id => $heading) {
            $row[$heading] = $values[$id];
        }
        $pids[] = $row['PID'];

    }
    return $pids;
}

function getFilePid($tmpPath)
{
    $filePid = null;
    if (file_exists($tmpPath)) {
        $filePid = trim(file_get_contents($tmpPath));
    }
    return $filePid;
}

function deleteFilePid($tmpPath)
{
    if (file_exists($tmpPath)) {
        unlink($tmpPath);
    }
}

function setFilePid($tmpPath, $pid)
{
    file_put_contents($tmpPath, $pid);
}

function quitIfRunningAlready2()
{
    $fileName = pathinfo(__FILE__, PATHINFO_FILENAME);
    $pid      = getmypid();
    $tmpPath  = "/tmp/{$fileName}.pid";
    file_put_contents($tmpPath, $pid);
    while (true) {
        print "yes";
        sleep(1);
    }

}
