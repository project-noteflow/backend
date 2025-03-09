<?php

namespace App\Enums;

enum TypeUser: int
{
    case SuperAdmin = 1;
    case Admin = 2;
    case Client = 3;
}
