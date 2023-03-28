<?php

declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShoppingRegisterPostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Shopping as ShoppingModel;
use Illuminate\Support\Facades\DB;
use App\Models\CompletedShopping as CompletedShoppingModel;

class ShoppingListController extends Controller
{
    //
    public function list()
    {
        $per_page = 3;
        
        $list = ShoppingModel::where('user_id', Auth::id())
                        //->orderBy('created_at')
                        ->orderBy('name')
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
            $request->session()->flash('front.shopping_list_register_failed', true);
            return redirect('/shoping_list/list');
        }
        $request->session()->flash('front.shopping_list_register_success', true);
        return redirect('/shopping_list/list');
    }
    
    protected function getShoppingModel($shopping_list_id)
    {
        $shopping_list = ShoppingModel::find($shopping_list_id);
        if ($shopping_list === null) {
            return null;
        }
        if ($shopping_list->user_id !== Auth::id()) {
            return null;
        }
        return $shopping_list;
    }
    
    public function delete(Request $request, $shopping_list_id)
    {
        //task_idのレコードを取得する
        $shopping_list = $this->getShoppingModel($shopping_list_id);
        
        //タスクを削除する
        if ($shopping_list !== null) {
            $shopping_list->delete();
            $request->session()->flash('front.shopping_list_delete_succes', true);
        }
        
        //一覧に遷移する
        return redirect('/shopping_list/list');
    }
    
    public function complete(Request $request, $shopping_list_id)
    {
        try {
            //トランザクション開始
            DB::beginTransaction();
            
            //shopping_idのレコードを取得する
            $shopping_list = $this->getShoppingModel($shopping_list_id);
            if ($shopping_list === null) {
                throw new \Exception('');
            }
           // var_dump($shopping->toArray()); exit;
            //shopping側を削除
            $shopping_list->delete();
            //completed_shopping側にinsertする
            $dask_datum = $shopping_list->toArray();
            unset($dask_datum['created_at']);
            unset($dask_datum['updated_at']);
            $r = CompletedShoppingModel::create($dask_datum);
            if ($r === null) {
                // insertで失敗したのでトランザクション終了
                throw new \Exception('');
            }
            //echo '処理成功'; exit;
            
            //トランザクション終了
            DB::commit();
            
            $request->session()->flash('front.shopping_list_completed_success', true);
        } catch(\Throwable $e) {
        //var_dump($e->getMessage()); exit;
            //トランザクション異常終了
            DB::rollBack();
            
            $request->session()->flash('front.shopping_list_completed_failed', true);
        }
        // 一覧に遷移する
        return redirect('/shopping_list/list');
    }
    
}
