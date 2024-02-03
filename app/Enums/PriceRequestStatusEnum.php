<?php
namespace App\Enums;

enum PriceRequestStatusEnum : string{
    case DRAFT  = "draft";
    case SUBJECT_FOR_APPROVAL = "Subject For Approval";
    case APPROVED = "Approved";
}
