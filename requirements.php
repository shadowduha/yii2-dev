<?php
$src = __DIR__ . '/vendor';
$dstDir = __DIR__ . '/application/vendor';
if (!is_dir($dstDir)) {
    symlink($src, $dstDir);
}
require 'application/requirements.php';
