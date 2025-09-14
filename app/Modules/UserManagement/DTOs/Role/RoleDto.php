<?php

namespace App\Modules\UserManagement\DTOs\Role;

use App\Core\DTOs\BaseDto;

class RoleDto extends BaseDto
{
    public ?int $id;
    public string $name;
    public ?int $display_order;

    public function getDataForTable(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'display_order' => $this->display_order
        ];
    }

    public function getDataForSelectOption(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
