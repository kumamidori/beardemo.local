<?php
$initfileName = 'App.php';
$initfilePath = '../../';

$list = arrayDirList();
$file = __DIR__ . DIRECTORY_SEPARATOR . $initfileName;
foreach ($list as $dir) {
    $fullPath = $dir . '/' . $initfileName;
    $info = pathinfo($fullPath);
    $path = str_replace(__DIR__, '', $info['dirname']);
    $depth = substr_count($path, '/');
    $relativePath = str_repeat('../', $depth);
    var_dump($relativePath);
    $contents = "<?php require_once {$relativePath}$initfileName;";
    file_put_contents($fullPath, $contents);
    echo "[ADD] $fullPath\n";
}

/**
 * @param string $path
 * @param string $path
 * return array
 */
function arrayDirList($path = __DIR__, $level=30) {
    $dirlist = array();
    static $dirFullPathList = array();
    if ($level) {
        $dh = opendir($path);
        while (($filename = readdir($dh))) {
            if ($filename[0] == '.' || $filename == '.' || $filename == '..')
            continue;
            else {
                $realpath = $path.'/'.$filename;
                if (is_link($realpath)) {
                    continue;
                }else if (is_file($realpath)) {
                    //$dirlist[] = $filename;
                } else if (is_dir($realpath)) {
                    $dirlist[$filename] = arrayDirList($realpath, $level-1);
                    $dirFullPathList[] = realpath($realpath);
                }
            }
        }
        closedir($dh);
    }
    return $dirFullPathList;
    //return $dirlist;
}
