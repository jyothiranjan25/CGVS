<?php
class UserTypeENUM
{
    const ADMIN = 'ADMIN';
    const STUDENT = 'STUDENT';
}

function getUserTypes()
{
    $reflection = new ReflectionClass(UserTypeENUM::class);
    return $reflection->getConstants();
}

class UserRolesENUM
{
    const ADMIN = 'ADMIN';
    const SUPERADMIN = 'SUPERADMIN';
}

function getUserRoles()
{
    $reflection = new ReflectionClass(UserRolesENUM::class);
    return $reflection->getConstants();
}