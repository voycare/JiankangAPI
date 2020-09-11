<?php

namespace App\Traits;

use App\Consts;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;

trait MediaClass
{
    use ProcessUploadMedia;

    public function upload($type, $image_base64, $id)
    {
        // type: 0: avatar
        $path = $id;
        switch ($type) {
            case Consts::CERTIFICATE:
                $type_action = 'certificates';
                break;
            case Consts::DOCUMENTS;
                $type_action = 'documents';
                break;
            case Consts::AVATAR:
                $type_action = 'avatars';
                break;
            case Consts::DOCTOR:
                $type_action = 'doctors';
                break;
            case Consts::NEWS:
                $type_action = 'news';
                break;
            case Consts::CLINICS:
                $type_action = 'clinics';
                break;
        }
        @list(, $image_base64) = explode(',', $image_base64);
        $filename = Str::random(3);
        //generating unique file name;
        $file_name = 'image_' . $filename . '.jpeg';
        $link = '';
        if ($image_base64 != "") { // storing image in storage/app/public Folder
            $data = new \stdClass();
            $data->action = $type_action;
            $data->path = $path . '/' . $file_name;
            $data->base64 = ($image_base64);
            $this->processMedia($data);
            $link = DIRECTORY_SEPARATOR . $type_action . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $file_name;
        }
        return $link;
    }

}
