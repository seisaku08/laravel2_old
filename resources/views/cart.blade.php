@extends('layouts.standard')
@section('title', 'カート')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />

    <div class="container">
        @csrf

        <table id="kizai">
            <tr class="midashi">
                <th colspan="5">選択機材情報</th>
            </tr>
            <tr>
                <td></td>
                <td>機材番号</td>
                <td>機種</td>
                <td>削除</td>
            </tr>
        @foreach($CartData as $key => $data)
            <tr>
                <td>{{$key +=1}}</td>
                <td>{{$data->machine_id}}</td>
                <td>{{$data->machine_name}}</td>
                <td>
                    {{Form::open(['route'=>['delCart']])}}
                        {{Form::submit('削除', ['name' => 'delete_machine_id', 'class' => 'btn btn-danger'])}}
                        {{Form::hidden('machine_id', $data->machine_id)}}
                    {{Form::close()}}
                </td>
            </tr>
        @endforeach
        </table>

        {{Form::open(['route'=>'sendto'])}}
            <p>
                <button type="submit" name="back" value="back">戻る</button>
                <button type="submit" name="submit" value="submit">イベント情報登録へ</button>
            </p>
        {{Form::close()}}

        </form>
    </div>
@endsection