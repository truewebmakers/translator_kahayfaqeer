@extends('layouts.app')
@section('content')
    <div class="page-body">
        @include('breadcrumb')
        <!-- Container-fluid starts-->
        <div class="container-fluid default-dashboard">

            <div class="row">

                <div class="col-xl-8">


                    <div class="card">
                        <div class="card-header card-no-border pb-0">
                            <h2>{{ isset($role->id) ? 'Edit Role' : 'Create Role' }}</h2>

                            <p class="mt-1 mb-0"></p>
                        </div>
                        <div class="card-body custom-input">
                            @include('alerts')
                            <form
                                @if (isset($role->id)) method="POST"
                                        action="{{ route('roles.update', $role->id) }}"
                                    @else
                                        method="POST"
                                        action="{{ route('roles.store') }}" @endif>
                                @csrf
                                @if (isset($role->id))
                                    @method('PUT')
                                @endif
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="name">Name</label>
                                            <input class="form-control" id="name" type="text" name="name"
                                                placeholder="Manager" value="{{ isset($role->name) ? $role->name : '' }}">
                                        </div>
                                    </div>
                                </div>


                                @if(isset($rolePermissions))

                                <div class="col-xl-12 col-sm-6 mb-4">
                                    <div class="card-wrapper border rounded-3 h-100 checkbox-checked custom-checkbox">
                                        <h6 class="sub-title">Permissions</h6>
                                        @foreach ($permission as $k => $value)
                                            <div class="form-check checkbox checkbox-primary mb-0">
                                                <input class="form-check-input primary" name="permission[]"
                                                    value="{{ $value->id }}" id="checkbox-primary-{{ $k }}"
                                                    type="checkbox" {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="checkbox-primary-1">
                                                    {{ $value->name }}</label>
                                            </div>
                                        @endforeach


                                    </div>
                                </div>

                                @else

                                <div class="col-xl-12 col-sm-6 mb-4">
                                    <div class="card-wrapper border rounded-3 h-100 checkbox-checked custom-checkbox">
                                        <h6 class="sub-title">Permissions</h6>
                                        @foreach ($permission as $k => $value)
                                            <div class="form-check checkbox checkbox-primary mb-0">
                                                <input class="form-check-input primary" id="checkbox-primary-{{$k}}" name="permission[]"  value="{{ $value->id }}" type="checkbox" >
                                                <label class="form-check-label"  for="checkbox-primary-{{$k}}"> {{ $value->name }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>



                                @endif

                                <div class="row">
                                    <div class="col">
                                        <div class="text-end">
                                            <button type="submit"
                                                class="btn btn-primary  me-2">{{ isset($role->id) ? 'Update' : 'Create' }}</button>

                                            <input class="btn btn-danger" type="reset" value="Cancel">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page_script')
<script>
document.title = 'Role create';

</script>
@endsection
