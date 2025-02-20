<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use App\Http\Requests\PasswordChangeRequest;
use App\Http\Services\TeamMemberService;
use App\Http\Services\UserService;
use App\Models\Designation;
use App\Models\FileManager;
use App\Models\User;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\Hash;

class   ProfileController extends Controller
{
    use ResponseTrait;

    public function index()
    {
        $data['pageTitle'] = __('Profile');
        $data['activeSetting'] = 'active';
        $data['activeProfile'] = 'active';
        $data['user'] = User::all();
        $data['designations'] = Designation::all();
        return view('admin.profile.index', $data);
    }

    public function update(ProfileRequest $request)
    {
        try {
            $user = User::find(auth()->id());
            if ($request->image) {
                $existFile = FileManager::where('id', $user->image)->first();
                if ($existFile) {
                    $existFile->removeFile();
                    $uploadedFile = $existFile->upload('User', $request->image, '', $existFile->id);
                    $user->image = $uploadedFile->id;
                } else {
                    $newFile = new FileManager();
                    $uploadedFile = $newFile->upload('User', $request->image);
                    $user->image = $uploadedFile->id;
                }
            }
            $user->company_designation = $request->designation_id;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            return $this->success([], __(UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            return $this->error([], $e->getMessage());
        }
    }

    public function password()
    {
        $data['title'] = __('Profile');
        $data['pageTitle'] = __('Change Password');
        $data['activeProfile'] = 'active';
        $data['activeSetting'] = 'active';
        return view('admin.profile.password', $data);
    }

    public function passwordUpdate(PasswordChangeRequest $request)
    {
        try {
            $user = User::find(auth()->id());
            if (Hash::check($request->current_password, $user->password) == false) {
                throw new Exception(__('Current Password Not Match'));
            }
            $user->password = Hash::make($request->password);
            $user->save();
            return $this->success([], __(UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            return $this->error([], $e->getMessage());
        }
    }
}
