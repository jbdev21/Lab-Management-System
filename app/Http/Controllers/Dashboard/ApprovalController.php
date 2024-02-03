<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Approval;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'model' => ['required'],
            'id' => ['required', 'integer'],
        ]);

        $modelRequest = $request->model; 
        $model = app("App\\Models\\$modelRequest");
        $approval = new Approval;
        $approval->user_id = $request->user()->id;
        $approval->note = $request->note;
        $model->where("id", $request->id)
            ->first()
            ->approvals()
            ->save($approval);
        flash()->success('Approval Saved!');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Approval $approval)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Approval $approval)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Approval $approval)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Approval $approval)
    {
        $approval->delete();
        flash()->success('Approval Revoked!');
        return back();
    }
}
