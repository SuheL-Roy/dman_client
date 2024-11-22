<?php

namespace App\Http\Controllers\API;

use App\Admin\Rider;
use App\Http\Controllers\Controller;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    //

    
public function rider_register(Request $request)
{
       
      
   $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
        ]);

    if ($validator->fails()) {
        return response()->json(['message' => 'email exists','status'=>'false'], 406);
    }
            
    try {
        $user = new User();
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->email = $request->email;
        $user->role = 11;
        $user->password = Hash::make($request->password);
        
        $profile_photo_file  = $request->file('profile_photo');
        $profile_photo_file_name = date('mdYHis') . uniqid().'.'.$profile_photo_file->extension(); 
        $profile_photo_file->move(public_path('photo'), $profile_photo_file_name);
        $user->photo= $profile_photo_file_name;
        
        $user->save();

        $rider = new Rider();
        $rider->user_id = $user->id;
        $rider->present_address = $request->present_address;
        $rider->permanent_address = $request->permanent_address;
        $rider->fathers_name = $request->fathers_name;
        $rider->fathers_phone_no = $request->fathers_phone_no;
        $rider->user_voter_id_no = $request->voter_id_no;
        $rider->fathers_voter_id_no = $request->fathers_voter_id_no;
        
        //voter id photo
        
        $user_voter_id_photo_file  = $request->file('user_voter_id_photo');
        $user_voter_id_photo_file_name = date('mdYHis') . uniqid().'.'.$user_voter_id_photo_file->extension(); 
        $user_voter_id_photo_file->move(public_path('VoterID/UservoterID'), $user_voter_id_photo_file_name);
        $rider->user_voter_id_photo= $user_voter_id_photo_file_name;
        
        
        //fathers voter id photo
        
        $fathers_voter_id_photo_file  = $request->file('fathers_voter_id_photo');
        $fathers_voter_id_photo_file_name = date('mdYHis') . uniqid().'.'.$fathers_voter_id_photo_file->extension(); 
        $fathers_voter_id_photo_file->move(public_path('VoterID/FathersvoterID'), $fathers_voter_id_photo_file_name);
        $rider->user_fathers_voter_id_photo = $fathers_voter_id_photo_file_name;
        
        
        
        $rider->district = $request->district;
        $rider->area = $request->area;
        $rider->zone_id = $request->zone_id;
        $rider->save(); // Should be $this->buildXMLHeader();
        return response()->json(['message' => 'registration success','status'=>true], 200);
      } catch (Exception $e) {
        return response()->json(['message' => $e,'status'=>true], 404);
      }
            
    }

}

