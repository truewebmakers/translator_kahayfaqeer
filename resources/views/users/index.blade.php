@extends('layouts.app')
@section('content')
    <div class="page-body">
        @include('breadcrumb')

        <!-- Container-fluid starts-->
        <div class="container-fluid default-dashboard">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        @include('alerts')
                        <div class="card-header pb-0 card-no-border">

                            <div class="card-body">

                                <div class="table-responsive">
                                    <div id="basic-9_wrapper" class="dataTables_wrapper">

                                        <table class="table table-responsive" id="basic-9">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Roles</th>
                                                    <th width="280px">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data as $key => $user)
                                                    <tr>
                                                        <td>{{ ++$i }}</td>

                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>
                                                            @if (!empty($user->getRoleNames()))
                                                                @foreach ($user->getRoleNames() as $v)
                                                                    <span
                                                                        class="badge bg-success">{{ $v }}</span>
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a class="btn btn-info"
                                                                href="{{ route('users.show', $user->id) }}">Show</a>
                                                            <a class="btn btn-primary"
                                                                href="{{ route('users.edit', $user->id) }}">Edit</a>
                                                            <form method="POST"
                                                                action="{{ route('users.destroy', $user->id) }}"
                                                                style="display:inline">
                                                                @method('DELETE')
                                                                @csrf
                                                                <button type="submit"
                                                                    class="btn btn-danger">Delete</button>
                                                            </form>
                                                            {{-- {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style' => 'display:inline']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                            {!! Form::close() !!} --}}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endsection



        @section('page-script')
            <script>
                document.title = 'User List';
            </script>
        @endsection
