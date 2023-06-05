<?php

namespace App\Actions\Product;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Intervention\Image\Exception\NotWritableException;
use Intervention\Image\Facades\Image;

class StoreThumbnailAction
{
    public function handle(UploadedFile $thumbnail): string
    {
        $fileName = $thumbnail->hashName();
        $filePath = "images/products/";
        $pathFromStorage = "storage/" . $filePath;

        if (!file_exists($pathFromStorage)) {
            mkdir($pathFromStorage, 666, true);
        }

        try {
            Image::make($thumbnail)
                ->fit(450, 450)
                ->save($pathFromStorage . $fileName);
        } catch (NotWritableException $e) {
            Log::alert($e);
            abort(500);
        }

        return $filePath . $fileName;
    }
}
