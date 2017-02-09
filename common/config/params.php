<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
	
	'image_servers' => [
            1 => [
                'type' => 'AmazonS3',
                'bucket' => 'img123',
                'hostname' => 'https://img123.s3.amazonaws.com',
                'active' => false
            ],
            2 => [
                'type' => 'AmazonS3',
                'bucket' => 'acars',
                'hostname' => 'https://acars.s3.amazonaws.com',
                'active' => true
            ],
    ],
];
