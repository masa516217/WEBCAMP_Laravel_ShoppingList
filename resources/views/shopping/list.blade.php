@extends('layout')

{{-- メインコンテンツ --}}
@section('contents')
        <h1>「買うもの」の登録</h1>
        @if (session('front.shopping_register_success') == true)
        登録しました<br>
        @elseif (session('front.shopping_register_failed') == true)
        失敗しました<br>
        @endif
        @if (session('front.shopping_delete_succes') == true)
        タスクを削除しました<br>
        @endif
        @if ($errors->any())
            <div>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            </div>
        @endif
    <form action="/shopping/register" method="post">
        @csrf
        「買うもの」名:<input name="name" value="{{ old('name') }}"><br>
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
        @foreach ($list as $shopping)
            <tr>
                <td>{{ $shopping->created_at }}
                <td>{{ $shopping->name }}
                <td><form action="{{ route('delete', ['shopping_id' => $shopping->id]) }}" method="post">
                    @csrf
                    @method("DELETE")
                    <button onclick='return confirm("削除しますか？(削除したら戻せません)");'>削除</button>
                    </form>
                <td><form action="{{ route('complete', ['shopping_id' => $shopping->id]) }}" method="post">
                    @csrf
                    <button onclick='return confirm("買うものを完了します。よろしいですか")'>完了</button></form>
        @endforeach
        </table>
        <a href="/logout">ログアウトする</a>
        
@endsection