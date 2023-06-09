<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User as UserModel;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
     public function list()
    {
        $group_by_column = ['users.id', 'users.name'];
        $list = UserModel::select($group_by_column)
                        ->selectRaw('count(completed_shopping_lists.id) AS completed_shopping_list_num')
                        ->leftJoin('completed_shopping_lists', 'users.id', '=', 'completed_shopping_lists.user_id')
                        ->groupBy($group_by_column)
                        ->orderBy('users.id')
                        ->get();
        //echo "<pre>\n";
        //var_dump($list->toArray()); exit;
        return view('admin.user.list', ['users' => $list]);
    }
}
