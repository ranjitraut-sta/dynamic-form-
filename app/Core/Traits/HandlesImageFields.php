<?php
namespace App\Core\Traits;
use Illuminate\Support\Arr;

trait HandlesImageFields
{
    /*
    |--------------------------------------------------------------------------
    | Handles Image Fields
    |--------------------------------------------------------------------------
    | - Data array / object bhitra ko image fields lai handle garna use huney
    |   reusable trait.
    | - Provided `$imageFields` (field => folder mapping) ko basis ma images
    |   upload garxa.
    | - Request ma file aayeko cha bhane:
    |     • `fileUploadService->upload()` call garxa.
    |     • Old file (update case) delete/replace garna support garxa.
    |     • Related record ID pani pass garna milcha.
    | - Request ma file chaina ra record create case ho bhane:
    |     • Missing image field lai `null` set garxa.
    | - Return: processed data array jasma image fields sahi value (uploaded file
    |   name/path or null) sanga huncha.
    */
    protected function processImageFields($data, array $imageFields, $request, $existingRecord = null)
    {
        $dataArray = is_object($data) && method_exists($data, 'toArray') ? $data->toArray() : (array) $data;
        $processedData = Arr::except($dataArray, array_keys($imageFields));

        foreach ($imageFields as $field => $folder) {
            if ($request->hasFile($field)) {
                $processedData[$field] = $this->fileUploadService->upload(
                    $request,
                    $field,
                    $folder,
                    true,
                    $existingRecord->{$field} ?? null,
                    is_object($data) ? ($data->id ?? null) : null,
                    true
                );
            } elseif (!$existingRecord) {
                $processedData[$field] = null; // create case
            }
        }

        return $processedData;
    }

}
