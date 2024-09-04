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
                            <h2>{{ isset($permission->id) ? 'Edit Permission' : 'Create Permission' }}</h2>

                            <p class="mt-1 mb-0"></p>
                        </div>
                        <div class="card-body custom-input">
                            <form class="form theme-form edges-form"   @if(isset($permission->id))
                               method="PUT"
                               @else
                               method="post"
                            @endif
                     action="{{ isset($permission->id) ? route('permissions.update', $permission->id) : route('permissions.store') }}">
                                @csrf
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <label class="form-label" for="name">Permission</label>
                                            <input class="form-control" id="name" type="text"
                                             name="name" placeholder="read" value="{{ old('name', $permission->name ?? '') }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary  me-2">{{ isset($permission->id) ? 'Update' : 'Create' }}</button>

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
