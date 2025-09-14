<?php

namespace App\Core\Http;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

abstract class BaseCrudController extends BaseController
{
    protected string $dtoClass;
    protected string $routePrefix;
    protected string $viewPrefix;
    protected string $entityName; // e.g., 'User', 'Post', 'Category'
    protected $service; // ideally interface type

    public function dataIndex($perPage, $searchTerm)
    {
        $data = $this->prepareCommonData($this->entityName . ' List');
        $data['records'] = $this->service->getPaginatedSearchResults($perPage, $searchTerm);

        return view($this->viewPrefix . 'index', ['data' => $data]);
    }

    public function dataShow($id, $extraData = [])
    {
        $data = array_merge($this->prepareCommonData('View ' . $this->entityName), $extraData);
        $data['record'] = $this->service->findRecord($id);

        return view($this->viewPrefix . 'show', ['data' => $data]);
    }

    public function dataCreate($extraData = [])
    {
        $data = array_merge($this->prepareCommonData('Create ' . $this->entityName), $extraData);
        return view($this->viewPrefix . 'create', ['data' => $data]);
    }

    public function dataStore(FormRequest $request)
    {
        $dto = $this->makeDto($this->dtoClass, $request->validated());

        $result = $this->service->createRecord($dto->toArray());

        return $result
            ? $this->redirectWithSuccess($this->routePrefix . 'index', 'Created Successfully')
            : $this->redirectWithError($this->routePrefix . 'create', 'Something went wrong');
    }

    public function dataEdit($id, $extraData = [])
    {
        $data = array_merge($this->prepareCommonData('Edit ' . $this->entityName), $extraData);
        $data['record'] = $this->service->findById($id);

        return view($this->viewPrefix . 'create', ['data' => $data]);
    }

    public function dataUpdate(FormRequest $request, $id)
    {
        $dto = $this->makeDto($this->dtoClass, $request->validated());

        $result = $this->service->updateRecord($dto->toArray(), $id);

        return $result
            ? $this->redirectWithSuccess($this->routePrefix . 'index', 'Updated Successfully')
            : $this->redirectWithError($this->routePrefix . 'edit', 'Something went wrong');
    }

    public function dataDelete($ids)
    {
        if (is_array($ids)) {
            $result = $this->service->bulkDestroy($ids);
            $message = count($ids) > 1
                ? count($ids) . ' records deleted successfully'
                : 'Deleted Successfully';
        } else {
            $result = $this->service->deleteRecord($ids);
            $message = 'Deleted Successfully';
        }

        return $result
            ? $this->redirectWithSuccess($this->routePrefix . 'index', $message)
            : $this->redirectWithError($this->routePrefix . 'index', 'Something went wrong');
    }

    protected function updateOrderInternal(Request $request, string $table, string $idColumn = 'id', string $orderColumn = 'display_order')
    {
        $this->service->updateDisplayOrder($request->order, $table, $idColumn, $orderColumn);

        return response()->json(['message' => 'Order updated']);
    }

}
