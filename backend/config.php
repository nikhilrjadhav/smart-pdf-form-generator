<?php

// Base paths
define('BASE_PATH', realpath(dirname(__FILE__) . '/..'));
define('STORAGE_PATH', BASE_PATH . '/storage');

// Folder paths
define('PDF_PATH', STORAGE_PATH . '/pdfs/');
define('SIGNATURE_PATH', STORAGE_PATH . '/signatures/');

// URL (for future use)
define('BASE_URL', 'http://localhost/smart-pdf-form-generator');

// Timezone
date_default_timezone_set('Asia/Kolkata');

// Ensure directories exist
if (!file_exists(PDF_PATH)) {
    mkdir(PDF_PATH, 0777, true);
}

if (!file_exists(SIGNATURE_PATH)) {
    mkdir(SIGNATURE_PATH, 0777, true);
}