<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Models\AdvertisementJobSalary;

class AdvertisementJobSalaryController extends Controller
{
    public function index()
    {
    }
    public function create($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        return view('panel.advertisement.job-salary.create', compact('advertisement'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'min_salary' => ['required'],
            'max_salary' => ['required'],
        ]);

        AdvertisementJobSalary::create([
            'advertisement_id' => $request->advertisement_id,
            'min_salary' => $request->min_salary,
            'max_salary' => $request->max_salary,
            'benefits' => $request->benefits,
        ]);


        return redirect()->route('panel.advertisement.job.salary.show', $request->advertisement_id)->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function edit($teacher_id, $id)
    {
        $advertisement = Advertisement::findOrFail($teacher_id);
        $jobSalary = AdvertisementJobSalary::where('id',$id)->first();
        return view('panel.advertisement.job-salary.edit',compact('jobSalary','advertisement'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'min_salary' => ['required'],
            'max_salary' => ['required'],
        ]);

        AdvertisementJobSalary::findOrFail($id)->update([
            'advertisement_id' => $request->advertisement_id,
            'min_salary' => $request->min_salary,
            'max_salary' => $request->max_salary,
            'benefits' => $request->benefits,
        ]);

        return redirect()->route('panel.advertisement.job.salary.show',$request->advertisement_id)->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function show($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        $jobSalaries = AdvertisementJobSalary::where('advertisement_id', $id)->get();
        return view('panel.advertisement.job-salary.show', compact('jobSalaries', 'advertisement'));
    }
    public function delete(Request $request)
    {
        AdvertisementJobSalary::findOrFail($request->id)->delete();

        return redirect()->route('panel.advertisement.job.salary.show',$request->advertisement_id)->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
