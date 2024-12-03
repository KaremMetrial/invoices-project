<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Section;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::select([
            'id',
            'product_name',
            'description',
            'section_id',
        ])->with('section:id,section_name')->get();

        $sections = Section::select([
            'id',
            'section_name',
        ])->with('products:id,product_name')->get();

        return view('products.index', [
            'products' => $products,
            'sections' => $sections,
        ]);

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
    public function store(StoreProductRequest $request)
    {

        // Validate the request data
        $validatedData = $request->validated();

        // Create a new product
        $product = Product::create($validatedData);

        // Redirect to the products index page with a success message
        return redirect()->route('products.index')
            ->with('Add', 'تم اضافة المنتج بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */public function update(UpdateProductRequest $request, Product $product)
{
    // Validate the request data
    $validatedData = $request->validated();

    // Update the product with the validated data
    $product->update($validatedData);

    // Check if the product was actually changed
    if (!$product->wasChanged()) {
        return redirect()->route('products.index')
            ->with('error', 'لم يتم إجراء أي تعديلات على المنتج.');
    }

    // Redirect to the products index page with a success message
    return redirect()->route('products.index')
        ->with('Add', 'تم تعديل المنتج بنجاح');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')
            ->with('Add', 'تم حذف المنتج بنجاح');
    }
}
