<?php

namespace app\services;

class BuilderServices {

    public function convertArrayColumnsString($columns) {
        $stringedColumns = '';

        foreach($columns as $column) {
            if($stringedColumns) {
                $stringedColumns = $stringedColumns .', '. $column;
            } else {
                $stringedColumns =  $column;
            }
        }
        
        return $stringedColumns;
    }

    public function class_to_tablename($class) {
        $classname = strtolower($this->get_class_name($class));
        $exploded = explode("\\" , $classname);

        return end($exploded);
    }

    public function get_class_name($class) {
        return get_class($class);
    }

    public function addDoubleQuoteFirstLast($string) {
        return "\"" .$string."\"";
    }
}

?>