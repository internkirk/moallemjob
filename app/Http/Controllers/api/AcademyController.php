<?php

namespace App\Http\Controllers\api;

use Exception;
use App\Models\User;
use App\Models\Academy;
use App\Models\AcademyLevel;
use Illuminate\Http\Request;
use App\Models\Advertisement;
use App\Http\Controllers\Controller;
use App\Http\Resources\AcademyResource;
use Illuminate\Support\Facades\Storage;
use App\Models\AcademyAdditionalInformation;
use App\Http\Resources\AdvertisementResource;

class AcademyController extends Controller
{
    public function index()
    {
        try {
            $academies = Academy::where('id','>',0)->get();
            

            return AcademyResource::collection($academies);

            // return response()->json([
            //     'data' => $academies
            // ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }
    }

    public function show($id)
    {
        try {
            $academy = Academy::where('id',$id)->get();
            
             return AcademyResource::collection($academy);

            // return response()->json([
            //     'data' => $academy
            // ]);

        } catch (\Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }
    }
    
    public function primeAcademyCheck()
    {
        try {
            $user = auth()->user();

            if ($user->academy->isPrime())
                return response()->json(['message' => true]);
                
                if ($user->academy->primeAcademyResponse != NULL)
                return response()->json(['message' => 'رد شده' , 'reason' => $user->academy->primeAcademyResponse->text]);
                
            if ($user->academy->primeAcademyRequest()->where('status', false)->first() != NULL)
                return response()->json(['message' => 'در انتظار بررسی']);

                return response()->json([
                    'message' => 'تاحالا در خواستی ارسال نکرده اید'
                ]);

            

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function academyStore(Request $request)
    {

        try {
            $request->validate([
                'name' => ['required', 'max:255'],
                'logo' => ['sometimes'],
                'description' => ['sometimes'],
                'short_description' => ['required'],
                'city' => ['required'],
                'province' => ['required'],
                'website' => ['sometimes'],
                'students_number' => ['required', 'numeric'],
                'phone' => ['required', 'numeric'],
                // 'academy_level_title' => ['required']
            ]);


            $academy = Academy::where('user_id', auth()->user()->id)->first();

            if ($academy === NULL) {
                $request->validate([
                    'phone' => ['unique:academies,phone'],
                ]);
            } else {
                $request->validate([
                    'phone' => ['unique:academies,phone,' . $academy->id],
                ]);
            }

            // User::findOrFail(auth()->user()->id)->update([
            //     'first_name' => $request->first_name,
            //     'last_name' => $request->last_name,
            //     'email' => $request->email,
            //     'phone' => $request->phone,
            // ]);

            $academy = Academy::where('user_id', auth()->user()->id)->first();

            if ($academy === NULL) {
                $academy = Academy::create([
                    'user_id' => auth()->user()->id,
                    'name' => $request->name,
                    'logo' => '/',
                    'description' => $request->description,
                    'short_description' => $request->short_description,
                    'city' => $request->city,
                    'province' => $request->province,
                    'website' => $request->website,
                    'students_number' => $request->students_number,
                    'phone' => $request->phone,
                    'email' => $request->email,
                ]);

                if ($request->file('logo')) {
                    $this->saveImages($request, $academy->id);
                }
            } else {
                Academy::where('user_id', auth()->user()->id)->update([
                    'user_id' => auth()->user()->id,
                    'name' => $request->name,
                    'description' => $request->description,
                    'short_description' => $request->short_description,
                    'city' => $request->city,
                    'province' => $request->province,
                    'website' => $request->website,
                    'students_number' => $request->students_number,
                    'phone' => $request->phone,
                    'email' => $request->email,
                ]);

                if ($request->file('logo')) {
                    $this->saveImages($request, $academy->id);
                }
            }

            if ($request->file('logo')) {
                $this->saveImages($request, $academy->id);
            }

            if ($request->academy_level_title) {

                foreach (explode(",", $request->academy_level_title) as $key => $title) {
                    AcademyLevel::create([
                        'title' => $title,
                        'academy_id' => $academy->id
                    ]);
                }

            }

            return response()->json([
                'message' => 'data saved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }


    }

    public function academyProfileImageStore(Request $request)
    {
        try {

            $information = AcademyAdditionalInformation::where('academy_id', auth()->user()->academy->id)->first();

            if ($information === NULL) {
                $information = AcademyAdditionalInformation::create([
                    'establishment_year' => ' '
                ]);
                if ($request->file('profile_image')) {
                    $this->saveImagesWithFolderName($request, 'profile_image', $information->id);
                }
            } else {
                if ($request->file('profile_image')) {
                    $this->saveImagesWithFolderName($request, 'profile_image', auth()->user()->academy->academyAdditionalInformation->id);
                }
            }


            return response()->json([
                'message' => 'success'
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }
    }
    public function academyProfileImageGet(Request $request)
    {
        try {

            if (auth()->user()->academy === NULL) {
                return response()->json([
                    'message' => 'لطفا ابتدا اطلاعات اولیه خود را وارد کنید'
                ]);
            }

            $information = AcademyAdditionalInformation::where('academy_id', auth()->user()->academy->id)->first();

            return [
                'تصویر نمایه' => $information->profile_image ? $information->profile_image : '#'
            ];

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);

        }
    }


    public function academyAdditionalInformationStore(Request $request)
    {
        // dd($request->school_image);
        // return response()->json($request->school_image);
        // return response()->json(explode(",",$request->school_image));
        
        //  foreach (explode(",",$request->school_image) as $key => $image) {
        //     return json_decode($image);
        // }

        try {
            $request->validate([
                'establishment_year' => ['required'],
                'establishment_license_image' => ['required', 'image', 'mimes:png,jpg,jpeg,webp'],
                'startup_license_image' => ['required', 'image', 'mimes:png,jpg,jpeg,webp'],
                'profile_image' => ['sometimes'],
                'benefits' => ['sometimes'],
                'school_image' => ['sometimes'],
            ]);

            if (auth()->user()->academy === NULL) {
                return response()->json([
                    'message' => 'لطفا ابتدا اطلاعات اولیه خود را وارد کنید'
                ]);
            }


            $information = AcademyAdditionalInformation::where('academy_id', auth()->user()->academy->id)->first();


            if ($information === NULL) {
                $information = AcademyAdditionalInformation::create([
                    'academy_id' => auth()->user()->academy->id,
                    'establishment_year' => $request->establishment_year,
                    'establishment_license_image' => '/',
                    'startup_license_image' => '/',
                    'profile_image' => '/',
                    'benefits' => $request->benefits,
                    'school_image' => '/',
                ]);

                if ($request->file('establishment_license_image')) {
                    $this->saveImagesWithFolderName($request, 'establishment_license_image', $information->id);
                }
                if ($request->file('startup_license_image')) {
                    $this->saveImagesWithFolderName($request, 'startup_license_image', $information->id);
                }
                if ($request->file('profile_image')) {
                    $this->saveImagesWithFolderName($request, 'profile_image', $information->id);
                }
                if ($request->school_image) {
                    $this->saveMultipleImages($request, 'school_image', $information->id);
                }
            } else {
                AcademyAdditionalInformation::where('academy_id', auth()->user()->academy->id)->update([
                    'academy_id' => auth()->user()->academy->id,
                    'establishment_year' => $request->establishment_year,
                    'benefits' => $request->benefits,
                ]);

                if ($request->file('establishment_license_image')) {
                    $this->saveImagesWithFolderName($request, 'establishment_license_image', $information->id);
                }
                if ($request->file('startup_license_image')) {
                    $this->saveImagesWithFolderName($request, 'startup_license_image', $information->id);
                }
                if ($request->file('profile_image')) {
                    $this->saveImagesWithFolderName($request, 'profile_image', $information->id);
                }
                if ($request->school_image) {
                    $this->saveMultipleImages($request, 'school_image', $information->id);
                }
            }





            // $information = AcademyAdditionalInformation::updateOrCreate(['academy_id' => auth()->user()->academy->id], [
            //     'academy_id' => auth()->user()->academy->id,
            //     'establishment_year' => $request->establishment_year,
            //     'establishment_license_image' => '/',
            //     'startup_license_image' => '/',
            //     'profile_image' => '/',
            //     'benefits' => $request->benefits,
            //     'school_image' => '/',
            // ]);

            // if ($request->file('establishment_license_image')) {
            //     $this->saveImagesWithFolderName($request, 'establishment_license_image', $information->id);
            // }
            // if ($request->file('startup_license_image')) {
            //     $this->saveImagesWithFolderName($request, 'startup_license_image', $information->id);
            // }
            // if ($request->file('profile_image')) {
            //     $this->saveImagesWithFolderName($request, 'profile_image', $information->id);
            // }
            // if ($request->file('school_image')) {
            //     $this->saveMultipleImages($request->file('school_image'), 'school_image', $information->id);
            // }

            return response()->json([
                'message' => 'data saved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }


    }


    public function academyGet()
    {
        try {


            if (auth()->user()->academy === NULL) {
                return response()->json([
                    'message' => 'لطفا ابتدا اطلاعات اولیه خود را وارد کنید'
                ]);
            }

            $academy = Academy::where('user_id', auth()->user()->id)->get();

            // return [
            //     'آیدی' => $academy->id,
            //     'نام' => $academy->name,
            //     'تلفن' => $academy->phone,
            //     'وب سایت' => $academy->website,
            //     'تعداد دانش آموزان' => $academy->students_number,
            //     'استان' => $academy->province,
            //     'شهر' => $academy->city,
            //     'توضیحات کوتاه' => $academy->short_description,
            //     'لوگو' => $academy->logo ? $academy->logo : '#',
            //     'توضیحات' => $academy->description,
            // ];

            return AcademyResource::collection($academy);


        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
    public function academyAdditionalInformationGet()
    {
        try {


            if (auth()->user()->academy === NULL) {
                return response()->json([
                    'message' => 'لطفا ابتدا اطلاعات اولیه خود را وارد کنید'
                ]);
            }

            $academy = AcademyAdditionalInformation::where('academy_id', auth()->user()->academy->id)->first();

            return [
                'آیدی' => $academy->id,
                'سال تاسیس' => $academy->establishment_year,
                'تصویر مجوز راه اندازس' => $academy->startup_license_image,
                'مجوز تاسیس' => $academy->establishment_license_image,
                'تصویر نمایه' => $academy->profile_image,
                'مزایا' => $academy->benefits,
                'تصاویر مدرسه' => $academy->school_image,
            ];

        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }


    public function academyAdvertisementsGet()
    {
        try {

            if (auth()->user()->academy === NULL) {
                return response()->json([
                    'message' => 'لطفا ابتدا اطلاعات اولیه خود را وارد کنید'
                ]);
            }

            $advertisements = Advertisement::where('user_id', auth()->user()->academy->user_id)->get();

            if ($advertisements->isEmpty()) {
                return response()->json([
                    'message' => 'شما تا به حال آگهی ثبت نکردید'
                ]);
            }


            return AdvertisementResource::collection($advertisements);


        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
    
    public function deleteAcademicLevel($id)
    {
        try {

            $user = auth()->user();

            $result = AcademyLevel::findOrFail($id);

            if ($user->academy->id != $result->academy_id)
                return response()->json(['message' => 'این مقطع تحصیلی متعلق به آموزشگاه شما نمیباشد']);

            AcademyLevel::where('id', $id)->delete();

            return response()->json([
                'message' => ' deleted successfully',
            ]);

        } catch (Exception $e) {

            return response()->json([
                'error' => $e->getMessage()
            ], 400);
        }
    }
 
    private function saveImagesWithFolderName(Request $request, $folder, $id)
    {
        $path = [];

        Storage::disk('public')->deleteDirectory("/academy/additional-informations/$folder/images/" . $id);

        Storage::disk('public')->makeDirectory("/academy/additional-informations/$folder/images/");

        $path[] = "/storage/" . Storage::disk('public')->put("/academy/additional-informations/$folder/images/" . $id, $request->$folder);

        AcademyAdditionalInformation::findOrFail($id)->update([
            $folder => json_encode($path)
        ]);
    }

    // private function saveMultipleImages($request, $folder, $id)
    // {
        // $path = [];

        // Storage::disk('public')->deleteDirectory("/academy/additional-informations/$folder/images/" . $id);

        // Storage::disk('public')->makeDirectory("/academy/additional-informations/$folder/images/");

        // foreach (explode(",",$request) as $key => $image) {
        //     $path[] = "/storage/" . Storage::disk('public')->put("/academy/additional-informations/$folder/images/" . $id, $image);
        // }

        // AcademyAdditionalInformation::findOrFail($id)->update([
        //     $folder => json_encode($path)
        // ]);
        
    // }
    
    
    private function saveMultipleImages($request, $folder, $id)
{
     $path = [];

    
    $directoryPath = "academy/additional-informations/$folder/images/$id";
    Storage::disk('public')->deleteDirectory($directoryPath);
    Storage::disk('public')->makeDirectory($directoryPath);

  
    // if ($request->hasFile('school_image')) {
    //     $files = $request->file('school_image');


    //     if (!is_array($files)) {
    //         $files = [$files];
    //     }
    
    
    
    //  dd($request);
    
    //  foreach (explode(",",$request->school_image[0]) as $key => $image) {
    //         return json_decode($image);
    //     }
    
   
        
        // $school_image = explode(",",$request->school_image[0]);
        
        

        foreach ($request->school_image as $image) {
            $path[] = "/storage/" . Storage::disk('public')->putFile($directoryPath, $image);
        }
    // } else {
    //     return response()->json(["message" => "No images uploaded."], 400);
    // }
    
    

    
    AcademyAdditionalInformation::findOrFail($id)->update([
        $folder => json_encode($path)
    ]);

    return response()->json(["message" => "Images uploaded successfully", "paths" => $path], 200);
}

    private function saveImages(Request $request, $id)
    {
        $path = [];

        Storage::disk('public')->deleteDirectory("/academy/images/" . $id);

        Storage::disk('public')->makeDirectory('/academy/images/');
        $path[] = "/storage/" . Storage::disk('public')->put("/academy/images/" . $id, $request->logo);


        Academy::findOrFail($id)->update([
            'logo' => json_encode($path)
        ]);
    }
}
