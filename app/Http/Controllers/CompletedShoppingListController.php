<?php
declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CompletedShopping as CompletedShoppingModel;
use Illuminate\Support\Facades\Auth;

class CompletedShoppingListController extends Controller
{
    //
    public function list()
    {
        $per_page = 3;
        
        $list = CompletedShoppingModel::where('user_id', Auth::id())
        ->orderBy('name')
        //->orderBy('')
        ->paginate($per_page);
    //$sql = CompletedShoppingModel::where('user_id', Auth::id())->toSql();
    //echo "<pre>\n"; var_dump($sql, $list); exit;
        return view('completed', ['list' => $list]);
    }
}
