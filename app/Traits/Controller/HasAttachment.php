<?php 
namespace App\Traits\Controller;

use App\Contract\AttachmentContract;
use App\Models\Attachment;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait HasAttachment {
    
    function deleteAttachment(Attachment $attachment) {
        $attachment->delete();
        return back()->with("success","Attachement deleted!");
    }

    function addAttachment(Request $request, $id) {
        $model = app($this->model)->findOrFail($id);
        $attachment = new Attachment;
        $attachment->category_id = $request->category_id;
        $attachment->file_name = $request->file("attachment")->getClientOriginalName();
        $attachment->path = $request->file("attachment")->store("attachments");
        $attachment->user_id = Auth::user() ? Auth::user()->id :0;
        $model->attachments()->save($attachment);
        return back()->with("success","Uploading attachment success!");
    }

    
}