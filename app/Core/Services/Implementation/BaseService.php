<?php

namespace App\Core\Services\Implementation;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;
class BaseService
{
    protected $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    public function getAll()
    {
        return $this->repository->getAll();
    }

    public function createRecord($data)
    {
        $data = $this->convertToArray($data);
        return $this->repository->createRecord($data);
    }

    public function findById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function updateRecord($data, int $id)
    {
        $data = $this->convertToArray($data);
        return $this->repository->updateRecord($id, $data);
    }

    public function deleteRecord(int $id)
    {
        return $this->repository->deleteRecord($id);
    }

    protected function convertToArray($data)
    {
        if (is_object($data) && method_exists($data, 'toArray')) {
            return $data->toArray();
        }
        return (array) $data;
    }

    public function paginateWithSearchFilters(int $perPage, array $filters = [], ?string $filterField = null, ?int $filterId = null, ?string $sortDir = 'asc', ?string $sortBy = null, array $searchableFields = [], array $appends = [], ?Builder $baseQuery = null)
    {
        return $this->repository->paginateWithSearchFilters($perPage, $filters, $filterField, $filterId, $sortDir, $sortBy, $searchableFields, $appends);
    }

    public function getCurrentLoginUserId()
    {
        return auth()->user()->id;
    }

    public function getSelectOptions(
        string $dtoClass,
        ?int $filterId = null,
        string $filterField = 'user_id',
        $status = null,
        ?int $includeId = null
    ) {
        return $this->buildSelectOptions($dtoClass, $filterId, $filterField, $status, $includeId);
    }

    public function getSelectOptionForEdit($dataId, $dtoClass, ?int $filterId = null, $status = null, ?int $includeId = null, string $filterField = 'client_id'): Collection
    {
        $defaultStatus = $status ?? 1;
        return $this->buildSelectOptions($dtoClass, $filterId, $filterField, $defaultStatus, $dataId);
    }

    public function updateDisplayOrder(array $data, string $tableName, string $idColumn, string $orderColumn)
    {
        return $this->repository->updateDisplayOrder($data, $tableName, $idColumn, $orderColumn);
    }

    public function bulkDestroy(array $ids)
    {
        return $this->repository->bulkDestroy($ids);
    }


     /*
     |----------------------------------------------------------------------------------
     | Private Methods
     |----------------------------------------------------------------------------------
     | - yaha bata tala sabai private function haru handle gariyako xa yo Service ko
     */
    private function buildSelectOptions(string $dtoClass, ?int $filterId, string $filterField, $status, ?int $includeId): Collection
    {
        $items = $this->getAll();

        if ($status !== null) {
            $items = $items->filter(fn($item) => $item->status == $status || $item->id == $includeId);
        }

        if ($filterId !== null) {
            $items = $items->filter(fn($item) => data_get($item, $filterField) === $filterId);
        }

        return $dtoClass::transformForSelectOption($dtoClass::fromCollection($items));
    }

}
