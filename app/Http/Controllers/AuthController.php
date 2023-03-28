<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginPostRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //トップページ表示
    public function index()
    {
        return view('index');
    }
    //ログイン処理
    public function login(LoginPostRequest $request)
    {
         // validate済

        // データの取得
        $datum = $request->validated();
        // var_dump($datum); exit;
        
        // 認証
        If (Auth::attempt($datum) === false) {
            return back()
                ->withInput() // 入力値の保持
                ->withErrors(['auth' => 'emailかパスワードに誤りがあります',])
            ;
        }
        
       $request->session()->regenerate();
        return redirect()->intended('/shopping_list/list');
    }
    
   public function logout(Request $request) 
    {
        Auth::logout();
        $request->session()->regenerateToken();  // CSRFトークンの再生成
        $request->session()->regenerate();  // セッションIDの再生成
        return redirect('/');
    }
}
