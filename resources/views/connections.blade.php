@extends('layouts.app')

@section('topnav')
 @parent
@endsection

@section('sidenav')
 @parent
@endsection


@section('content')
   <h3 class="page-title">Connections</h3>
   <div class="row">
   	<div class="col-12">
   		<div class="panel">
			<div class="panel-body">
				<table class="table table-striped table-bordered table-hover dataTables-premium" >
					<thead>
						<tr>
							<th>#</th>
							<th>Employer</th>
							<th>Employee</th>
							<th>status</th>
							<th>Start/End Date</th>
						</tr>
					</thead>
					<tbody>
						@php $i = 1;  @endphp
						@foreach( $connects as $conn)
						<tr>
							<td>{{$i}}</td>
							<td>{{$conn->mama->name}} | {{$conn->mama->email}}</td>
							<td>{{$conn->nani->name}} | {{$conn->nani->email}}</td>
							<td>
								@if($conn->status == 1)
								 {{'connected'}}
								@elseif($conn->status == 2)
								{{'rejected'}}
								@elseif($conn->status == 3)
								{{'Terminated'}}
								@elseif($conn->status == 0)
								{{'pending confirmation'}}
								@endif
							</td>
							<td>{{ $conn->created_at}} | {{ ($conn->status)?'__':$conn->updated_at}}</td>
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