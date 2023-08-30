<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionRequest;
use App\Models\products;
use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections=section::all();
        return  view('sections.sections',compact('sections'));
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
         /*  
        $input=$request->all();

    
         _____________________ //نتاكد ان اسم القسم مش موجود قبل كده
      $b_exist=Section::where('section_name',$input['section_name'])->exists();

        if($b_exist){
         session()->flash('Error','خطا القسم مسجل مسبقا');
          return redirect('/sections');

        }else{
               Section::create([
                'section_name' => $request->section_name,
                'description' => $request->description,
                'Created_by' => (Auth::user()->name),
            ]);

             session()->flash('Add','تم اضافة القسم بنجاح');
            return redirect('/sections');
        }

         _______________________ //  validation  في طريقه تاني بال 
            */
           
            $validateData=$request->validate([
                'section_name'=> 'required|unique:sections|max:255',
                'description' => 'required'
            ],[
                'section_name.required' => 'اسم القسم مطلوب',
                'section_name.unique' => 'هذا القسم موجود سابقا',
                'description.required' => 'الوصف مطلوب'
            ]);
          
            Section::create([
                'section_name' => $request->section_name,
                'description' => $request->description,
                'Created_by' => (Auth::user()->name),
            ]);

            session()->flash('Add','تم اضافة القسم بنجاح');
            return redirect('/sections');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id=$request->id;

        $this->validate($request,[
            'section_name'=> 'required|unique:sections|max:255',$id,
            'description' => 'required'
        ],[
            'section_name.required' => 'اسم القسم مطلوب',
            'section_name.unique' => 'هذا القسم موجود سابقا',
            'description.required' => 'الوصف مطلوب'
        ]);

        $sections=products::find($id);
        $sections->update([
            'section_name'=> $request->section_name,
            'description'=> $request->description,
        ]);

        
        session()->flash('edit','تم تعديل القسم بنجاح');
        return redirect('/sections');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id=$request->id;
        $sections=section::find($id)->delete();
        session()->flash('delete','تم حذف القسم بنجاح');
        return redirect('/sections');
    }
}
