<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('panel.plan.index', compact('plans'));
    }
    public function create()
    {
        return view('panel.plan.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'price' => ['required','numeric'],
            'status' => ['required'],
            'declaration_expire_days' => ['required','numeric'],
        ]);


        Plan::create([
            'title' => $request->title,
            'status'  => $request->status == "true" ? true : false,
            'price'  => $request->price,
            'declaration_expire_days' => $request->declaration_expire_days,
            'recruitment_declaration_quantity' => $request->recruitment_declaration_quantity,
            'outstanding_job_quantity' => $request->outstanding_job_quantity,
            'outstanding_job_expire_time' => $request->outstanding_job_expire_time,
            'urgent_lable_expire_time' => $request->urgent_lable_expire_time,
            'telegram_declaration' => $request->telegram_declaration == "true" ? true : false,
            'email_declaration' => $request->email_declaration == "true" ? true : false,
            'sms_declaration' => $request->sms_declaration == "true" ? true : false,
            'suggested_resume_quantity' => $request->suggested_resume_quantity,
            'is_full_time_support' => $request->is_full_time_support == "true" ? true : false,
            'is_suggested_resume' => $request->is_suggested_resume == "true" ? true : false,
            'is_one_and_half_possibility_in_search_results' => $request->possibility_in_search_results == "1/5" ? true : false,
            'is_two_possibility_in_search_results' => $request->possibility_in_search_results == "2" ? true : false,
            'is_one_and_half_possibility_to_visit_by_job_seekers' => $request->possibility_to_visit_by_job_seekers  == "1/5" ? true : false,
            'is_two_possibility_to_visit_by_job_seekers' => $request->possibility_to_visit_by_job_seekers == "2" ? true : false,
            'show_declaration_analytics' => $request->show_declaration_analytics == "true" ? true : false,
            'access_to_best_teachers_list' => $request->access_to_best_teachers_list == "true" ? true : false,
            'design_specific_plan' => $request->design_specific_plan == "true" ? true : false,
            'specialized_advice' => $request->specialized_advice == "true" ? true : false,
            'adding_specific_features' => $request->adding_specific_features == "true" ? true : false,
            'recruitment_declaration_advice' => $request->recruitment_declaration_advice == "true" ? true : false,
            'recruitment_specific_support' => $request->recruitment_specific_support == "true" ? true : false,
            'screening_resume_support' => $request->screening_resume_support == "true" ? true : false,
            'is_suggested' => $request->is_suggested == "true" ? true : false,
        ]);

        return redirect()->route('panel.plan.index')->with([
            'success' => 'با موفقیت ساخته شد'
        ]);
    }
    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        return view('panel.plan.edit',compact('plan'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required'],
            'price' => ['required','numeric'],
            'status' => ['required'],
            'declaration_expire_days' => ['required','numeric'],
        ]);

        Plan::findOrFail($id)->update([
            'title' => $request->title,
            'status'  => $request->status == "true" ? true : false,
            'price'  => $request->price,
            'declaration_expire_days' => $request->declaration_expire_days,
            'recruitment_declaration_quantity' => $request->recruitment_declaration_quantity,
            'outstanding_job_quantity' => $request->outstanding_job_quantity,
            'outstanding_job_expire_time' => $request->outstanding_job_expire_time,
            'urgent_lable_expire_time' => $request->urgent_lable_expire_time,
            'telegram_declaration' => $request->telegram_declaration == "true" ? true : false,
            'email_declaration' => $request->email_declaration == "true" ? true : false,
            'sms_declaration' => $request->sms_declaration == "true" ? true : false,
            'suggested_resume_quantity' => $request->suggested_resume_quantity,
            'is_full_time_support' => $request->is_full_time_support == "true" ? true : false,
            'is_suggested_resume' => $request->is_suggested_resume == "true" ? true : false,
            'is_one_and_half_possibility_in_search_results' => $request->possibility_in_search_results == "1/5" ? true : false,
            'is_two_possibility_in_search_results' => $request->possibility_in_search_results == "2" ? true : false,
            'is_one_and_half_possibility_to_visit_by_job_seekers' => $request->possibility_to_visit_by_job_seekers  == "1/5" ? true : false,
            'is_two_possibility_to_visit_by_job_seekers' => $request->possibility_to_visit_by_job_seekers == "2" ? true : false,
            'show_declaration_analytics' => $request->show_declaration_analytics == "true" ? true : false,
            'access_to_best_teachers_list' => $request->access_to_best_teachers_list == "true" ? true : false,
            'design_specific_plan' => $request->design_specific_plan == "true" ? true : false,
            'specialized_advice' => $request->specialized_advice == "true" ? true : false,
            'adding_specific_features' => $request->adding_specific_features == "true" ? true : false,
            'recruitment_declaration_advice' => $request->recruitment_declaration_advice == "true" ? true : false,
            'recruitment_specific_support' => $request->recruitment_specific_support == "true" ? true : false,
            'screening_resume_support' => $request->screening_resume_support == "true" ? true : false,
            'is_suggested' => $request->is_suggested == "true" ? true : false,
        ]);

        return redirect()->route('panel.plan.index')->with([
            'success' => 'با موفقیت ویرایش شد'
        ]);
    }
    public function delete(Request $request)
    {
        Plan::findOrFail($request->id)->delete();

        return redirect()->route('panel.plan.index')->with([
            'success' => 'با موفقیت حذف شد'
        ]);
    }
}
