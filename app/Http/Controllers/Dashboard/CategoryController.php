<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\CategoryEnum;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        // if(!$request->user()->can('view categories')){
        //     abort(401, "You are not authorized on this resource");
        // }


        $query = Category::query();

        if($request->type){
            $query->where('type', $request->type);
        }
        if($request->q){
            $query->where('name', 'LIKE', '%' . $request->q . '%');
        }

        $categories = $query->paginate();
        $types = CategoryEnum::cases();

        return view('dashboard.category.index', [
            'categories'=> $categories,
            'types'=> $types,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $category = new Category;
        $category->name = $request->name;
        $category->type = $request->type;
        $category->parent_id = $request->parent_id;
        $category->save();

        flash()->success('Category added successfully!');
        return redirect()->route('dashboard.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }


    public function edit(Category $category)
    {
        $types = CategoryEnum::cases();
        return view('dashboard.category.edit', [
            'category' => $category,
            'types' => $types,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->name = $request->name;
        $category->type = $request->type;
        $category->parent_id = $request->parent_id;
        $category->save();

        flash()->success('Category updated successfully!');
        return redirect()->route('dashboard.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return back();
    }
}
