<?php

        namespace App\Modules\DashboardManagement\DTOs;

        class DashboardManagementDTO
        {
            public string $example;

            public function __construct(string $example)
            {
                $this->example = $example;
            }

            public static function fromArray(array $data): self
            {
                return new self(
                    $data['example'] ?? ''
                );
            }

            public function toArray(): array
            {
                return ['example' => $this->example];
            }
        }