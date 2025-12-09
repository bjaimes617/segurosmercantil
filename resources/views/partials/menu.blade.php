<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="{{asset('img/user.png')}}" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <a href="#" class="d-block">{{\Auth::user()->name}}</a>
    </div>
</div>
<nav class="mt-2">    
    <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">              
        @permission('gestion.module|consolidados.ventas')
        <li class="nav-item @yield('menu_gestion')">
            <a href="#" class="nav-link @yield('gestion')">
                <i class="nav-icon fas fa-folder-open"></i>
                <p>Gestión <i class="right fas fa-angle-left"></i></p>
            </a>
            @permission('gestion.asignarclientes|gestion.submodulos')
            <ul class="nav nav-treeview"> 
                 <li class="nav-item">
                    <a href="{{route('gestion.manual')}}" class="nav-link @yield('gestion.manual')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Manual</p>
                    </a>
                </li>
                @permission('gestion.asignarclientes')
                <li class="nav-item">
                    <a href="{{route('gestion.asignar')}}" class="nav-link @yield('gestion.asignar')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Asignar</p>
                    </a>
                </li>
                @endpermission
                @permission('gestion.submodulos')
                <li class="nav-item">
                    <a href="{{route('gestion.index')}}" class="nav-link @yield('gestion.index')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Asignados</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('gestion.agendados')}}" class="nav-link @yield('gestion.agendados')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Agendados</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('gestion.nocontactos')}}" class="nav-link @yield('gestion.nocontacto')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>No Contactado</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('gestion.ventas')}}" class="nav-link @yield('gestion.ventas')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Ventas</p>
                    </a>
                </li>
                @endpermission               
            </ul>
            <ul class="nav nav-treeview">
                @permission('consolidados.ventas')
                <li class="nav-item">
                    <a href="{{route('consolidado.index')}}" class="nav-link @yield('consolidado.index')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Consolidado Ventas</p>
                    </a>
                </li>
                 @endpermission
                 @permission('buscador')
                <li class="nav-item">
                    <a href="{{route('buscador.index')}}" class="nav-link @yield('buscador.index')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Buscador</p>
                    </a>
                </li>
                @endpermission
            </ul>
            @endpermission
        </li> 
        @endpermission
        @permission('reportes.module')
        <li class="nav-item @yield('menu_reportes')">
            <a href="#" class="nav-link @yield('reportes')">
                <i class="nav-icon fas fa-file"></i>
                <p>Reportes <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview"> 
                @permission('reporte.general')
                <li class="nav-item">
                    <a href="{{route('reportes.index')}}" class="nav-link @yield('reportes.index')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>General</p>
                    </a>
                </li>         
                @endpermission
                @permission('reporte.txt')
                <!---<li class="nav-item">
                    <a href="{{route('reportes.txt')}}" class="nav-link @yield('reportes.txt')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>TXT por Planes</p>
                    </a>
                </li>-->
                <li class="nav-item">
                    <a href="{{route('reportes.csv')}}" class="nav-link @yield('reportes.csv')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>CSV Ventas</p>
                    </a>
                </li>
                @endpermission
            </ul>
        </li> 
        @endpermission
        @permission('administrador.module')
        <li class="nav-item @yield('menu_administracion')">
            <a href="#" class="nav-link @yield('administracion')">
                <i class="nav-icon fas fa-cog"></i>
                <p>Administración <i class="right fas fa-angle-left"></i></p>
            </a>
            @permission('administrador.upload|administrador.deleted')
            <ul class="nav nav-treeview">   
                @permission('administrador.upload')
                <li class="nav-item">
                    <a href="{{route('administration.index')}}" class="nav-link @yield('administracion.index')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cargar</p>
                    </a>
                </li>
                 @endpermission
                @permission('administrador.deleted')
                <li class="nav-item">
                    <a href="{{route('administration.deleted')}}" class="nav-link @yield('administracion.deleted')">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Eliminar</p>
                    </a>
                </li>
                @endpermission
            </ul>
             @endpermission
        </li> 
        @endpermission
    </ul>  
</nav>