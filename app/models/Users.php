<?php

namespace app\models;

use app\query\Builder;

class Users extends Builder {

    protected $columns = [
        'firstname',
        'lastname',
        'moddilename',
        'age',
        'is_active',
    ];

    protected $default = [
        'is_active' => 'active'
    ];
}

?>