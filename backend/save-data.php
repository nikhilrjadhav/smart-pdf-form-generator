<?php
require_once('config.php');

function saveFormData($data)
{
    $file = STORAGE_PATH . '/form-data.json';

    // Read existing data
    $existingData = [];

    if (file_exists($file)) {
        $existingData = json_decode(file_get_contents($file), true);
    }

    // Add new record
    $existingData[] = [
        'name' => $data['name'],
        'email' => $data['email'],
        'agree' => $data['agree'],
        'pdf' => $data['pdf'],
        'created_at' => date('Y-m-d H:i:s')
    ];

    // Save back
    file_put_contents($file, json_encode($existingData, JSON_PRETTY_PRINT));
}