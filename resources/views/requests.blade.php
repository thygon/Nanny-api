@extends('layouts.app')

@section('topnav')
 @parent
@endsection

@section('sidenav')
 @parent
@endsection


@section('content')
   <h3 class="page-title">Requests</h3>
   <div class="row">
   	<div class="col-12">
   		<div class="panel">
			<div class="panel-body">
				<table class="table table-striped table-bordered table-hover dataTables-premium" >
					<thead>
						<tr>
							<th>#</th>
							<th>Mama</th>
							<th>Nanny</th>
						</tr>
					</thead>
					<tbody>
						@php $i = 1;  @endphp
						@foreach( $requests as $req)
						<tr>
							<td>{{$i}}</td>
							<td>{{$req->user->name}}</td>
							<td>{{$req->nani->name}}</td>
						</tr>
						@php $i++; @endphp
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
							
   	</div>
   </div>
@endsection

@section('scripting')
  <script>
	
	 $(document).ready(function(){
            $('.dataTables-premium').DataTable({
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    { extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Nanny'},
                    {extend: 'pdf', title: 'Nanny'},

                    {extend: 'print',
                     customize: function (win){
                            $(win.document.body).addClass('white-bg');
                            $(win.document.body).css('font-size', '10px');

                            $(win.document.body).find('table')
                                    .addClass('compact')
                                    .css('font-size', 'inherit');
                    }
                    }
                ]

            });


        });

        function fnClickAddRow() {
            $('#editable').dataTable().fnAddData( [
                "Custom row",
                "New row",
                "New row",
                "New row",
                "New row" ] );

        }
  </script>
@endsection