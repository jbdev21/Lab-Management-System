<?php

namespace App\Observers;

use App\Models\Approval;
use App\Models\Booking;
use App\Models\Leave;

class ApprovalObserver
{
    public function created(Approval $approval)
    {
        if ($approval->approvable_type === Leave::class) {
            $leaveId = $approval->approvable_id;

            Leave::where('id', $leaveId)->update(['status' => 'approved']);

        }elseif($approval->approvable_type === Booking::class) {

            $id = $approval->approvable_id;

            Booking::where('id', $id)->update(['status' => 'approved']);
        }
    }
}
