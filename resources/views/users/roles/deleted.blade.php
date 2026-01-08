@extends('layouts.main')
@section('title', 'Roles del Sistema|Eliminados')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Seguridad</li>
                        <li class="breadcrumb-item ">Roles</li>
                        <li class="breadcrumb-item active">Eliminados</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Listado de Roles de usuarios eliminados</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <small>Estos datos son extraidos de forma integra desde la base de datos.</small>                            
                            <table id="usuarios_table" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>slug</th>
                                        <th>Descripcion</th>                                       
                                        <th>Creado</th>                                      
                                        <th>Removido</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                    <tr>
                                        <td>{{$role->name}}</td>
                                        <td>{{$role->slug}}</td>
                                        <td>{{$role->description}}</td>                                       
                                        <td>{{date('d/m/Y h:i:s',strtotime($role->created_at))}}</td>      
                                        <td>{{date('d/m/Y h:i:s',strtotime($role->deleted_at))}}</td>          
                                        <td>     
                                        @permission('roles.restore | roles.delete')
                                        {!!Form::open (['route' => ['roles.destroy',$role->id], 'method' => 'post', 'id' => 'delete_roles'.$role->id]) !!}                                         
                                        @permission('roles.restore')
                                        <a href="{{route('roles.restore',$role->id)}}" data-toggle="tooltip" data-placement="top" title="Restaurar Rol"><i class="fas fa-recycle"></i></a>
                                        @endpermission
                                        @permission('roles.delete')
                                        <a href="#" onclick="if(!confirm('¿Desea eliminar el rol de usuario definitivamente?, al confirmar esta acción los usuarios bajo este rol quedaran sin asignación.'))
                                        { return false; } else {$('#delete_roles'+'{!!$role->id!!}').submit(); }" data-toggle="tooltip" data-placement="top" title="Eliminar Rol"><i class="fas fa-minus-circle"></i></a>
                                        {!!Form::close() !!} 
                                        @endpermission
                                        @endpermission
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</div>
@endsection
@push('styles')
{!!Html::style('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')!!}
{!!Html::style('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')!!}
{!!Html::style('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')!!}
@endpush

@push('scripts')
<!-- DataTables  & Plugins -->
{!!Html::script('plugins/datatables/jquery.dataTables.js')!!}
{!!Html::script('plugins/datatables-bs4/js/dataTables.bootstrap4.js')!!}
{!!Html::script('plugins/datatables-responsive/js/dataTables.responsive.js')!!}
{!!Html::script('plugins/datatables-responsive/js/responsive.bootstrap4.js')!!}
{!!Html::script('plugins/datatables-buttons/js/dataTables.buttons.min.js')!!}
{!!Html::script('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')!!}
{!!Html::script('plugins/jszip/jszip.min.js')!!}
{!!Html::script('plugins/pdfmake/pdfmake.min.js')!!}
{!!Html::script('plugins/pdfmake/vfs_fonts.js')!!}
{!!Html::script('plugins/datatables-buttons/js/buttons.html5.min.js')!!}
{!!Html::script('plugins/datatables-buttons/js/buttons.print.min.js')!!}
{!!Html::script('plugins/datatables-buttons/js/buttons.colVis.min.js')!!}
{!!Html::script('js/user/users.js')!!}
@endpush
