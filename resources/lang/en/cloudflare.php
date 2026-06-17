<?php

return [
    'http_response_codes' => [
        '200' => 'OK - request successful',
        '304' => 'Not Modified',
        '400' => 'Bad Request - request was invalid',
        '401' => 'Unauthorized - user does not have permission',
        '403' => 'Forbidden - request not authenticated',
        '429' => 'Too many requests - client is rate limited',
        '405' => 'Method Not Allowed - incorrect HTTP method provided',
        '415' => 'Unsupported Media Type - response is not valid JSON',
    ],
];
