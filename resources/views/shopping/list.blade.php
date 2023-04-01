@extends('layout')

{{-- メインコンテンツ --}}
@section('contents')
        <h1>「買うもの」の登録</h1>
        @if (session('front.shopping_list_register_success') == true)
        「買うもの」を登録しました！！<br>
        @endif
        @if (session('front.shopping_list_delete_succes') == true)
        「買うもの」を削除しました！！<br>
        @endif
        @if (session('front.shopping_list_completed_success') == true)
        「買うもの」を完了にしました！！<br>
        @endif
        @if (session('front.shopping_list_completed_failed') == true)
        失敗しました<br>
        @endif
        @if ($errors->any())
            <div>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            </div>
        @endif
    <form action="/shopping_list/register" method="post">
        @csrf
        「買うもの」名:<input name="name" value="{{ old('name') }}"><br>
        <button>「買うもの」を登録する</button>
    </form>
        <br>
        <h1>「買うもの」一覧</h1>
        <br>
        <a href="/completed_shopping_list/list">購入済み「買うもの」一覧</a>
        <table border="1">
            <tr>
                <th>登録日
                <th>「買うもの」名
        @foreach ($list as $shopping_list)
            <tr>
                <td>{{ $shopping_list->created_at->format('Y/m/d') }}
                <td>{{ $shopping_list->name }}
                <td><form action="{{ route('complete', ['shopping_list_id' => $shopping_list->id]) }}" method="post">
                    @csrf
                    <button onclick='return confirm("この「買うもの」を「完了」にします。よろしいですか？")'>完了</button></form>
                <td>　</td>
                <td><form action="{{ route('delete', ['shopping_list_id' => $shopping_list->id]) }}" method="post">
                    @csrf
                    @method("DELETE")
                    <button onclick='return confirm("この「買うもの」を「削除」します。よろしいですか？");'>削除</button>
                    </form>
        @endforeach
        </table>
        {{--{{ $list->links() }}--}}
        現在{{ $list->currentPage() }}ページ目<br>
        
        @if ($list->onFirstPage() === false)
        <a href="/shopping_list/list">最初のページ</a>
        @else
        最初のページ
        @endif
        /
        @if ($list->previousPageUrl() !== null)
        <a href="{{ $list->previousPageUrl() }}">前に戻る</a>
        @else
        前に戻る
        @endif
        /
        @if ($list->nextPageUrl() !== null)
        <a href="{{ $list->nextPageUrl() }}">次に進む</a>
        @else
        次に進む
        @endif
        /
        <hr>
        <a href="/logout">ログアウトする</a>
        
@endsection