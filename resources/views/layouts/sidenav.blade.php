


@auth('admin')
		@php 
		  $notis = Auth::guard('admin')->user()->unreadNotifications;
		@endphp
<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						<li><a href="{{url('/')}}" class=""><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
						
						<li><a href="{{ route('users')}}" class=""><i class="lnr lnr-users"></i> <span>Users</span></a></li>
						<li><a href="{{ route('requests')}}" class=""><i class="lnr lnr-star"></i> <span>Requests</span></a></li>
						<li><a href="{{ route('connections')}}" class=""><i class="lnr lnr-users"></i> <span>Employments</span></a></li>
						<li><a href="{{ route('notifications')}}" class=""><i class="lnr lnr-alarm"></i> <span>Notifications</span>
							<span class="badge">{{$notis->count()}}</span>
						</a></li>
						<li><a href="{{ route('payments')}}" class=""><i class="lnr lnr-chart-bars"></i> <span>Payments</span></a></li>

						<li><a href="{{route('security.index')}}" class=""><i class="lnr lnr-text-format"></i> <span>Security</span></a></li>
						<li>
							<a href="#subPages" data-toggle="collapse" class="collapsed"><i class="lnr lnr-cog"></i> <span>Settings</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages" class="collapse ">
								<ul class="nav">
									<li><a href="#" class="">
										<i class="lnr lnr-user"></i> <span>Profile</span></a></li>
									<li><a href="{{route('admin.logout')}}" onclick="event.preventDefault();
                                 document.getElementById('formlogout2').submit();
								"><i class="lnr lnr-exit"></i> <span>Logout</span>
								   </a>
							         <form style="display: none;" id="formlogout2" action="{{route('admin.logout')}}" method="post">
										{{csrf_field()}}
									</form>
								</li>
								</ul>
							</div>
						</li>
					</ul>
				</nav>
			</div>
		</div>
@endauth