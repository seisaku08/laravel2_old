@extends('adminlte::page')
@section('title', 'OrderID:'.$orders->order_no.' | セミナー詳細')
@section('content')
<article id="list">

	<table id="kizai2">
		<tr class="midashi">
			<th colspan="5">{{ $orders->order_no }}</th>
		</tr>
		<tr>
			<td class="kizai-right">セミナー名</td>
			<td class="kizai-left">期日</td>
		</tr>
		<tr>
			<td class="kizai-right">{{$orders->seminar_name}}</td>
			<td class="kizai-left">{{$orders->seminar_day}}</td>
		</tr>

</table>
<table id="form">
	<tr>
		<td class="kizai-right">機材ID</td>
		<td class="kizai-left">機材名</td>
	</tr>
@foreach($machines as $machine)
		<tr>
			<td class="kizai-left">{{$machine->machine_id}}</td>
			<td class="kizai-right">{{$machine->machine_name}}</td>
		</tr>
	@endforeach
	</tr>

</table>

</article>
</form>

@endsection