<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::get();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([ // validate request
            'name' => 'bail|required|string|max:255'
        ], [
            'name.required' => 'Please enter the :attribute',
            'name.string' => 'The :attribute must be valid string',
            'name.max' => 'The :attribute must not be greater than 255 characters.',
        ]);

        try { // store the record in database table
            $category = new Category;
            $category->name = $request->name;
            $category->save();

            // success message
            $response = redirect()->route('categories.index')
                ->with(['success' => 'Category added successfuly']);
        } catch (\Throwable $e) { // exception handling can be added here
            $response = redirect()->back()->withInput()
                ->with(['error' => 'Failed to add new category.']);
        } finally {
            return $response;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate([ // validate request
            'name' => 'bail|required|string|max:255'
        ], [
            'name.required' => 'Please enter the :attribute',
            'name.string' => 'The :attribute must be valid string',
            'name.max' => 'The :attribute must not be greater than 255 characters.',
        ]);

        try { // update the record in database table
            $category->name = $request->name;
            $category->save();

            // success message
            $response = redirect()->route('categories.index')
                ->with(['success' => 'Category updated successfuly']);
        } catch (\Throwable $e) { // exception handling can be added here
            $response = redirect()->back()->withInput()
                ->with(['error' => 'Failed to update category.']);
        } finally {
            return $response;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
            ->with(['success' => 'Category deleted successfully']);
    }
}
