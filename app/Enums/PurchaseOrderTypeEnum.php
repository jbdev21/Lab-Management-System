<?php
namespace App\Enums;

enum PurchaseOrderTypeEnum : string{
    case RAW_MATERIAL  = "Raw Material";
    case OTHERS = "Others";
    case SAMPLE = "Samples";
}
