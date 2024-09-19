

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

                            <h2>{{ isset($user) ? 'Edit User' : 'Create User' }}</h2>

                            <p class="mt-1 mb-0"></p>
                        </div>
                        <div class="card-body custom-input">
                            @include('alerts')
                            @if(isset($user))
                            <form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="row g-3">
                                @method('PATCH')
                            @else
                            <form action="{{ route('users.store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
                            @endif

                            @csrf
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="name">Name</label>
                                        <input type="text" name="name" placeholder="Name" class="form-control" value="{{(isset($user)) ? $user->name : '' }}">
                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="name">Email</label>
                                        <input type="text" name="email" placeholder="Email" class="form-control"  value="{{(isset($user)) ? $user->email : '' }}">                                    </div>

                                </div>

                                <div class="col-md-6">
                                    <div class="input-group">
                                        <label class="form-label" for="name">Password</label>
                                        <input type="password" name="password" placeholder="Password" class="form-control">
                                   </div>
                                </div>
                               <div class="col-md-6">
                                    <div class="input-group">
                                        <label class="form-label" for="name">confirm-password</label>

                                        <input type="password" name="confirm-password" placeholder="Confirm Password" class="form-control">
                                   </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-select">
                                        <label class="form-label" for="name">Roles</label>

                                        <select  name="roles[]" class="form-select mt-2" id="status-update">
                                            @foreach ($roles as $val => $role)
                                                <option @if (isset($userRole) && $userRole == $role) selected @endif value="{{ $role }}">{{ $role }}</option>
                                            @endforeach

                                        </select>
                                   </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-select">
                                        <label class="form-label" for="name">Proof Reader</label>

                                        <select  name="proof_read_user" class="form-select mt-2" id="proof-update">
                                            @foreach (['admin','1','2','3','4','5'] as $val => $reader)
                                                <option
                                                     @if (isset($user) && $reader == $user->proof_read_user)
                                                        selected
                                                     @endif
                                                     value="{{ $reader }}">{{ $reader }}</option>
                                            @endforeach

                                        </select>
                                   </div>
                                </div>





                                <div class="col-12">
                                  <button class="btn btn-primary float-end" type="submit">{{ isset($user) ? 'Update' : 'Create' }}</button>
                                </div>
                              </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
