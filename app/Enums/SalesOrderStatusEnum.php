<?php
namespace App\Enums;

enum SalesOrderStatusEnum : string{
    case DRAFT  = "draft";
    case FULL_RELEASED = "full-released";
    case PARTIAL_RELEASED = "partial-released";
}
