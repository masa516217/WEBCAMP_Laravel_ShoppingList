<?php

declare(strict_types=1);
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShoppingRegisterPostRequest;

class ShoppingListController extends Controller
{
    //
    public function list()
    {
        return view('shopping.list');
    }
    
    public function register(ShoppingRegisterPostRequest $request)
    {
        //validate済みのデータ取得
        $datum = $request->validated();
        var_dump($datum); exit;
    }
}
