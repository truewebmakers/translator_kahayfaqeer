@extends('layouts.app')


@section('content')
    <style>
        ul li {
            text-align: justify;
            text-transform: capitalize;
        }
    </style>
    <div class="row">
        <div class="col-lg-12 margin-tb">

            <div class="action-top float-end mb-3">
                <a class="btn btn-outline-primary" href="{{ route('roles.index') }}"> <i
                        class="bi bi-skip-backward-circle me-1"></i> Back</a>
            </div>

        </div>
    </div>



    <div class="col-lg-12">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Role</h5>

                <form method="POST" action="{{ route('roles.update', $role->id) }}" class="row g-3">
                    @method('PATCH')
                    @csrf

                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text" id="inputGroupPrepend2">Name</span>
                        <input type="text" name="name" placeholder="Name" class="form-control" value="{{ $role->name }}">

                    </div>

                </div>


                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text" id="inputGroupPrepend2">Permission</span>
                        <ul>
                            @foreach ($permission as $value)
                                <li><input type="checkbox" name="permission[]" value="{{ $value->name }}" class="name" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>

                                    {{ $value->name }} </li>
                            @endforeach
                        </ul>

                    </div>

                </div>

                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
                </form>
                <!-- End Browser Default Validation -->

            </div>
        </div>
    </div>


@endsection
