<?php

namespace App\Lib;

abstract class Model
{
    protected $database;

    protected $table;

    protected $fillable = [];

    public function __construct()
    {
        $this->database = (new Connection())->db;
    }

    public function create(array $data)
    {
        $emptyData = array_diff($this->fillable, array_keys($data));

        if (count(array_keys($data)) > count($this->fillable)) {
            $emptyData = array_diff(array_keys($data), $this->fillable);
        }

        $cleanData = $data;
        foreach ($emptyData as $hideField) {
            unset($cleanData[$hideField]);
        }

        $buildValues = array_fill(1, count($cleanData), '?');
        $buildValues = implode(', ', $buildValues);
        $fields = implode(', ', array_keys($cleanData));

        $stmt = $this->database->prepare("insert into users({$fields}) values({$buildValues})");
        $stmt->execute(array_values($cleanData));

        return true;
    }

    public function find(string $field, $value, $select = '*')
    {
        $stmt = $this->database->prepare("SELECT {$select} FROM {$this->table} WHERE {$field}=:value LIMIT 1");
        $stmt->execute(compact('value'));
        $user = $stmt->fetch();

        return $user;
    }
}
