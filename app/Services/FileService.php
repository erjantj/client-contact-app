<?php

namespace App\Services;

use App\Imports\ClientImport;
use App\Models\Client;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class FileService
{
    /**
     * Import file
     * @param  UploadedFile $file file
     * @return string file name
     */
    public function import(UploadedFile $file)
    {
        if ($file instanceof UploadedFile) {
            $fileData = Excel::toArray(new ClientImport, $file);
            return $fileData[0];
        }

        return [];
    }
}
