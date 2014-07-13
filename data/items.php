<?php
return [
    'createPost' => [
        'type' => 2,
        'description' => 'Create a post',
    ],
    'rbacPost' => [
        'type' => 2,
        'description' => 'Rbac Post',
    ],
    'viewPost' => [
        'type' => 2,
        'description' => 'View a post',
        'ruleName' => 'view',
    ],
    'deletePost' => [
        'type' => 2,
        'description' => 'Delete post',
        'ruleName' => 'delete',
    ],
    'updatePost' => [
        'type' => 2,
        'description' => 'Update post',
        'ruleName' => 'update',
    ],
    'author' => [
        'type' => 1,
        'children' => [
            'createPost',
            'viewPost',
        ],
    ],
    'admin' => [
        'type' => 1,
        'children' => [
            'updatePost',
            'deletePost',
            'author',
        ],
    ],
    'rbac' => [
        'type' => 1,
        'children' => [
            'rbacPost',
            'viewPost',
        ],
    ],
];
