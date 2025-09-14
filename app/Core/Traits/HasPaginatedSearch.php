<?php
namespace App\Core\Traits;
use Illuminate\Database\Eloquent\Builder;
trait HasPaginatedSearch
{
    /**
     * Pagination sanga search ra filter garera result paune general method
     *
     * @param int $perPage
     *     - Prati page kati ota record dekhaune bhanera specify garne.
     *
     * @param array $filters
     *     - Filter ko associative array. 'search' key samet sakcha, aru pani custom filter fields pathauna milcha.
     *
     * @param array $searchableFields
     *     - Search garna milne field haru ko list (column names ko array).
     *
     * @param string $dtoClass
     *     - Fully qualified DTO class ko naam (mapping garna use hune class).
     *
     * @param bool $useFromCollection
     *     - true vaye, DTO class ko fromCollection() method use garera mapping garincha;
     *       false vaye, direct mapForTable() bata mapping huncha.
     *
     * @param string $sortDir
     *     - Sorting direction ('asc' ya 'desc').
     *
     * @param string $sortBy
     *     - Sorting garna khojeko column ko naam.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     *     - Paginated result DTO format ma return garincha.
     */

   public function hasPaginatedWithSearch(
    int $perPage,
    array $filters = [],
    array $searchableFields = [],
    string $dtoClass,
    bool $useFromCollection = true,
    string $sortDir = 'desc',
    string $sortBy = 'id',
    ?Builder $baseQuery = null,   // ✨ new param
    ?string $filterField = null,  // ✨ add this
    ?int $filterId = null         // ✨ add this
) {
    // Extract search term if exists in filters, else null
    $search = $filters['search'] ?? null;

    // Call repository method that applies filters, search, sorting, pagination
    $paginator = $this->repository->paginateWithSearchFilters(
        perPage: $perPage,
        filters: $filters,
        filterField: $filterField,   // ✨ pass here
        filterId: $filterId,         // ✨ pass here
        sortDir: $sortDir,
        sortBy: $sortBy,
        searchableFields: $searchableFields,
        baseQuery: $baseQuery        // ✨ pass baseQuery too
    );

    // Map DTOs if required
    if ($useFromCollection && method_exists($dtoClass, 'fromCollection')) {
        $dtos = $dtoClass::fromCollection($paginator->getCollection());
        $records = $dtoClass::mapForTable($dtos);
    } else {
        $records = $dtoClass::mapForTable($paginator->getCollection());
    }

    $paginator->setCollection($records);

    // Append filters to pagination links ✨
    return $paginator->appends($filters);
}


}
