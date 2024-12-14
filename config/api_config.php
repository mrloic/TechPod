<?php
return [
    'base_url' => 'http://localhost:8801/api',
    'endpoints' => [
        // Employee API
        'employees' => [
            'get_all' => '/EmployeeItems/GetEmployee',
            'get_one' => '/EmployeeItems/GetEmployee/{id}',
            'add' => '/EmployeeItems/AddEmployee',
            'update' => '/EmployeeItems/UpdateEmployee/{id}',
            'delete' => '/EmployeeItems/DeleteEmployee/{id}',
        ],
        // Object API
        'objects' => [
            'get_all' => '/ObjectItems/GetObjects',
            'get_one' => '/ObjectItems/GetObjects/{id}',
            'add' => '/ObjectItems/AddObject',
            'update' => '/ObjectItems/UpdateObjects/{id}',
            'delete' => '/ObjectItems/DeleteObjects/{id}',
        ],
        // Work API
        'work' => [
            'get_all' => '/WorkItems/GetWork',
            'get_one' => '/WorkItems/GetWork/{id}',
            'add' => '/WorkItems/AddWork',
            'update' => '/WorkItems/UpdateWork/{id}',
            'delete' => '/WorkItems/DeleteWork/{id}',
        ],
        // FAQ API
        'faq' => [
            'get_all' => '/FAQ/GetFAQ',
            'get_one' => '/FAQ/GetFAQ/{id}',
            'add' => '/FAQ/AddFAQ',
            'update' => '/FAQ/UpdateFAQ/{id}',
            'delete' => '/FAQ/DeleteFAQ/{id}',
        ],
    ],
];
?>