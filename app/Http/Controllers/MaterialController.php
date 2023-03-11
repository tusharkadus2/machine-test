<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rules\Decimal;
use App\Models\{Material, Category};

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materials = Material::with('category')->withTrashed()->get();

        return view('materials.index', compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        return view('materials.create', compact('categories'));
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
            'name' => 'bail|required|string|max:255',
            'category_id' => 'bail|required|integer|exists:categories,id',
            'opening_balance' => ['bail', 'required', new Decimal(0, 2)],
        ], [
            'name.required' => 'Please enter the :attribute',
            'name.string' => 'The :attribute must be valid string',
            'name.max' => 'The :attribute must not be greater than 255 characters.',
            'category_id.required' => 'Please select the category',
            'category_id.integer' => 'Please select the valid category',
            'category_id.exists' => 'Please select the valid category',
            'opening_balance.required' => 'Please enter the :attribute',
        ]);

        try { // store the record in database table
            $material = new Material;
            $material->name = $request->name;
            $material->category_id = $request->category_id;
            $material->opening_balance = $request->opening_balance;
            $material->save();

            // success message
            $response = redirect()->route('materials.index')
                ->with(['success' => 'Material added successfuly']);
        } catch (\Throwable $e) { // exception handling can be added here
            $response = redirect()->back()->withInput()
                ->with(['error' => 'Failed to add new material.']);
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
    public function edit(Material $material)
    {
        /*
            set previous URL in session, to later redirect back to it after updating the material
            as this page (edit material form) is being redirected to from materials listing page and manage materials page.
        */

        session(['url.comingFrom' => url()->previous()]);

        $material->load('category');
        $categories = Category::get();

        return view('materials.edit', compact('categories', 'material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Material $material)
    {
        $request->validate([ // validate request
            'name' => 'bail|required|string|max:255',
            'category_id' => 'bail|required|integer|exists:categories,id',
            'opening_balance' => 'bail|required|regex:/^-?\d{0,4}(?:[.,]\d{0,2})?$/',
        ], [
            'name.required' => 'Please enter the :attribute',
            'name.string' => 'The :attribute must be valid string',
            'name.max' => 'The :attribute must not be greater than 255 characters.',
            'category_id.required' => 'Please select the category',
            'category_id.integer' => 'Please select the valid category',
            'category_id.exists' => 'Please select the valid category',
            'opening_balance.required' => 'Please enter the :attribute',
        ]);

        try { // update the record in database table
            $material->name = $request->name;
            $material->category_id = $request->category_id;
            $material->opening_balance = $request->opening_balance;
            $material->save();

            // Redirect to the previous page if 'url.comingFrom' is present in session
            if(session()->has('url.comingFrom')) {
                $response = redirect()->to(session('url.comingFrom'))
                    ->with(['success' => 'Material updated successfuly']);
            } else {
                $response = redirect()->route('materials.index')
                    ->with(['success' => 'Material updated successfuly']);
            }
        } catch (\Throwable $e) { // exception handling can be added here
            $response = redirect()->back()->withInput()
                ->with(['error' => 'Failed to update Material.']);
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
    public function destroy(Material $material)
    {
        $material->delete();

        return redirect()->route('materials.index')
            ->with(['success' => 'Material deleted successfully']);
    }

    public function restore(Request $request, $id)
    {
        Material::withTrashed()->findOrFail($id)->restore();

        return redirect()->route('materials.index')
            ->with(['success' => 'Material restored successfully']);
    }

    public function getMaterialsByCategory(Request $request)
    {
        return response()->json([
            'materials' => Material::where('category_id', $request->category_id)->get()
        ], 200);
    }
}
