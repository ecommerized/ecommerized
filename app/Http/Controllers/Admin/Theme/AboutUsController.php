<?php

namespace App\Http\Controllers\Admin\Theme;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\theme\AboutUsRequest;
use App\Models\AboutUs;
use App\Models\FileManager;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AboutUsController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        $data['pageTitle'] = __('About Us');
        $data['activeAboutUs'] = 'active';
        $data['aboutUsData'] = AboutUs::first();
        return view('admin.themes.about-us', $data);
    }

    public function store(AboutUsRequest $request)
    {
        DB::beginTransaction();
        try {

            $id = $request->id;
            $aboutUs = $id ? AboutUs::findOrFail($id) : new AboutUs();

            $aboutUs->title = $request->title;
            $aboutUs->details = $request->details;
            $aboutUs->our_mission = $request->our_mission;
            $aboutUs->our_vision = $request->our_vision;
            $aboutUs->our_goal = $request->our_goal;

            if ($request->hasFile('banner_image')) {
                $fileManager = new FileManager();
                $uploadedIcon = $fileManager->upload('about-us', $request->banner_image);
                if (!is_null($uploadedIcon)) {
                    $aboutUs->banner_image = $uploadedIcon->id;
                } else {
                    DB::rollBack();
                    return $this->error([], __('Something went wrong while uploading the banner image.'));
                }
            }
            if ($request->hasFile('image')) {
                $fileManager = new FileManager();
                $uploadedIcon = $fileManager->upload('about-us', $request->image);
                if (!is_null($uploadedIcon)) {
                    $aboutUs->image = $uploadedIcon->id;
                } else {
                    DB::rollBack();
                    return $this->error([], __('Something went wrong while uploading the image.'));
                }
            }

            $teamMember = [];
            if ($request->has('team_member_name')) {
                foreach ($request->input('team_member_name') as $key => $title) {
                    $teamMemberData = [
                        'title' => $title,
                        'designation' => $request->input("team_member_designation.$key"),
                        'facebook' => $request->input("team_member_facebook_link.$key"),
                        'linkedin' => $request->input("team_member_linkedin_link.$key"),
                        'twitter' => $request->input("team_member_twitter_link.$key"),
                    ];

                    $oldPhoto = $request->input("old_team_member_image.$key");

                    if ($request->hasFile("team_member_image.$key")) {
                        $fileManager = new FileManager();
                        $uploadedImage = $fileManager->upload('about-us-team-member', $request->file("team_member_image.$key"));
                        if (!is_null($uploadedImage)) {
                            $teamMemberData['image'] = $uploadedImage->id;
                        } else {
                            DB::rollBack();
                            return $this->error([], __('Something went wrong while uploading the our touch point icon.'));
                        }
                    } elseif ($oldPhoto) {
                        $teamMemberData['image'] = $oldPhoto;
                    } else {
                        $teamMemberData['image'] = null;
                    }

                    $teamMember[] = $teamMemberData;
                }
            }

            $aboutUs->team_member = $teamMember;

            $aboutUs->save();

            DB::commit();

            $message = $id ? __('Updated Successfully') : __('Created Successfully');
            return $this->success([], getMessage($message));

        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], __('Something went wrong! Please try again.'));
        }
    }

}






