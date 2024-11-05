<?php
class Cache {
    private $cacheDir;

    public function __construct($cacheDir = 'cache/') {
        $this->cacheDir = rtrim($cacheDir, '/') . '/';
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir);
        }
    }

    public function get($key) {
        $file = $this->cacheDir . md5($key) . '.cache';
        if (file_exists($file)) {
            return unserialize(file_get_contents($file));
        }
        return false;
    }

    public function set($key, $data) {
        $file = $this->cacheDir . md5($key) . '.cache';
        file_put_contents($file, serialize($data));
    }
}
?>
