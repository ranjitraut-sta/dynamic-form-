<?php

namespace App\Core\Traits;

use Illuminate\Support\Facades\Storage;

trait ClearsTempImageUploads
{
    public function clearTempFiles(array $fields)
    {
        $storage = Storage::disk('public');
        $tempFolder = 'temp';

        if ($storage->exists($tempFolder)) {
            $files = $storage->allFiles($tempFolder); // सबै files
            $storage->delete($files); // delete all files
        }

        // optional: subdirectories पनि हटाउने हो भने
        $directories = $storage->allDirectories($tempFolder);
        foreach ($directories as $dir) {
            $storage->deleteDirectory($dir);
        }

        // session मा भए temp key हरु हटाउन चाहनुहुन्छ भने
        session()->flash('clear_temp_files', $fields);
    }
}
