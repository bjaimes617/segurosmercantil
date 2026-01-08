@extends('layouts.main')
@section('title', 'Usuarios del Sistema')
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
                        <li class="breadcrumb-item active">Usuarios</li>
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
                            <h3 class="card-title">Listado de usuarios</h3><a href="{{route('users.create')}}" class="btn btn-primary float-right" id="add" data-toggle="tooltip" data-placement="top" title="Añadir"><i class="fa fa-plus-circle"></i></a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <small>Estos datos son extraidos de forma integra desde la base de datos.</small>                            
                            <table id="usuarios_table" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Nombre y Apellido</th>
                                        <th>Usuario</th>
                                        <th>Email</th>
                                        <th>Estatus</th>
                                        <th>Creado</th>                                        
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>{{$user->name}}</td>
                                         <td>{{$user->username}}</td>
                                         <td>{{$user->email}}</td>
                                         <td>{{$user->estatus_id}}</td>
                                         <td>{{date('d/m/Y h:i:s',strtotime($user->created_at))}}</td>                                      
                                         <td> 
                                        @permission('edit.users | remove.users')
                                        {!!Form::open (['route' => ['users.remove',$user->id], 'method' => 'DELETE', 'id' => 'delete_users'.$user->id]) !!} 
                                        @permission('edit.users')
                                        <a href="{{route('users.edit',$user->id)}}"><i class="fas fa-edit" data-toggle="tooltip" data-placement="top" title="Editar"></i></a>
                                        @endpermission
                                        @permission('remove.users')
                                        <a href="#" onclick="if(!confirm('¿Usted esta seguro que desea enviar este usuario a la papelera?, Esto ocacionara que el usuario no pueda iniciar sesión'))                                        
                                       { return false; } else {$('#delete_users'+'{!!$user->id!!}').submit(); }" data-toggle="tooltip" data-placement="top" title="Remover"><i class="fas fa-user-slash"></i></a>
                                        @endpermission
                                        {!!Form::close() !!} 
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
