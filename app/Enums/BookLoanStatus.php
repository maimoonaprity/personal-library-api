<?php

namespace App\Enums;


enum BookLoanStatus: string
{
    case BORROWED = 'BORROWED';
    case RETURNED = 'RETURNED';
}