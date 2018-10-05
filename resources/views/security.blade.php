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
		    <h3 class="panel-title">Security firms</h3>
			<div class="right">
				<a href="{{route('security.create')}}" class="btn btn-primary">Add New </a>
			</div>
		</div>
	    <div class="panel-body">
			<ul class="list-unstyled todo-list">
				<table class="table table-striped table-bordered table-hover dataTables-premium" >
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Location</th>
							<th>Description</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@php $i = 1;  @endphp
						@foreach( $securities as $s)
						<tr>
							<td>{{$i}}</td>
							<td>{{$s->name}}</td>
							<td>{{$s->location}}</td>
							<td>{{$s->description}}</td>
							<td> <a href="{{route('security.edit',['id'=>$s->id])}}" class="btn btn-primary">Edit</a>
								<a href="{{route('security.destroy',['id'=>$s->id])}}" class="btn btn-warning" 
									onclick="event.preventDefault();
									document.getElementById('deleteFirm').submit()">Delete</a>
								<form style="display: none;" id="deleteFirm" action="{{route('security.destroy',['id'=>$s->id])}}" method="post">
									<input type="hidden" name="_method" value="DELETEs">
										{{csrf_field()}}
									</form>
							</td>
						</tr>
						@php $i++; @endphp
						@endforeach
					</tbody>
				</table>
			</ul>
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