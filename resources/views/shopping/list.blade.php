@extends('layout')

{{-- メインコンテンツ --}}
@section('contents')
        <h1>「買うもの」の登録</h1>
        <br>
    <form action="/shopping/register" method="post">
        @csrf
        「買うもの」名:<input name="to buy"><br>
        <button>「買うもの」を登録する</button>
    </form>
        <br>
        <h1>「買うもの」一覧</h1>
        <br>
        <a href="/completed/list">購入済み「買うもの一覧」</a>
        <table border="1">
            <tr>
                <th>登録日
                <th>「買うもの」名
            <tr>
        </table>
        
@endsection