<?php

namespace App\Actions\Category;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreIconAction
{
    public function handle(UploadedFile|null $icon): string
    {
        $filePath = "images/categories/";
        $publicFilePath = public_path("storage/" . $filePath);

        if (!file_exists($publicFilePath)) {
            mkdir(public_path($publicFilePath), 666, true);
        }

        $file = Storage::disk('public')->put($filePath, $icon);

        if (!$file) {
            abort(500);
        }

        return $filePath . $icon->hashName();
    }
}
