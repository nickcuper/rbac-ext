<?php
return array (
  'items' => 
  array (
    'createPost' => 
    array (
      'type' => 2,
      'description' => 'Create a post',
    ),
    'updatePost' => 
    array (
      'type' => 2,
      'description' => 'Update post',
    ),
    'author' => 
    array (
      'type' => 1,
      'children' => 
      array (
        0 => 'createPost',
      ),
      'assignments' => 
      array (
        1 => 
        array (
          'roleName' => 'author',
        ),
      ),
    ),
    'admin' => 
    array (
      'type' => 1,
      'children' => 
      array (
        0 => 'updatePost',
        1 => 'author',
      ),
      'assignments' => 
      array (
        2 => 
        array (
          'roleName' => 'admin',
        ),
      ),
    ),
  ),
  'rules' => 
  array (
  ),
);
