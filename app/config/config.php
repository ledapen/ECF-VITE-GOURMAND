<?php
declare(strict_types=1);

return [
    'app_name' => getenv('APP_NAME') ?: 'Vite & Gourmand',
    'base_url' => getenv('BASE_URL') ?: 'http://localhost:8000',
    'debug' => (getenv('APP_DEBUG') ?: 'true') === 'true',
    'upload_dir' => __DIR__ . '/../../public/uploads',
    'upload_url' => '/uploads',
];
