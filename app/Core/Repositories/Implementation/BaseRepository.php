<?php

namespace App\Core\Repositories\Implementation;

use App\Core\Repositories\Interface\BaseRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;

class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getAll()
    {
        return $this->model->latest()->get();
    }

    public function createRecord(array $data)
    {
        return $this->model->create($data);
    }

    public function findById($id)
    {
        if(!$id) return false;
        return $this->model->findOrFail($id);
    }

    public function updateRecord($id, array $data)
    {
        if(!$id) return false;
        $record = $this->findById($id);
        $record->update($data);
        return $record;
    }

    public function deleteRecord($id)
    {
        if(!$id) return false;
        return $this->findById($id)->delete();
    }

   public function paginateWithSearchFilters(
        int $perPage,
        array $filters = [],
        ?string $filterField = null,
        ?int $filterId = null,
        ?string $sortDir = 'asc',
        ?string $sortBy = null,
        array $searchableFields = [],
        array $appends = [],
        ?Builder $baseQuery = null  // ✨ New
    ) {
        $query = $baseQuery ?? $this->model->newQuery(); // ✨ fallback if no base query

        // Dynamic single ID filter
        if (!empty($filterField) && !empty($filterId)) {
            $query->where($filterField, $filterId);
        }

        // Apply basic filters
        foreach ($filters as $key => $value) {
            if (empty($value) || in_array($key, ['search', 'date_filters'])) {
                continue;
            }

            // Skip column check if using baseQuery (could include joins)
            if ($baseQuery || Schema::hasColumn($this->model->getTable(), $key)) {
                $query->where($key, $value);
            }
        }

        // Date filters
        if (!empty($filters['date_filters']) && is_array($filters['date_filters'])) {
            foreach ($filters['date_filters'] as $column => $range) {
                if ($baseQuery || Schema::hasColumn($this->model->getTable(), $column)) {
                    if (!empty($range['from'])) {
                        $query->whereDate($column, '>=', $range['from']);
                    }
                    if (!empty($range['to'])) {
                        $query->whereDate($column, '<=', $range['to']);
                    }
                }
            }
        }

        // Search (only when not using baseQuery — or extend manually)
        if (!empty($filters['search']) && !empty($searchableFields)) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search, $searchableFields) {
                foreach ($searchableFields as $field) {
                    if (str_contains($field, '.')) {
                        [$relation, $column] = explode('.', $field);
                        $q->orWhereHas($relation, function ($relationQuery) use ($column, $search) {
                            $relationQuery->where($column, 'like', "%{$search}%");
                        });
                    } else {
                        $q->orWhere($field, 'like', "%{$search}%");
                    }
                }
            });
        }

        // Sorting
        $sortDir = strtolower($sortDir ?? 'asc');
        if (!in_array($sortDir, ['asc', 'desc'])) {
            $sortDir = 'asc';
        }

        // Use default sort column if invalid or missing
        if (!$sortBy || (!$baseQuery && !Schema::hasColumn($this->model->getTable(), $sortBy))) {
            $sortBy = 'id';
        }

        $query->orderBy($sortBy, $sortDir);

        return $query->paginate($perPage)->appends(array_merge([
            'length' => $perPage,
        ], $filters, $appends));
    }


    public function updateDisplayOrder(array $data, string $tableName, string $idColumn, string $orderColumn)
    {
        foreach ($data as $item) {
            DB::table($tableName)
                ->where($idColumn, $item[$idColumn])
                ->update([$orderColumn => $item[$orderColumn]]);
        }
        return true;
    }

    public function bulkDestroy(array $ids)
    {
        return $this->model->whereIn('id', $ids)->delete();
    }

}
