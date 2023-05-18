<?php

namespace App\Vendor;

class Table
{
    private $map = [
        'users' => [
            'columns' => [
                'name' => 'Name',
                'email' => 'Email'
            ],
        ],
        'bikes' => [
            'columns' => [
                'name' => 'Name',
                'price' => 'Price',
            ],
        ],
        'parts' => [
            'columns' => [
                'name' => 'Name',
                'price' => 'Price',
            ],
        ],
        'accessories' => [
            'columns' => [
                'name' => 'Name',
                'price' => 'Price',
            ],
        ],
        'parameters' => [
            'columns' => [
                "type" => "Type",
                "name" => "Name",
                "unit" => "Unit",
            ],
        ],
    ];

    public function __construct(string $tableName, array $actions = [])
    {
        $this->tableName = $tableName;
        $this->title = $this->map[$this->tableName]['title'] ?? strtoupper($tableName);
        $this->columns = $this->map[$this->tableName]['columns'];
        $this->headers = array_values($this->columns);
        $this->fieldNames = array_keys($this->columns);
        $this->actions = $actions;
    }
}
