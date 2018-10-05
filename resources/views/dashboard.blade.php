
@extends('layouts.app')

@section('topnav')
 @parent
@endsection

@section('sidenav')
 @parent
@endsection

@section('content')

  <!-- OVERVIEW -->
	<div class="panel panel-headline">
		<div class="panel-heading">
			<h3 class="panel-title">Overview</h3>
			<p class="panel-subtitle">System reports</p>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-md-3">
					<div class="metric">
						<span class="icon"><i class="fa fa-exchange"></i></span>
						<p>
							<span class="number">{{$connects}}</span>
							<span class="title">Connections</span>
						</p>
					</div>
				</div>
				<div class="col-md-3">
					<div class="metric">
						<span class="icon"><i class="fa fa-users"></i></span>
						<p>
							<span class="number">{{ App\User::count()}}</span>
							<span class="title">Users</span>
						</p>
					</div>
				</div>
				<div class="col-md-3">
									<div class="metric">
										<span class="icon"><i class="fa fa-heart"></i></span>
										<p>
											<span class="number">{{App\Friend::count()}}</span>
											<span class="title">Requests</span>
										</p>
									</div>
				</div>
				<div class="col-md-3">
									<div class="metric">
										<span class="icon"><i class="fa fa-bar-chart"></i></span>
										<p>
											<span class="number">Ksh {{App\Payment::sum('amount')}}</span>
											<span class="title">Payments</span>
										</p>
									</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title">Line Graph</h3>
			</div>
			<div class="panel-body">
				<div id="demo-line-chart" class="ct-chart"></div>
			</div>
			</div>
		</div>

		<div class="col-md-6">
			<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title">Area Graph</h3>
			</div>
			<div class="panel-body">
				<div id="demo-area-chart" class="ct-chart"></div>
			</div>
		</div>
	</div>
</div>

	<div class="row">
	<div class="col-md-6">
		<div class="panel">
			<div class="panel-heading">
				<h3 class="panel-title">Best Nanny</h3>
			    <p class="panel-subtitle">best rated nanny</p>
			</div>
			<div class="panel-body">
				@if($bestnani != null)
					<h3>{{$bestnani->name}}</h3>
					@php $star = $bestnani->rate()->first()->stars @endphp
	                <p>Rated {{($star >= 5)?$star/2:$star}}/5</p>
	            @endif
			</div>
		</div>
	</div>

	<div class="col-md-6">
		<div class="panel">
			<div class="panel-heading"><h3 class="panel-title">Best Employer</h3>
			    <p class="panel-subtitle">best rated employer</p></div>
			<div class="panel-body">
				@if($bestmama != null)
					<h3>{{$bestmama->name}}</h3>
					@php $star = $bestmama->rate()->first()->stars @endphp
	                <p>Rated {{($star >= 5)?$star/2:$star}}/5</p>
                @endif
			</div>
		</div>
	</div>
</div>

@endsection