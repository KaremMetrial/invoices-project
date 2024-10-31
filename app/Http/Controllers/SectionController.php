<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // get all sections
        $sections = Section::select('id', 'section_name', 'description', 'created_by')->get();
        return view('sections.index', compact('sections'));
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
    public function store(StoreSectionRequest $request)
    {
      
        // insert data
        Section::create([
            'section_name' => $request->section_name,
            'description' => $request->description,
            'created_by' => (Auth::user()->name),
        ]);

        session()->flash('Add', 'تم اضافة القسم بنجاح ');

        // return redirect('/sections');
        return redirect('/sections');
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSectionRequest $request, Section $section)
    {
        // Update data
        $section->update($request->validated());
    
        // Check if the section was actually changed
        if (!$section->wasChanged()) {
            // If no changes were made, return a message
            session()->flash('error', 'لم يتم تعديل القسم');    
            return redirect()->back();
        }
    
        // If changes were made, return a success message
        session()->flash('Add', "تم تعديل القسم '{$section->name}' بنجاح");
        return redirect()->route('sections.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        try {
            $sectionName = $section->section_name;
            $section->delete();
            
            return redirect()
                ->route('sections.index')
                ->with('Add', "تم حذف القسم '{$sectionName}' بنجاح");
                
        } catch (\Exception $e) {
            return redirect()
                ->route('sections.index')
                ->with('error', 'حدث خطأ أثناء حذف القسم');
        }
    }
    
}
