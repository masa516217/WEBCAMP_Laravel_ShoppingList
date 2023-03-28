@extends('layout')

{{--meinnkonntents--}}
@section('contents')
<h1>管理画面ログイン</h1>
<form action="/login" method="post">
ログインID:<input>
パスワード:<input>
</form>