
<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;

$s3 = new S3Client([
    'region'  => 'your-region', // e.g., 'us-west-2'
    'version' => 'latest',
    'credentials' => [
        'key'    => 'your-access-key-id',
        'secret' => 'your-secret-access-key',
    ]
]);

$bucket = 'your-s3-bucket-name';
?>