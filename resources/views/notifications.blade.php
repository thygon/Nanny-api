@extends('layouts.app')

@section('topnav')
 @parent
@endsection

@section('sidenav')
 @parent
@endsection

@section('content')
  <div class="panel">
		<div class="panel-heading">
		    <h3 class="panel-title">Notifications</h3>
			<div class="right">
			    <button type="button" class="btn-toggle-collapse"><i class="lnr lnr-chevron-up"></i></button>
				<button type="button" class="btn-remove"><i class="lnr lnr-cross"></i></button>
			</div>
		</div>
	    <div class="panel-body">
			<ul class="list-unstyled todo-list">
				@foreach($notifications as $n)
				<li><a href="{{route('notification',['id'=>$n->id])}}" style="{{($n->read_at != null)?'color:#000;':''}}">
					<p>
						<span class="title"><h3>{{($n->type == 'App\\Notifications\\DistressCall')?'Distress Call':''}}</h3></span>
						<span class="short-description">{{ $n->data['call']}}</span>
						<span>
							@php $firm = $n->data['firm']['name']; @endphp
							<h3>{{$firm}}</h3>
						</span>
						<span class="date">{{$n->created_at}}</span>
					</p>
					<div class="controls">
					    <a href="#"><i class="icon-software icon-software-pencil"></i></a> <a href="#"><i class="icon-arrows icon-arrows-circle-remove"></i></a>
					</div>
					</a>
				</li>
				@endforeach
			</ul>
		</div>
	</div>
@endsection