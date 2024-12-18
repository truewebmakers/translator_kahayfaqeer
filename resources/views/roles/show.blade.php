@extends('layouts.app')


@section('content')
    

    <div class="col-lg-12">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Show Role</h5>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Name:</strong>
                            {{ $role->name }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <strong>Permissions:</strong>
                            @if (!empty($rolePermissions))
                                @foreach ($rolePermissions as $v)
                                    <label class="label label-success">{{ $v->name }},</label>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 margin-tb text-end">
    
                <div class="pull-right">
                    <a class="btn btn-outline-primary" href="{{ route('roles.index') }}"> Back</a>
                </div>
            </div>
        </div>
    </div>
@endsection
