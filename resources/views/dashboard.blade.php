@extends('adminlte::page')
@section('title', 'マイページ')
@section('content')
    <h1>@yield('title')</h1>
        <p>Under Constructiion!</p>
        <?php dump($message,$orders);?>
        <p>{{$message}}</p>
        <table id="kizai2">
            <tr class="midashi">
                <th colspan="5">登録済セミナー</th>
            </tr>
            <tr>
                <td class="kizai-left">期間</td>
                <td class="kizai-right">セミナーNo.</td>
                <td class="kizai-right">セミナー名</td>
            </tr>
        @foreach($orders as $order)
            <tr>
                <td class="kizai-left">{{$order->order_use_from}}～{{$order->order_use_to}}</td>
                <td class="kizai-right"><a href="order/detail/{{$order->order_id}}" target="_blank">{{$order->order_no}}</a></td>
                <td class="kizai-right">{{$order->seminar_name}}</td>
            </tr>
        @endforeach
    
    </table>
    
@endsection