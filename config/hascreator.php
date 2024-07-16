<?php

return [
    // The column name that will be used to store the user id
    'column_name' => 'created_by',

    // The model that will be used to get the user id
    'model' => 'App\Models\User',

    // Should the package auto set the user id when creating a model
    'auto_set' => true,
];
