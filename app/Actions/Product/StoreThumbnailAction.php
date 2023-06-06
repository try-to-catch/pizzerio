<?php

namespace App\Actions\Product;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Exception\NotSupportedException;
use Intervention\Image\Facades\Image;

class StoreThumbnailAction
{
    public function handle(UploadedFile $thumbnail): string
    {
        $filePath = "images/products/";
        $fullPath = $filePath.$thumbnail->hashName();

        try {
            $image = Image::make($thumbnail)->fit(450, 450)->encode();

            Storage::disk('public')->put($fullPath, $image);
        } catch (NotSupportedException $e) {
            Log::alert($e);
            abort(500);
        }

        return $fullPath;
    }
}
