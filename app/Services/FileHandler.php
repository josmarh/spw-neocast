<?php

namespace App\Services;

use App\Helpers;
use Illuminate\Support\Facades\File;

class FileHandler
{
    public function saveFile($filetype, $file)
    {
        $dir = 'uploads/';
        $fileHash = bin2hex(random_bytes(16)) . '.' . $filetype;
        $absolutePath = public_path($dir);
        $addPath = public_path($dir . $fileHash);
        $relativePath = $dir . $fileHash;

        if (!File::exists($absolutePath)) {
            File::makeDirectory($absolutePath, 0755, true);
        }

        file_put_contents($addPath, $file);

        $helpers = new Helpers();
        $thumbnail = $helpers->generateThumbnail($relativePath);

        return [
            'filePath' => $relativePath,
            'thumbnail' => $thumbnail
        ];
    }

    public static function saveFromUrl($file, $dir, $filename)
    {
        try {
            $absolutePath = public_path($dir);
            $relativePath = $dir . $filename;
            if (!File::exists($absolutePath)) {
                File::makeDirectory($absolutePath, 0755, true);
            }
            $file = file_get_contents($file);
            file_put_contents($relativePath, $file);
        } catch (\Throwable $th) {
            throw $th;
        }

        return $relativePath;
    }

    public function deleteFile()
    {

    }
}