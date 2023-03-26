<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegisterPost;
use App\Models\User as UserModel;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //
    public function index()
    {
        return view('user.register');
    }
    
    public function register(UserRegisterPost $request)
    {
        $datum = $request->validated();
        $datum['password'] = Hash::make($datum['password']);
        // var_dump($datum); exit;
        
        //INSERT table
        
       try {
            $r = UserModel::create($datum);
        //var_dump($r); exit;
        } catch(\Throwable $e) {
           // echo $e->getMessage();
            //exit;
            $request->session()->flash('front.user_register_failed', true);
            return redirect('/');
        }
        $r = UserModel::create($datum);
        
        // 会員登録完了
        $request->session()->flash('front.user_register_success', true);
        
        //
        return redirect('/');
        
    }
}