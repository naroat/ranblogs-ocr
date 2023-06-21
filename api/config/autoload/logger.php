<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

$formatter = [
    'class' => Monolog\Formatter\LogstashFormatter::class,
    'constructor' => [
//        'format' => null,
//        'dateFormat' => 'Y-m-d H:i:s',
//        'allowInlineLineBreaks' => true,
        'applicationName' => env('APP_NAME', 'hyperf-pro'),
    ],
];
return [
    'default' => [
        'handlers' => [
            [
                'class' => Monolog\Handler\RotatingFileHandler::class,
                'constructor' => [
                    'filename' => BASE_PATH . '/runtime/logs/info.log',
                    'level' => Monolog\Logger::INFO,
                ],
                'formatter' => $formatter,
            ],
            [
                'class' => Monolog\Handler\RotatingFileHandler::class,
                'constructor' => [
                    'filename' => BASE_PATH . '/runtime/logs/warning.log',
                    'level' => Monolog\Logger::WARNING,
                ],
                'formatter' => $formatter,
            ],
            /*[
                'class' => Monolog\Handler\RotatingFileHandler::class,
                'constructor' => [
                    'filename' => BASE_PATH . '/runtime/logs/debug.log',
                    'level' => Monolog\Logger::DEBUG,
                ],
                'formatter' => $formatter,
            ],*/
            [
                'class' => Monolog\Handler\RotatingFileHandler::class,
                'constructor' => [
                    'filename' => BASE_PATH . '/runtime/logs/error.log',
                    'level' => Monolog\Logger::ERROR,
                ],
                'formatter' => $formatter,
            ],
        ],
    ],
];
