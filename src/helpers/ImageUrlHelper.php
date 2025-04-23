<?php

namespace app\helpers;

use dmstr\willnorrisImageproxy\Url;

class ImageUrlHelper extends Url
{
    /**
     * Absolute image download for the given image or directory path
     */
    public static function download($downloadSource): ?string
    {
        return self::image($downloadSource);
    }

    /**
     * Relative download path for the given image or directory path
     */
    public static function downloadRelative(string $path): string
    {
        return '/img/download/' . ltrim($path, '/') . self::getSuffix();
    }

    /**
     * Relative stream path for the given image or directory path
     */
    public static function imageRelative(string $path): string
    {
        return '/img/stream/' . ltrim($path, '/') . self::getSuffix();
    }
}
