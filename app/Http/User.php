<?php

namespace App\Http;

class User
{
    public function __construct(
        public string $id,
        public ?string $firstName,
        public ?string $lastName,
        public string $email,
        public ?string $avatar = null,
        public ?bool $new_user = false,
    ) {}
}
