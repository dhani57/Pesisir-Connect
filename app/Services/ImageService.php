<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Compress and convert uploaded image to WebP format.
     *
     * @param UploadedFile $file
     * @param string $directory
     * @param int $maxWidth
     * @param int $quality
     * @return string Path to the saved WebP image relative to public disk
     */
    public static function compressAndConvertToWebp(UploadedFile $file, string $directory, int $maxWidth = 1200, int $quality = 80): string
    {
        // Get image details
        $imageInfo = @getimagesize($file->getRealPath());
        if (!$imageInfo) {
            // Fallback to storing natively if not an image
            return 'storage/' . $file->store($directory, 'public');
        }

        $mime = $imageInfo['mime'];
        $width = $imageInfo[0];
        $height = $imageInfo[1];

        // Create image resource based on MIME type
        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $image = @imagecreatefromjpeg($file->getRealPath());
                break;
            case 'image/png':
                $image = @imagecreatefrompng($file->getRealPath());
                if ($image) {
                    imagepalettetotruecolor($image);
                    imagealphablending($image, true);
                    imagesavealpha($image, true);
                }
                break;
            case 'image/webp':
                $image = @imagecreatefromwebp($file->getRealPath());
                break;
            case 'image/gif':
                $image = @imagecreatefromgif($file->getRealPath());
                if ($image) {
                    imagepalettetotruecolor($image);
                }
                break;
            default:
                // Fallback to storing as is for unsupported image types
                return 'storage/' . $file->store($directory, 'public');
        }

        if (!$image) {
            return 'storage/' . $file->store($directory, 'public');
        }

        // Resize dynamically if the width exceeds the max allowed limit
        if ($width > $maxWidth) {
            $newWidth = $maxWidth;
            $newHeight = (int) (($height / $width) * $maxWidth);

            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);
            
            // Maintain alpha transparency channel for PNG/WebP formats
            if ($mime === 'image/png' || $mime === 'image/webp') {
                imagealphablending($resizedImage, false);
                imagesavealpha($resizedImage, true);
            }

            imagecopyresampled($resizedImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $resizedImage;
        }

        // Generate unique filename with .webp suffix
        $filename = Str::random(40) . '.webp';
        
        // Ensure path exists in storage public folder
        $fullDestDir = storage_path('app/public/' . $directory);
        if (!file_exists($fullDestDir)) {
            @mkdir($fullDestDir, 0755, true);
        }

        $fullPath = $fullDestDir . '/' . $filename;

        // Render resource to WebP format
        if (@imagewebp($image, $fullPath, $quality)) {
            imagedestroy($image);
            return 'storage/' . $directory . '/' . $filename;
        }

        // Fallback in case imagewebp fails
        imagedestroy($image);
        return 'storage/' . $file->store($directory, 'public');
    }
}
