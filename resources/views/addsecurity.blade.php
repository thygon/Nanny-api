
@extends('layouts.app')

@section('topnav')
 @parent
@endsection

@section('sidenav')
 @parent
@endsection


@section('content')

<div class="panel">
	<div class="panel-heading">New Security Firm</div>
	<div class="panel-body">
		<form action="{{route('security.store')}}" method="post" >
			{{csrf_field()}}
			<div class="form-group">
				<label>Name</label>
				<input class="form-control" type="text" name="name" value="{{old('name')}}" required>
			</div>
			<div class="form-group">
				<label>Location</label>
				<input class="form-control" type="text" name="location" value="{{old('location')}}" required>
			</div>
			<div class="form-group">
				<label>Description</label>
				<textarea class="form-control" name="description">{{old('description')}}</textarea>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary">Submit</button>
			</div>
		</form>
	</div>
</div>

@endsection