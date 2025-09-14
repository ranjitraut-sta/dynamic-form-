<?php

namespace App\Core\Services\Implementation;

use App\Core\Services\Interface\FileUploadServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use InvalidArgumentException;

class FileUploadService implements FileUploadServiceInterface
{
    protected array $uploadPaths;

    public function __construct()
    {
        $this->uploadPaths = \App\Constants\UploadPaths::PATHS;
    }

    /*
    |--------------------------------------------------------------------------
    | File Upload Method Description
    |--------------------------------------------------------------------------
    | - Request bata file upload garincha, upload key ko config anusar path ra prefix set garera.
    | - Purano file cha bhane trash ma move garincha.
    | - Image bhaye bhane compression pani garna milcha.
    | - Public ki default storage disk ma file save garincha.
    | - Upload gareko file ko naam return garincha, natra null return huncha.
    | - Exception throw huncha jaba upload key invalid hunchha.
    */
    public function upload(
        Request $request,
        string $field,
        string $uploadKey,
        bool $public = true,
        ?string $oldFilename = null,
        ?string $id = null,
        bool $iscompression = true
    ): ?string {
        if (!$request->hasFile($field)) {
            return null;
        }

        $file = $request->file($field);
        $config = $this->uploadPaths[$uploadKey] ?? null;

        if (!$config || !isset($config['path'], $config['prefix'])) {
            throw new InvalidArgumentException("Invalid upload key: {$uploadKey}");
        }

        $diskName = $public ? 'public' : config('filesystems.default');
        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk($diskName);

        $folder = $config['path'];
        $filename = time() . '_' . $config['prefix'] . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        // Move old file to trash if exists
        if ($oldFilename) {
            $this->moveToTrash($folder, $oldFilename, $id, $public);
        }

        $this->makeDirectoryIfNotExists($folder, $diskName);

        if ($iscompression) {
            // Get absolute local path if disk supports it
            if (method_exists($disk, 'path')) {
                $destPath = $disk->path($folder . '/' . $filename);
            } else {
                // fallback if path() not available
                $destPath = storage_path('app/' . ($public ? 'public/' : '') . $folder . '/' . $filename);
            }

            $compressed = $this->compressImage(
                $file->getPathname(),
                $destPath,
                75
            );

            if (!$compressed) {
                // fallback if compression fails
                $disk->putFileAs($folder, $file, $filename);
            }
        } else {
            // No compression, just store
            $disk->putFileAs($folder, $file, $filename);
        }

        return $filename;
    }

   /*
    |--------------------------------------------------------------------------
    | Move File to Trash Method Description
    |--------------------------------------------------------------------------
    | - Dine folder ra filename ko file lai trash folder ma move garincha.
    | - Optional id ko basis ma trash folder organize garincha.
    | - Public storage disk ki default disk ma file move garincha.
    | - File move successful bhaye true return garincha, natra false.
    */
    public function moveToTrash(
        string $folder,
        string $filename,
        ?string $id = null,
        bool $public = false
    ): bool {
        $diskName = $public ? 'public' : config('filesystems.default');
        $disk = Storage::disk($diskName);

        $originalPath = $folder . '/' . $filename;
        $trashPath = $folder . '/trash/' . ($id ?? 'unknown') . '/' . $filename;

        if ($disk->exists($originalPath)) {
            return $disk->move($originalPath, $trashPath);
        }

        return false;
    }

    /*
    |--------------------------------------------------------------------------
    | Permanently Delete File Method Description
    |--------------------------------------------------------------------------
    | - Dine folder ra filename ko file lai permanent delete garincha.
    | - Public storage disk ki default disk bata delete garincha.
    | - Delete successful bhaye true return garincha, natra false.
    */
    public function deleteFile(string $folder, string $filename, bool $public = false): bool
    {
        $diskName = $public ? 'public' : config('filesystems.default');
        $disk = Storage::disk($diskName);

        return $disk->delete($folder . '/' . $filename);
    }

