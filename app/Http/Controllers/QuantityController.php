<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\Decimal;
use App\Models\{Material, Category, Quantity};

class QuantityController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categories = Category::get();
        $materials = null;

        if (old('category_id')) {
            $materials = Material::where('category_id', old('category_id'))->get();
        }
        return view('quantities.create', compact('categories', 'materials'));
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
            'category_id' => 'bail|required|integer|exists:categories,id',
            'material_id' => [
                'bail', 'required', 'integer',
                Rule::exists('materials', 'id')->where('category_id', $request->category_id)
            ],
            'date' => 'bail|required|date',
            'quantity' => ['bail', 'required', new Decimal(0, 2)],
        ], [
            'category_id.required' => 'Please select the category',
            'category_id.integer' => 'Please select the valid category',
            'category_id.exists' => 'Please select the valid category',
            'material_id.required' => 'Please select the material name',
            'material_id.integer' => 'Please select the valid material name',
            'material_id.exists' => 'Please select the valid material name',
            'quantity.required' => 'Please enter the :attribute',
        ]);

        try { // store the record in database table
            $quantity = new Quantity;
            $quantity->material_id = $request->material_id;
            $quantity->date = $request->date;
            $quantity->quantity = $request->quantity;
            $quantity->save();

            // success message
            $response = redirect()->back()
                ->with(['success' => 'Material quantity added successfuly']);
        } catch (\Throwable $e) { // exception handling can be added here
            dd($e);
            $response = redirect()->back()->withInput()
                ->with(['error' => 'Failed to add material quantity']);
        } finally {
            return $response;
        }
    }

    public function manage()
    {
        $materialQuantities = Material::selectRaw(
                'materials.id, categories.name as category_name, materials.name as material_name, materials.opening_balance, materials.opening_balance + SUM(quantities.quantity) as current_balance, materials.deleted_at'
            )
            ->join('categories', 'materials.category_id', '=', 'categories.id')
            ->join('quantities', 'materials.id', '=', 'quantities.material_id')
            ->groupBy('quantities.material_id')
            ->withTrashed()
            ->get();

        return view('material-quantities.index', compact('materialQuantities'));
    }
}
