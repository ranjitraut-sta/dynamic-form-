<?php

declare(strict_types=1);

namespace App\Modules\UserManagement\DTOs\User;

use App\Core\DTOs\BaseDto;
use Carbon\Carbon;

class UserDto extends BaseDto
{
    public ?int $id;
    public string $name;
    public string $email;
    public ?string $email_verified_at;
    public ?string $email_verification_token;
    public ?string $password = null;
    public ?int $role_id;
    public int $is_superadmin;
    public ?string $last_login;
    public bool $status;
    public ?string $remember_token;
    public ?string $profile_image;
    public ?int $display_order;
    public ?string $full_name;

    public function getDataForTable($data): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'last_login' => $this->last_login
                ? Carbon::parse($this->last_login)->format('F d, Y h:i A')
                : 'Never',
            'status' => $this->status ? '1' : '0',
            'role_name' => $data->name ?? 'No Role',
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
