<?php

declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShoppingRegisterPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Shopping as ShoppingModel;
use Illuminate\Support\Facades\DB;

class ShoppingListController extends Controller
{
    //
    public function list()
    {
        $per_page = 2;
        
        $list = ShoppingModel::where('user_id', Auth::id())
                        ->orderBy('created_at')
                        ->paginate($per_page);
                        // ->get();
    //$sql = ShoppingModel::where('user_id', Auth::id())->toSql();
    //echo "<pre>\n"; var_dump($sql, $list); exit;
        return view('shopping.list', ['list' => $list]);
    }
    
    public function register(ShoppingRegisterPostRequest $request)
    {
        //validate済みのデータ取得
        $datum = $request->validated();
        //
        //$id = Auth::id();
        //var_dump($datum); exit;
        
        //user_id追加
        $datum['user_id'] = Auth::id();
        //INSERT
        try {
            $r = ShoppingModel::create($datum);
        } catch(\Throwable $e) {
           // echo $e->getMessage();
            //exit;
            $request->session()->flash('front.shopping_register_failed', true);
            return redirect('/shoping/list');
        }
        $request->session()->flash('front.shopping_register_success', true);
        return redirect('/shopping/list');
    }
    
    public function delete(Request $request,$shopping_id)
    {
        //shopping IDレコードを取得
        $shopping = $this->getShoppingModel($shopping_id);
        //タスクを削除する
        if ($shopping !== null) {
            $shopping->delete();
            $request->session()->flash('front.shopping_delete_success', true);
        }
        //一覧に遷移する
        return redirect('/shopping/list');
    }
    
    public function complete($shopping_id)
    {
        try {
            //トランザクション開始
            DB::beginTransaction();
            
            //shopping_idのレコードを取得する
            $shopping = $this->getShoppingModel($shopping_id);
            if ($shopping === null) {
                throw new \Exception('');
            }
            var_dump($shopping->toArray()); exit;
            //shopping側を削除
            //completed_shopping側にinsertする
            
            //トランザクション終了
            DB::commit();
        } catch(\Throwable $e) {
            //トランザクション異常終了
            DB::rollback();
        }
        // 一覧に遷移する
    }
}
