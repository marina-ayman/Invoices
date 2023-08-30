<?php

namespace App\Http\Controllers;
use App\Models\section;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=products::all();
        $sections=section::all();
       
        return view('products.products',compact('products','sections'));
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
       
        $validateData=$request->validate([
            'Product_name'=> 'required|max:255',
            'description' => 'required',
            'section_id'  => 'required'
        ],[
            'Product_name.required' => 'اسم المنتج مطلوب',
            'description.required' => 'الوصف مطلوب',
            'section_id.required' => 'القسم مطلوب'
        ]);
      
       products::create([
            'Product_name' => $request->Product_name,
            'description' => $request->description,
            'section_id' => $request->section_id
        ]);

        session()->flash('Add','تم اضافة المنتج بنجاح');
        return redirect('/products');

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function show(products $products)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit(products $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

      
        $id = section::where('section_name', $request->section_name)->first()->id;
       
    

        $this->validate($request,[
            'Product_name'=> 'required|max:255',
            'description' => 'required',
            'section_name'  => 'required'
        ],[
            'Product_name.required' => 'اسم المنتج مطلوب',
            'description.required' => 'الوصف مطلوب',
            'section_id.required' => 'القسم مطلوب'
        ]);
     
      
        $products=products::findOrFail($request->pro_id);
       
        $products->update([
            'Product_name' => $request->Product_name,
            'description' => $request->description,
            'section_id' => $id,
            ]);

        session()->flash('edit','تم تعديل المنتج بنجاح');
        return redirect('/products');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id=$request->id;
        products::find($id)->delete();
        session()->flash('delete','تم حذف المنتج بنجاح');
        return redirect('/products');
    }
}
