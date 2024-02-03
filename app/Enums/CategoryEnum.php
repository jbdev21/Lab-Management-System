<?php
namespace App\Enums;

enum CategoryEnum : string{
    case CUSTOMER_CLASSIFICATION  = "Customer Classification";
    case ATTACHMENT_CLASSIFICATION = "Attachment Classification";
    case CUSTOMER_REQUIREMENT = "Customer Requirement";
    case LEAVES = "Employee Leaves Type";
}
