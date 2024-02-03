<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Deduction;
use App\Models\Project;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
class DashboardController extends Controller
{
    function index()
    {
        // return 1;
        // $pdf = App::make('snappy.pdf.wrapper');
        // return \PDF::loadHTML('<h1>Test</h1>')
        //             ->setPaper('legal')
        //             ->setOrientation('landscape')
        //             ->setOption('margin-bottom', 5)
        //             ->setOption('margin-top', 5)
        //             ->setOption('margin-left', 5)
        //             ->setOption('margin-right', 5)
        //             ->inline();
        // return $pdf->inline();
        $projects = Project::whereStatus("ongoing")->get();
        $deductions = Deduction::all();
        return view('dashboard.dashboard', compact("projects", 'deductions'));
    }
}
