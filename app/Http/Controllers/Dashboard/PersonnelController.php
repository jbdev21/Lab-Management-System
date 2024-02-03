<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Ledger;
use App\Models\Personnel;
use Illuminate\Http\Request;

class PersonnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Personnel::query()->orderBy('name');

        if ($request->q) {
            $query = Personnel::where('name', 'LIKE', '%' . $request->q . '%');
        }

        $personnels = $query->paginate(15);

        return view('personnel.index', compact('personnels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate request
        $this->validate($request, [
            'name'              => 'required',
        ]);

        //create personnel
        $personnel = new Personnel();
        $personnel->name = $request->name;
        $personnel->address = $request->address;
        $personnel->contact_number = $request->contact_number;
        $personnel->description = $request->description;
        $personnel->current_cash_advance = $request->current_cash_advance;
        $personnel->save();

        //redirect
        return redirect()->route('personnel.index')->with('success', 'Personnel created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $personnel = Personnel::find($id);
        
        $query = Ledger::query()
            ->where('personnel_id', $id)
            ->whereIn('type', ['credit', 'cash-return'])
            ->orderBy('effectivity_date', 'DESC');

        if ($request->type) {
            $query->where('type', $request->type);
        }
            
        if ($request->date_from && !$request->date_to) {
            $start = Carbon::parse($request->date_from);
            $end = Carbon::parse($request->date_to);
            $query->whereBetween('created_at', [$start->format('Y-m-d'), now()->addDay(1)])->get();
        }

        if ($request->date_from && $request->date_to) {
            $start = Carbon::parse($request->date_from);
            $end = Carbon::parse($request->date_to);
            $query->whereBetween('created_at', [$start->format('Y-m-d'), $end->addDay(1)->format('Y-m-d')])->get();
        }

        $ledgers = $query->paginate(15);

        return view('personnel.show', compact('ledgers', 'personnel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //edit personnel
        $personnel = Personnel::find($id);
        return view('personnel.edit', compact('personnel'));
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
        //validate personnel
        $this->validate($request, [
            'name'              => 'required',
        ]);

        //update personnel with new data
        $personnel = Personnel::find($id);
        $personnel->name = $request->name;
        $personnel->address = $request->address;
        $personnel->contact_number = $request->contact_number;
        $personnel->description = $request->description;
        $personnel->save();

        //redirect
        return redirect()->route('personnel.index')->with('success', 'Personnel updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //delete personnel
        $personnel = Personnel::find($id);
        $personnel->delete();

        //redirect
        return redirect()->route('personnel.index')->with('success', 'Personnel deleted successfully');
    }
}
