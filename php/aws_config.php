
<?php
require 'vendor/autoload.php';

use Aws\S3\S3Client;

$s3 = new S3Client([
    'region'  => 'us-east-2', 
    'version' => 'v4',
    'credentials' => [
        'key'    => 'process.env.AWS_ACCESS_KEY_ID',
        'secret' => 'process.env.AWS_SECRET_ACCESS_KEY',
    ]
]);

$bucket = 'lifeline-directupload-testing';
?>