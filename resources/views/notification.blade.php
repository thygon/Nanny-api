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
				<li>
					<p>
						<span class="title">{{($notification->type == 'App\\Notifications\\DistressCall')?'Distress Call':''}}</span>
						<span class="short-description">{{ $notification->data['call']}}</span>
						<span class="date">{{$notification->created_at}}</span>
					</p>
					<div class="controls">
					    <a href="#"><i class="icon-software icon-software-pencil"></i></a> <a href="#"><i class="icon-arrows icon-arrows-circle-remove"></i></a>
					</div>
				</li>
			</ul>
		</div>
	</div>
@endsection