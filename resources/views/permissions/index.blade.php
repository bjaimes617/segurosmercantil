@extends('layouts.main')
@section('title', 'Permisos del Sistema')
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
                        <li class="breadcrumb-item active">Permisos</li>
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
                            <h3 class="card-title">Listado de permisos del sistema</h3><a href="{{route('permissions.create')}}" class="btn btn-primary float-right" id="add" data-toggle="tooltip" data-placement="top" title="Añadir"><i class="fa fa-plus-circle"></i></a>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <small>Estos datos so nextraidos de forma integra desde la base de datos.</small>
                            <table id="permisos_table" class="table table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Slug</th>
                                        <th>Descripcion</th>
                                        <th>Creado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($permission as $permissions)
                                    <tr>
                                        <td>{{$permissions->name}}</td>
                                         <td>{{$permissions->slug}}</td>
                                         <td>{{$permissions->description}}</td>
                                         <td>{{date('d/m/Y h:i:s',strtotime($permissions->created_at))}}</td>
                                         
                                         <td>     
                                        {!!Form::open (['route' => ['permissions.destroy',$permissions->id], 'method' => 'DELETE', 'id' => 'delete_permiso'.$permissions->id]) !!} 
                                        @permission('permissions.edit')
                                            <a href="{{route('permissions.edit',$permissions->id)}}" data-toggle="tooltip" data-placement="top" title="Editar"><i class="fas fa-edit"></i></a>
                                        @endpermission
                                        @permission('permissions.delete')
                                            <a href="#" onclick="if(!confirm('¿Usted esta seguro que desea eliminar este permiso?, Esto puede ocacionar fallos en algunas funciones del sistema'))
                                        { return false; } else {$('#delete_permiso'+'{!!$permissions->id!!}').submit(); }" data-toggle="tooltip" data-placement="top" title="Eliminar"><i class="fas fa-trash"></i></a>                                        
                                        @endpermission
                                        {!!Form::close() !!}
                                        
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
{!!Html::script('js/permissions/permisos.js')!!}
@endpush
