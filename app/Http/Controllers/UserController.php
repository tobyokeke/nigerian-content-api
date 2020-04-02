<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    private $quidpay;
    private $messaging;


    public function __construct() {

//        $this->quidpay = new Quidpay();

    }



    // auth routes

//    public function signUp(Request $request)
//    {
//
//
//        //inputs
//        $rules = [
//            'email' => 'bail|unique:users|required|email:rfc,dns|max:255',
//            'phone' => ['bail','unique:users','required',new NigerianNumber()],
//            'alt_phone' => ['sometimes','unique:users',new NigerianNumber()],
//            'address' => ['required'],
//            'state' => ['required'],
//            'city' => ['required'],
//            'landmark' => ['required'],
//            'marital_status' => ['required'],
//            'firstname' => ['required'],
//            'surname' => ['required'],
//            'dob' => ['required'],
//            'gender' => ['required'],
//            'education_level' => ['required'],
//            'work_status' => ['required'],
//            'industry' => ['required'],
//            'occupation' => ['required'],
//            'company_name' => ['required'],
//            'company_phone' => ['required'],
//            'company_address' => ['required'],
//            'payday' => ['required'],
//            'monthly_income' => ['required'],
//            'guarantor_name' => ['required'],
//            'guarantor_phone' => ['required'],
//            'guarantor_email' => ['sometimes','email:rfc,dns'],
//            'guarantor_relationship' => ['required'],
//            'password' => ['required'],
//            "image" => ["required","image"],
//
//        ];
//
//
//        $validator = Validator::make($request->all(), $rules,$this->validationMessages());
//
//        if ($validator->fails()) {
//
//            return  response()->json([
//                "message" => $validator->errors()->first()
//            ],400);
//        }
//
//
//        $email = $request->input('email');
//        $phone = $request->input('phone');
//        $alt_phone = $request->input('alt_phone');
//        $address = $request->input('address');
//        $state = $request->input('state');
//        $city = $request->input('city');
//        $landmark = $request->input('landmark');
//        $marital_status = $request->input('marital_status');
//        $firstname = $request->input('firstname');
//        $surname = $request->input('surname');
//        $dob = $request->input('dob');
//        $gender = $request->input('gender');
//        $education_level = $request->input('education_level');
//        $work_status = $request->input('work_status');
//        $industry = $request->input('industry');
//        $occupation = $request->input('occupation');
//        $company_name = $request->input('company_name');
//        $company_phone = $request->input('company_phone');
//        $company_address = $request->input('company_address');
//        $payday = $request->input('payday');
//        $monthly_income = $request->input('monthly_income');
//        $guarantor_name = $request->input('guarantor_name');
//        $guarantor_phone = $request->input('guarantor_phone');
//        $guarantor_email = $request->input('guarantor_email');
//        $guarantor_relationship = $request->input('guarantor_relationship');
//        $image = $request->file('image');
//        $password = $request->input('password');
//
//        $ref_code = strtoupper("BM". Str::random(6));
//
//        while(User::where('ref_code',$ref_code)->count() > 0 )
//            $ref_code = strtoupper("BM". Str::random(6));
//
//
//
//        $user = new User();
//        $user->email = $email;
//        $user->phone = $phone;
//        $user->alt_phone = $alt_phone;
//        $user->address = $address;
//        $user->state = $state;
//        $user->city = $city;
//        $user->landmark = $landmark;
//        $user->marital_status = $marital_status;
//        $user->firstname = $firstname;
//        $user->surname = $surname;
//        $user->fullname = $firstname  . " ". $surname;
//        $user->dob = $dob;
//        $user->gender = $gender;
//        $user->education_level = $education_level;
//        $user->work_status = $work_status;
//        $user->industry = $industry;
//        $user->occupation = $occupation;
//        $user->company_name = $company_name;
//        $user->company_phone = $company_phone;
//        $user->company_address = $company_address;
//        $user->payday = $payday;
//        $user->monthly_income = $monthly_income;
//        $user->guarantor_name = $guarantor_name;
//        $user->guarantor_phone = $guarantor_phone;
//        $user->guarantor_email = $guarantor_email;
//        $user->guarantor_relationship = $guarantor_relationship;
//        $user->password = bcrypt($password);
//        $user->ref_code = $ref_code;
//        $user->status = 'verified';
//
//        $user->save();
//
//        $rand = $user->uid;
//
//        $filepath = 'uploads/profile/' . $rand . ".png";
//
//        Storage::disk('s3')->put($filepath, file_get_contents($image));
//
//        $user->image = $filepath;
//        $user->save();
//
//
//        // image temporary link should be valid for a week
//        $user->image = Storage::disk('s3')->temporaryUrl($user->image, Carbon::now()->addMinutes(10080));
//
//
//        return response( array( "message" => "Account Created.", "data" =>[
//            "user" => $user,
//            "token" => $user->createToken('Personal Access Token',['user'])->accessToken
//
//        ]   ), 200 );
//
//
//
//    }
//
//    public function signIn(Request $request)
//    {
//        $phone = $request->input('phone');
//        $password = $request->input('password');
//
//        $rules = [
//            'phone' => ['bail','required',new NigerianNumber()],
//            'password' => ['required'],
//        ];
//
//        $validator = Validator::make($request->all(), $rules,$this->validationMessages());
//
//        if ($validator->fails()) {
//
//            return  response()->json([
//                "message" => $validator->errors()->first()
//            ],400);
//        }
//
//        if(User::where('phone',$phone)->count() <= 0 ) return response( array( "message" => "Phone number does not exist"  ), 400 );
//
//        $user = User::where('phone',$phone)->first();
//
//        if(password_verify($password,$user->password)){
//            $user->last_login = Carbon::now();
//            $user->save();
//            return response( array( "message" => "Sign In Successful", "data" => [
//                "user" => $user,
//                "token" => $user->createToken('Personal Access Token',['user'])->accessToken
//            ]  ), 200 );
//        } else {
//            return response( array( "message" => "Wrong Credentials." ), 400 );
//        }
//
//    }
//
//    public function startForgotPassword(Request $request) {
//        $phone = $request->input('phone');
//        $rules = [
//            'phone' => ['exists:users','required',new NigerianNumber()],
//        ];
//        $validator = Validator::make($request->all(), $rules,$this->validationMessages());
//        if ($validator->fails()) {return  response()->json(["message" => $validator->errors()->first()],400);}
//
//        $user = User::where('phone',$phone)->first();
//
//        $phone_verification_code = Guruhelpers::random_number(6);
//        while(code::where('code',$phone_verification_code)->count() > 0 )
//            $phone_verification_code = Guruhelpers::random_number(6);
//
//
//
//        $code = new code();
//        $code->uid = $user->uid;
//        $code->code = $phone_verification_code;
//        $code->type = "phone";
//        $code->save();
//
//
//        try{
//            $message = "Your Borome phone verification code is $phone_verification_code";
//            Guruhelpers::sendSms($user->phone,$message);
//            Mail::to($user->email)->send(new backupSms($user,$code,$message));
//
//        }catch (\Exception $exception){}
//
//        return response( array( "message" => "Code sent. Please check your sms."  ), 200 );
//
//    }
//
//    public function confirmPhoneCode(Request $request) {
//        $code = $request->input('code');
//        $phone = $request->input('phone');
//
//        $rules = [
//            "code" => ["required"],
//            'phone' => ['exists:users','required',new NigerianNumber()],
//
//        ];
//
//        $validator = Validator::make($request->all(), $rules,$this->validationMessages());
//        if ($validator->fails()) {return  response()->json(["message" => $validator->errors()->first()],400);}
//
//        $user = User::where("phone",$phone)->first();
//        if( code::where('code',$code)->where('uid',$user->uid)->where('is_staff',0)->count() <= 0 ) return response( array( "message" => "Invalid Code"  ), 400 );
//        else
//            return response( array( "message" => "Valid",  ), 200 );
//
//
//    }
//
//    public function finishForgotPassword(Request $request) {
//        $code = $request->input('code');
//        $phone = $request->input('phone');
//        $new_password = $request->input('new_password');
//        $new_password_confirmation = $request->input('new_password_confirmation');
//
//        $rules = [
//            'code' => ['required'],
//            'phone' => ['exists:users','required',new NigerianNumber()],
//            'new_password' => ['required','confirmed']
//        ];
//
//
//        $validator = Validator::make($request->all(), $rules,$this->validationMessages());
//        if ($validator->fails()) {return  response()->json(["message" => $validator->errors()->first()],400);}
//
//        $user = User::where("phone",$phone)->first();
//
//        if( code::where('code',$code)->where('uid',$user->uid)->where('is_staff',0)->count() <= 0 ) return response( array( "message" => "Invalid Code"  ), 400 );
//
//
//        $code =  code::where('code',$code)->where('uid',$user->uid)->where('is_staff',0)->first();
//        $user = User::find($code->uid);
//
//        if($user->phone != $phone) return response( array( "message" => "Invalid Code"), 400 );
//        $user->password = bcrypt($new_password);
//        $user->save();
//        $code->delete();
//
//        return response( array( "message" => "Password Changed.",  ), 200 );
//
//    }

// end auth routes

}
