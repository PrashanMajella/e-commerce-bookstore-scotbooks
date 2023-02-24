<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var String $image
     * @var String $location
     * @return string
     */
    public function saveImage(String $image, String $location)
    {
        if(preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            $image = substr($image, strpos($image, ',') + 1);
            $type = strtolower($type[1]);

            $imageFileTypes = ['jpg', 'jpeg', 'png', 'gif', 'tif', 'tiff'];

            if (!in_array($type, $imageFileTypes)) {
                throw new \Exception('Invalid image type.');
            }

            $image = str_replace(' ', '+', $image);
            $image = base64_decode($image);

            if ($image === false) {
                throw new \Exception('base64_decode() failed.');
            }

        } else {
            throw new \Exception('Did not match data URI with image data.');
        }

        $path = 'images/'.$location;
        $file = Str::random().'.'.$type;
        $absolutePath = 'public/'.$path;
        $relativePath = $absolutePath.$file;

        if (!Storage::exists($absolutePath)) {
            Storage::makeDirectory($absolutePath);
        }

        if (!Storage::disk('local')->put($relativePath, $image)) {
            throw new \Exception("Unable to save file \"{$file}\"");
        }

        /**
         * To create the symbolic link, you may use the storage:link
         * Artisan command
         *
         * 'php artisan storage:link'
         */
        return $relativePath;
    }

    /**
     * @var string $imageUrl
     * @return boolean
     */
    public function deleteImage(String $imageUrl)
    {
        $relativePath = parse_url($imageUrl)['path'];
        $relativePath = str_replace('storage', 'public', $relativePath);

        if (Storage::delete($relativePath)) {
            return true;
        }

        return false;
    }
}
