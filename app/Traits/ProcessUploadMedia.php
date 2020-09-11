<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 3/25/2019
 * Time: 16:40
 */

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ProcessUploadMedia
{
    /**
     * @param $data
     */
    public function processMedia($data)
    {
        if (!is_dir(storage_path($data->action))) {
            mkdir(storage_path($data->action));
        }
        Storage::disk($data->action)->put($data->path, base64_decode($data->base64));
    }
}