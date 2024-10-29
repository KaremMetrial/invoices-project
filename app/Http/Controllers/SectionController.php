<?php

namespace App\Http\Controllers;

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
        return view('sections.index');
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
    public function store(Request $request)
    {
        $input = $request->all();

        $db_exist = Section::where('section_name', $request->section_name)->first();

        if ($db_exist) {
           return redirect()->back()->with('error', 'القسم موجود مسبقا');
        } else {
            Section::create([
                'section_name' => $request->section_name,
                'description' => $request->description,
                'created_by' => (Auth::user()->name),
            ]);
            session()->flash('Add', 'تم اضافة القسم بنجاح ');
            return redirect('/sections');
        }
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
    public function update(Request $request, Section $section)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        //
    }
}
