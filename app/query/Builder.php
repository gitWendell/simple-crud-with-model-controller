<?php

namespace app\query;

use app\services\BuilderServices;

abstract class Builder extends BuilderServices{
    protected $table;
    protected $model;
    protected $processor;
    protected $selector = [];
    protected $columns;
    protected $where;
    protected $values;
    protected $print = false;

    public $operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=', '<=>',
        'like', 'like binary', 'not like', 'ilike',
        '&', '|', '^', '<<', '>>', '&~',
        'rlike', 'not rlike', 'regexp', 'not regexp',
        '~', '~*', '!~', '!~*', 'similar to',
        'not similar to', 'not ilike', '~~*', '!~~*',
    ];

    protected $query =[
        'action' => '',
        'selector' => '',
        'table' => '',
        'columns' => '',
        'from' => '',
        'where' => '',
        'values' => ''
    ];

    public function __construct() {
        $this->setTable($this->getTable());
        $this->setColumns($this->getColumns());
    }

    // Getters and Setters
    public function getTable() {
        return $this->table ?? $this->class_to_tablename($this);
    }

    public function setTable($table) {
        $this->query['table'] = $table;

        return $this;
    }

    public function getColumns() {
        return $this->columns;
    }

    public function setColumns($columns) {

        $this->query['columns'] = $this->convertArrayColumnsString($columns);
    }

    // End of Getters and Setters

    // Content of the Class
    public function action($action) {
        $this->query['action'] = $action;

        return $this;
    }

    public function selector($columns = ['*']) {
        $this->query['selector'] = $this->convertArrayColumnsString($columns);

        return $this;
    }

    public function where($column, $operator = "=", $value) {
        $condition = $column . " ". $operator. " \"" . $value . "\"";

        if($this->query['where']) {
            $this->query['where'] = $this->query['where'] . " AND " . $condition;
        } else {
            $this->query['where'] = $condition;
        }

        return $this;
    }

    public function values(array $values) {
        foreach($values as $key => $value) {
            $value = is_string($value) ? $this->addDoubleQuoteFirstLast($value) : $value;

            if(!is_numeric($key)) $this->setColumns(array_keys($values));

            if($this->query['values']) {
                $this->query['values'] = $this->query['values'] . ', ' . $value;
            } else {
                $this->query['values'] = $value;
            }
        }

        return $this;
    }

    public function valuesWithColumn(array $values) {
        foreach($values as $key => $value) {
            $valueWithColumn = is_string($value) 
                ? $key . " = ". $this->addDoubleQuoteFirstLast($value) 
                : $key . " = ". $value;


            if($this->query['values']) {
                $this->query['values'] = $this->query['values'] . ', ' . $valueWithColumn;
            } else {
                $this->query['values'] = $valueWithColumn;
            }
        }

        return $this;
    }

    public function process() {
        $this->processor = new Processor($this->query);
        if($this->print) $this->processor->print = true;

        return $this->processor->process();
    }

    public function printSql() {
        $this->print = true;

        return $this;
    }
    // End of Content of the class
}

?>