<?php

namespace App\Modules\UserManagement\DTOs\Permission;
use App\Core\DTOs\BaseDto;
use App\Core\Traits\SelectOptionTransformable;
use App\Core\Traits\TableTransformable;

class PermissionDto extends BaseDto
{
    use TableTransformable;
    use SelectOptionTransformable;

    public ?int $id;
    public string $name;
    public string $action;
    public string $controller;
    public string $group_name;


    public function getDataForTable(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'action' => $this->action,
            'controller' => $this->controller,
            'group_name' => $this->group_name,
        ];
    }
}
