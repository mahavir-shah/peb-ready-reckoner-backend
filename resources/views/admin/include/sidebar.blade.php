<div class="border-end" id="sidebar-wrapper">
   <div class="sidebar-heading border-bottom bg-light"><img src="{{ asset('images/Ready Reknor Logo-right.svg')}}"></div>
   <div class="list-group list-group-flush">
      <div class="main-nav">
         <a class="list-group-item list-group-item-action list-group-item-light p-3 {{ Request::segment(1) == 'dashboard' ? 'active' : '' }}" href="{{route('admin.Deshboard')}}"><i class="fa fa-hmd-dashboard"></i> Dashboard</a>
         <a class="list-group-item list-group-item-action list-group-item-light p-3 {{ Request::segment(1) == 'web-config' ? 'active' : '' }}" href="{{route('admin.webConfig')}}"><i class="fa fa-hmd-admin"></i> Web Config</a>
         <a class="list-group-item list-group-item-action list-group-item-light p-3 {{ Request::segment(1) == 'news' ? 'active' : '' }}" href="{{route('admin.news')}}"><i class="fa fa-hmd-pages"></i> News</a>
         <a class="list-group-item list-group-item-action list-group-item-light p-3 {{ Request::segment(1) == 'company' ? 'active' : '' }}" href="{{route('admin.Company')}}"><i class="fa fa-hmd-pages"></i> Company</a>
         <a class="list-group-item list-group-item-action list-group-item-light p-3 {{ Request::segment(1) == 'designation' ? 'active' : '' }}" href="{{route('admin.Designation')}}"><i class="fa fa-hmd-pages"></i> Designation</a>
      </div>
      <div>
         <a class="list-group-item list-group-item-action list-group-item-light p-3 logout" href="{{ route('logout') }}"><i class="fa fa-butterflysignout"></i> Logout</a>
      </div>
   </div>
</div>
