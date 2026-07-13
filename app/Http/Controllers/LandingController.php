<?php

namespace App\Http\Controllers;

use App\Departments;
use App\Doctor;
use App\LandingSections;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Get landing sections configuration
        $sections = LandingSections::all();
        $data = [];
        foreach ($sections as $section) {
            $data[$section->title] = $section->is_enable;
        }

        // Get departments (services)
        $departments = Departments::where('is_deleted', 0)
            ->orderBy('name')
            ->get();

        // Get active doctors with their user information and department
        $doctors = Doctor::with(['user' => function($query) {
                $query->where('is_deleted', 0);
            }, 'department'])
            ->whereHas('user', function($query) {
                $query->where('is_deleted', 0);
            })
            ->get();

        return view('landing.index', compact('data', 'departments', 'doctors'));
    }

    public function manage()
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('landing_page.manage')) {
            $sections = LandingSections::all();
            return view('landing.manage', compact('sections'));
        } else {
            return view('error.403');
        }
    }

    public function update(Request $request)
    {
        $user = Sentinel::getUser();
        if ($user->hasAccess('landing_page.manage')) {
            foreach ($request->sections as $id => $status) {
                $section = LandingSections::find($id);
                if ($section) {
                    $section->is_enable = $status ? 1 : 0;
                    $section->save();
                }
            }
            return redirect()->back()->with('success', 'Landing page sections updated successfully!');
        } else {
            return view('error.403');
        }
    }
}
