<?php

namespace App\Core\Services\Interface;
use Illuminate\Database\Eloquent\Builder;

interface BaseServiceInterface
{
    public function getAll();
    public function createRecord($data);
    public function findById(int $id);
    public function updateRecord($data, int $id);
    public function deleteRecord(int $id);
    public function paginateWithSearchFilters(int $perPage, array $filters = [], ?string $filterField = null, ?int $filterId = null, ?string $sortDir = 'asc', ?string $sortBy = null, array $searchableFields = [], array $appends = [], ?Builder $baseQuery = null);
    public function getCurrentLoginUserId();
    public function getSelectOptions(string $dtoClass, ?int $filterId = null, string $filterField = 'user_id', $status = null);
    public function getSelectOptionForEdit($dataId, $dtoClass, ?int $filterId = null, $status = null, ?int $includeId = null, string $filterField = 'client_id');
    public function updateDisplayOrder(array $data, string $tableName, string $idColumn, string $orderColumn);
    public function bulkDestroy(array $ids);
}
