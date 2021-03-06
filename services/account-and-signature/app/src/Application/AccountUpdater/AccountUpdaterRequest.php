<?php
namespace App\Application\AccountUpdater;

class AccountUpdaterRequest {
    public string $accountId;
    public string $email;
    public string $firstName;
    public string $lastName;
    public ?string $password;
    public ?string $signature;
}
