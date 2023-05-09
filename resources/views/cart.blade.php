<!doctype html>
<html>

<head>
    <title>カート</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
</head>

<body>
    <h1 class="center">カート</h1>

    <div class="container">
        @csrf

        <table id="kizai">
            <tr class="midashi">
                <th colspan="5">選択機材情報</th>
            </tr>
            <tr>
                <td>ID</td>
                <td>機材番号</td>
                <td>機種</td>
                <td>削除</td>
            </tr>
        @foreach($CartData as $key => $data)
            <tr>
                <td>{{$key +=1}}</td>
                <td>{{$data}}</td>
                <td>{{$data}}</td>
                <td>
                    {{Form::open(['route'=>['cart', 'method'=>'post', $data]])}}
                    {{Form::submit('削除', ['name' => 'delete_machine_id', 'class' => 'btn btn-danger'])}}
                    {{form::hidden('machine_id', $data)}}
                    {{Form::close()}}
                </td>
            </tr>
        @endforeach
        </table>

        {{Form::open(['route'=>['sendto', 'method'=>'post', $data]])}}
            <p>
                <button type="button" onclick="history.back();">戻る</button>
                <input type="submit" value="イベント情報登録へ">
            </p>
        {{Form::close()}}

        </form>
    </div>
</body>