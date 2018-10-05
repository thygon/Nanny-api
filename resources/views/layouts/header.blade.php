    @auth('admin')
		@php 
		  $notis = Auth::guard('admin')->user()->unreadNotifications;
		@endphp
<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href="{{url('/')}}"><img src="{{ asset('assets/img/logo-dark.png')}}" alt="Klorofil Logo" class="img-responsive logo"></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				<form class="navbar-form navbar-left">
					<div class="input-group">
						<input type="text" value="" class="form-control" placeholder="Search dashboard...">
						<span class="input-group-btn"><button type="button" class="btn btn-primary">Go</button></span>
					</div>
				</form>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown">
								<i class="lnr lnr-alarm"></i>
								<span class="badge bg-danger">{{$notis->count()}}</span>
							</a>
							<ul class="dropdown-menu notifications">
                                
								@foreach($notis as $noti)
								<li><a href="{{ route('notification',['id'=>$noti->id])}}" class="notification-item"><span class="dot {{($noti->type == 'App\\Notifications\\DistressCall')?'bg-danger':'bg-warning'}}">     </span>
                                    @if($noti->type == 'App\\Notifications\\DistressCall')
                                    {{'Distress call from '}}
                                    @endif
                                    {{$noti->data['user']['name']}}
                                    </a>
                                </li>
								@endforeach
							</ul>
						</li>
						
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{ asset('assets/img/user.png')}}" class="img-circle" alt="Avatar"> <span>{{ Auth::guard('admin')->user()->name}}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="#"><i class="lnr lnr-user"></i> <span>My Profile</span></a></li>
								<li><a href="#"><i class="lnr lnr-envelope"></i> <span>Message</span></a></li>
								<li><a href="#"><i class="lnr lnr-cog"></i> <span>Settings</span></a></li>
								<li><a href="{{route('admin.logout')}}" onclick="event.preventDefault();
                                 document.getElementById('formlogout').submit();
								"><i class="lnr lnr-exit"></i> <span>Logout</span>
								   </a>
							         <form style="display: none;" id="formlogout" action="{{route('admin.logout')}}" method="post">
										{{csrf_field()}}
									</form>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
	@endauth