    /*
    |--------------------------------------------------------------------------
    | Clear Temporary Files Method Description
    |--------------------------------------------------------------------------
    | - Diyeko filename haru ko array anusar 'temp' folder bhitra ko sab temporary files delete garincha.
    | - Storage ma thap unnecessary file haru basna nadei clean rakhna use garincha.
    | - Return value chaina, process matra ho.
    */
    public function clearTempFiles(array $fields): void
    {
        foreach ($fields as $field) {
            $this->deleteFile('temp', $field);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Trash Old File If Exists Method Description
    |--------------------------------------------------------------------------
    | - Diyeko purano file lai trash folder ma move garne kaam garincha.
    | - Upload key ko config bata file ko path lincha.
    | - Upload key invalid bhaye exception throw garincha.
    | - Filename empty nabhayema matra file lai trash ma pathauncha.
    | - Public storage disk ki default disk ma file move huncha.
    | - Return value void ho, kunai result return gardaina.
    */
    public function trashOldFileIfExists(string $uploadKey, string $filename, string $id, bool $public = true): void
    {
        $config = $this->uploadPaths[$uploadKey] ?? null;

        if (!$config || !isset($config['path'])) {
            throw new InvalidArgumentException("Invalid upload key: {$uploadKey}");
        }

        if (!empty($filename)) {
            $this->moveToTrash($config['path'], $filename, $id, $public);
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Image Compress Garne Function
    |--------------------------------------------------------------------------
    | - GD library ko prayog gari image file lai compress garincha.
    | - Source path bata file lina, destination path ma save garincha.
    | - Quality 0–100 samma lina sakincha, default 75 thik huncha.
    | - JPEG, PNG ra WEBP image haru lai support garcha.
    | - Unsupported image type ma false return garincha.
    | - Image resource clear garera memory free garincha.
    | - Safal bhaye true, asafal bhaye false return huncha.
    */
    function compressImage(string $sourcePath, string $destinationPath, int $quality = 75): bool
    {
        $info = getimagesize($sourcePath);
        if (!$info) {
            return false;
        }

        $mime = $info['mime'];

        switch ($mime) {
            case 'image/jpeg':
                /** @var \GdImage|resource $image */
                $image = imagecreatefromjpeg($sourcePath);
                $result = imagejpeg($image, $destinationPath, $quality);
                break;

            case 'image/png':
                /** @var \GdImage|resource $image */
                $image = imagecreatefrompng($sourcePath);
                // PNG compression level: 0 (no compression) to 9 (max compression)
                $compressionLevel = (int) round((100 - $quality) / 10);
                $result = imagepng($image, $destinationPath, $compressionLevel);
                break;

            case 'image/webp':
                /** @var \GdImage|resource $image */
                $image = imagecreatefromwebp($sourcePath);
                $result = imagewebp($image, $destinationPath, $quality);
                break;

            default:
                // Unsupported image type
                return false;
        }

        if (isset($image) && (is_resource($image) || $image instanceof \GdImage)) {
            imagedestroy($image);
        }

        return $result;
    }


   /*
    |--------------------------------------------------------------------------
    | Directory Ensure Garne Function
    |--------------------------------------------------------------------------
    | - Diyeko disk ra folder ko directory exist cha ki chaina check garincha.
    | - Directory exist nagareko bhaye naya directory banaincha.
    | - Kunai return value chaina, void matra ho.
    */
    protected function makeDirectoryIfNotExists(string $folder, string $diskName): void
    {
        $disk = Storage::disk($diskName);
        if (!$disk->exists($folder)) {
            $disk->makeDirectory($folder);
        }
    }

     /*
    |--------------------------------------------------------------------------
    | Get File Info Method Description
    |--------------------------------------------------------------------------
    | - Upload key ko config anusar file ko path lincha.
    | - Upload key invalid bhaye exception throw garincha.
    | - Filename empty nabhayema matra file lai trash ma pathauncha.
    | - Public storage disk ki default disk ma file move huncha.
    | - Return value void ho, kunai result return gardaina.
    */
    public function getFileInfo(string $pathKey, string $filename): array
    {
        $config = \App\Constants\UploadPaths::PATHS[$pathKey] ?? null;

        if (!$config || !isset($config['path'])) {
            return [
                'url' => null,
                'is_pdf' => null,
            ];
        }

        $path = rtrim($config['path'], '/'); // this was failing if $config was not string

        $fullPath = "{$path}/{$filename}";

        return [
            'url' => asset('storage/' . $fullPath),
            'is_pdf' => strtolower(pathinfo($filename, PATHINFO_EXTENSION)) === 'pdf',
        ];
    }
}
