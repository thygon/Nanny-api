@extends('layouts.app')

@section('topnav')
 @parent
@endsection

@section('sidenav')
 @parent
@endsection


@section('content')
   <h3 class="page-title">Payments</h3>
   <div class="row">
   	<div class="col-12">
   		<div class="panel">
			<div class="panel-body">
				<ul class="ul activity-list">

					@foreach($payments as $payment)
					<li> <p>Ksh {{$payment->amount}}</p>
						<p>{{$payment->created_at}}</p>
					</li>
					@endforeach
				</ul>
			<p>Total: Ksh {{$payments->sum('amount')}}</p>
			</div>
		</div>
							
   	</div>
   </div>
@endsection