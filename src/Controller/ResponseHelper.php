<?php
declare(strict_types=1);

namespace App\Controller;

class ResponseHelper
{
    /** @var array<string|int, mixed> */
    public static array $result = [];
    public static bool $success = true;
    public static ?string $message = null;

    /** @param string $message */
    public static function badMessage(string $message): void
    {
        self::$message = $message;
        self::$success = false;
    }

    /** @return array<string, mixed> */
    public static function toArray(): array
    {
        return [
            'result' => self::$result,
            'message' => self::$message,
            'success' => self::$success
        ];
    }
}