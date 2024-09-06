@extends('layouts.app')
@section('content')
    <div class="page-body">
        @include('breadcrumb')
        <!-- Container-fluid starts-->
        <div class="container-fluid default-dashboard">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header pb-0 card-no-border">

                            <div class="card-body">
                                <div class="table-responsive">
                                    <div id="basic-9_wrapper" class="dataTables_wrapper">


                                        <table class="display" id="basic-9">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($permissions as $permission)
                                                <tr>
                                                    <td>{{ ($permission) ? $permission->name :''}}</td>
                                                    <td>
                                                        <ul class="action">
                                                            <li class="edit">
                                                                <a href="{{ route('permissions.edit', $permission->id) }}">
                                                                    <i class="icon-pencil-alt"></i>
                                                                </a>
                                                            </li>
                                                            <li class="delete">
                                                                <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST" style="display:inline;">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" style="border: none; background: none; cursor: pointer;">
                                                                        <i class="icon-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>
                                                @endforeach

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Name</th>
                                                    <td>Action </td>
                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection
