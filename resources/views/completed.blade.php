@extends('layout')

{{--メインコンテンツ--}}
@section('contents')
<h1>購入済み「買うもの」一覧</h1><br>
<a href="/shopping_list/list">「買うもの」一覧に戻る</a><br>
<table border="1">
    <tr>
        <th>購入日
        <th>買うもの名
@foreach ($list as $shopping)
    <tr>
        <td>{{ $shopping->created_at }}
        <td>{{ $shopping->name }}
@endforeach
</table>
現在{{ $list->currentPage() }} ページ目<br>
@if ($list->onFirstPage() === false)
<a href="/completed_shopping_list/list">最初のページ</a>
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
<hr>
<a href="/logout">ログアウト</a>
@endsection