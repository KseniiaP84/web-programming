<?php

declare(strict_types=1);

namespace App\Services;

use App\Interfaces\LoggerInterface;

class FileLogger implements LoggerInterface
{
    public function log(string $message): void
    {
        $file = __DIR__ . '/../../logs/app.log';

        if (!is_dir(dirname($file))) {
            mkdir(dirname($file), 0777, true);
        }

        file_put_contents(
            $file,
            '[' . date('Y-m-d H:i:s') . '] ' . $message . PHP_EOL,
            FILE_APPEND
        );
    }
}