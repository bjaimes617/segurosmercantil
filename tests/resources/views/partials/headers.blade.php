<button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse order-3" id="navbarCollapse">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item">
            <a href="{{route('home')}}" class="nav-link"><i class="fas fa-home"></i></a>
        </li> 
        @permission('seguridad.module')
        <li class="nav-item dropdown">
            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle"><i class="fas fa-shield-alt"></i></a>
            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                <li><a href="{{route('activity')}}" class="dropdown-item"><i class="far fa-eye"></i> Logs</a></li>
                <li class="dropdown-divider"></li>
                @permission('roles.show | roles.create | roles.remove')
                <li class="dropdown-submenu dropdown-hover">
                    <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle"><i class="fas fa-lock"></i> Roles</a>
                    <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                        @permission('roles.show')
                        <li><a href="{{route('roles.index')}}" class="dropdown-item"><i class="far fa-eye"></i> Listar</a></li>                    
                        @endpermission
                        @permission('roles.create')
                        <li><a href="{{route('roles.create')}}" class="dropdown-item"><i class="fas fa-plus-circle"></i> Añadir</a></li>
                        @endpermission
                        @permission('roles.remove')
                        <li><a href="{{route('roles.remove.index')}}" class="dropdown-item"><i class="fas fa-recycle"></i> Eliminados</a></li>
                        @endpermission
                    </ul>
                </li>  
                @endpermission      
                @permission('permissions.show | permissions.create')
                <li class="dropdown-submenu dropdown-hover">
                    <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle"><i class="fas fa-key"></i> Permisos</a>
                    <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                        @permission('permissions.show')
                        <li><a href="{{route('permissions.index')}}" class="dropdown-item"><i class="far fa-eye"></i> Listar</a></li>
                        @endpermission
                        @permission('permissions.create')
                        <li><a  href="{{route('permissions.create')}}" class="dropdown-item"><i class="fas fa-plus-circle"></i> Añadir</a></li>
                        @endpermission
                    </ul>
                </li> 
                @endpermission
                @permission('view.users | create.users | remove.users')
                <li class="dropdown-submenu dropdown-hover">
                    <a id="dropdownSubMenu4" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle"><i class="fas fa-users"></i> Usuarios</a>
                    <ul aria-labelledby="dropdownSubMenu4" class="dropdown-menu border-0 shadow">
                        @permission('view.users')
                        <li><a href="{{route('users.index')}}" class="dropdown-item"><i class="far fa-eye"></i> Listar</a></li>
                        @endpermission
                        @permission('create.users')
                        <li><a href="{{route('users.create')}}" class="dropdown-item"><i class="fas fa-plus-circle"></i> Añadir</a></li>
                        @endpermission
                        @permission('remove.users')
                        <li><a href="{{route('users.remove.index')}}" class="dropdown-item"><i class="fas fa-recycle"></i> Eliminados</a></li>
                        @endpermission
                    </ul>
                </li> 
                @endpermission
            </ul>
        </li>
        @endpermission
    </ul>  
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>  
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{asset('img/user.png')}}" class="user-image img-circle elevation-2" alt="User Image">
                <span class="d-none d-md-inline">{{Auth::User()->name}}</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-primary">
                    <img src="{{asset('img/user.png')}}" class="img-circle elevation-2" alt="User Image">
                    <p>

                        {{Auth::User()->name}}<br><small>{{Auth::User()->roles()->first()->name}}</small>
                        <small>Registrado El: {{date('d/m/Y',strtotime(Auth::User()->created_at))}}</small>                   
                    </p>
                </li>  
                <!-- Menu Footer-->
                <li class="text-center user-footer">
                    <div class="btn-group-lg btn-group">
                        <a href="#" class="btn btn-default btn-flat"><i class="fas fa-id-badge"></i></a>
                        <a href="{{asset('/source/storage/app/public/manual_usuario_infinity.pdf')}}" class="btn btn-default btn-flat"><i class="far fa-question-circle"></i> <span class="right badge badge-info">new</span></a>
                        <a href="{{route('logout')}}" class="btn btn-default btn-flat"><i class="fas fa-sign-out-alt"></i></a>
                    </div>
                </li>
            </ul>
        </li>
    </ul>
</div>