<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;
// use App\Http\Controllers\Auth\PostRequest; FormRequestは諦め

use App\Models\Users\Subjects;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function registerView()
    {
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }

    // public function registerPost(PostRequest $request) FormRequestは諦め
    public function registerPost(Request $request)
    {
        $validate = [
            'over_name' => 'required|max:10',
            'under_name' => 'required|max:10',
            'over_name_kana' => 'required|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u|max:30',
            'under_name_kana' => 'required|regex:/^[ア-ン゛゜ァ-ォャ-ョー]+$/u|max:30',
            'mail_address' => 'required|max:100|unique:users,mail_address|email',
            'sex' => 'required',
            'old_year' => 'required_with:old_month,old_day',
            'old_month' => 'required_with:old_year,old_day',
            'old_day' => 'required_with:old_month,old_year',
            'role' => 'required',
            'password' => 'required|alpha_num|min:8|max:30|confirmed',
            'password_confirmation' => 'required|alpha_num|min:8|max:30',
        ];
        $massage = [
            'over_name.max' => '※性は10文字以内で入力して下さい',
            'under_name.max' => '※名は10文字以内で入力して下さい',
            'over_name_kana.regex' => '※セイはカタカナで入力して下さい',
            'over_name_kana.max' => '※セイは30文字以内で入力して下さい',
            'under_name_kana.regex' => '※メイはカタカナで入力して下さい',
            'under_name_kana.max' => '※メイは30文字以内で入力して下さい',
            'mail_address.email' => '※メール形式で入力して下さい',
            'mail_address.unique' => '※このメールアドレスは既に使用されています',
            'old_year.required_with' => '※生年月日が未入力です',
            'old_month.required_with' => '※生年月日が未入力です',
            'old_day.required_with' => '※生年月日が未入力です',
            'password.required' => '※パスワードを入力して下さい',
            'password.alpha_num' => '※パスワードは英数字のみで入力して下さい',
            'password.min' => '※パスワードは8文字以上、30文字以内で入力して下さい',
            'password.max' => '※パスワードは8文字以上、30文字以内で入力して下さい',
            'password_confirmation.required' => '※確認パスワードを入力して下さい',
            'password.confirmed' => '※パスワードが一致していません',
            'password_confirmation.alpha_num' => '※パスワードは英数字のみで入力して下さい',
            'password_confirmation.min' => '※パスワードは8文字以上、30文字以内で入力して下さい',
            'password_confirmation.max' => '※パスワードは8文字以上、30文字以内で入力して下さい',
        ];
        $validator = Validator::make($request->all(), $validate, $massage);
        if($validator->fails()){
            return redirect('register')
            ->withErrors($validator)
            ->withInput();
        }

        DB::beginTransaction();
        try{
            $old_year = $request->old_year;
            $old_month = $request->old_month;
            $old_day = $request->old_day;
            $data = $old_year . '-' . $old_month . '-' . $old_day;
            $birth_day = date('Y-m-d', strtotime($data));
            $subjects = $request->subject;

            $user_get = User::create([
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                'birth_day' => $birth_day,
                'role' => $request->role,
                'password' => bcrypt($request->password)
            ]);
            $user = User::findOrFail($user_get->id);
            $user->subjects()->attach($subjects);
            DB::commit();
            return view('auth.login.login');
        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('loginView');
        }
    }
}
