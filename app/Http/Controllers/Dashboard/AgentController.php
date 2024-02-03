<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = User::query()
                ->where("is_agent", 1)
                ->orderBy('name');

        if ($request->q) {
            $query = User::search($request->q);
        }
        
        if ($request->status != '') {
            $query = User::whereActive($request->status ?? 0);

        }

        $users = $query->paginate(15);

        return view('dashboard.agent.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.agent.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'name'              => 'required',
            'address'           => 'required',
            'contact_number'    => 'required',
            'position'          => 'required',
            'username'          => 'required|unique:users,username'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->contact_number = $request->contact_number;
        $user->position = $request->position;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->is_agent = 1;

        $user->save();

        return redirect()->route('dashboard.agent.index')->with('success', 'Agent has been added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('dashboard.agent.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('dashboard.agent.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->contact_number = $request->contact_number;
            $user->position = $request->position;
            $user->username = $request->username;

            if ($request->password) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return redirect()->route('dashboard.agent.index')->with('success', 'Agent has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return back()->with('delete', ' Record Deleted!');
    }
}
