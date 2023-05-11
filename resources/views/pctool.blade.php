<!doctype html>
<html>
<head>
  <title>機材発送依頼フォーム</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
</head>
<body> 

<h1 class="center">機材発送依頼フォーム</h1>
<h2>user:{{$user->name}}</h2>

<div class="container">
  <form method="post" action="">
    @csrf
    <input type="date" name="from" value="{{$input->from}}">～<input type="date" name="to" value="{{$input->to}}"><br>
    <input type="submit" value="検索">
  </form>

  @if(!empty($inUse))
    {{implode(',', $inUse)}}
  @endif

  {{ Form::open(['route' => 'addCart']) }}
    {{ Form::hidden('user_id', $user->id) }}
    {{ Form::hidden('from', $input->from)}}
    {{ Form::hidden('to', $input->to)}}
    <table class="table">
      <tr class="midashi">
        <th>　</th>
        <th>ID</th>
        <th>機材番号</th>
        <th>状態</th>
        <th>規格</th>
        <!-- <th>OS/PW</th>
        <th>導入年月</th>
        <th>備考</th> -->
      </tr>
      {{old('id')}}
      @foreach($records as $record)
        <tr>
          <td><input type="checkbox" name="id[]" value="{{$record->machine_id}}"{{ $record->machine_id == $input->id? ' checked' : '' }}></td>
          <td>{{$record->machine_id}}</td>
          <td><a href="pctool/detail?id={{$record->machine_id}}" target="_blank">{{$record->machine_name}}</a></td>
          <td>{{$record->machine_status}}</td>
          <td>{{$record->machine_spec}}</td>
          <!-- <td>{{$record->machine_os}}</td>
          <td>{{$record->machine_since}}</td>
          <td>{{$record->machine_memo}}</td> -->
        </tr>
      @endforeach
    </table>
    <input type="submit">
  {{ Form::Close() }}
</div>
</body>