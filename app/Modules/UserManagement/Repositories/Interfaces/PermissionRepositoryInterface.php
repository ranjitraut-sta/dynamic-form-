<?php

namespace App\Modules\UserManagement\Repositories\Interfaces;

interface PermissionRepositoryInterface
{
    public function getAllPermission();
    public function getModel();
    public function createRecord(array $data);
    public function findById($id);
    public function updateRecord($id, array $data);
    public function deleteRecord($id);
}
