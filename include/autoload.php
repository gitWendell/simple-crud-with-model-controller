<?php 

class Autoloader {
    protected $sources = [
        '\\app\\controllers\\',
        '\\app\\models\\',
        '\\app\\query\\',
        '\\app\\config\\',
        '\\app\\services\\',
        '\\app\\global\\',
    ];
    protected $file;

    public function sources() {
        return $this->sources;
    }

    public function getFile($sub_path, $className) {
        $file = dirname(__DIR__) . '\\' . $className . '.php';
        $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
        $this->file = $file;

        return $this;
    }

    public function include_if_exists($file = null) {
        $this->file = $file ?? $this->file;

        if(file_exists($this->file)) {
            include_once($this->file);
        }
    }
    
}
$loader = new Autoloader;

spl_autoload_register(function($className) use($loader) {
    $sources = $loader->sources();

    foreach($sources as $source) {
        $exploded = explode("\\", $source);

        if($exploded[2] == 'global') $className = 'app\global\Helpers';
        
        $loader->getFile($source, $className)->include_if_exists();
    }
});

?>