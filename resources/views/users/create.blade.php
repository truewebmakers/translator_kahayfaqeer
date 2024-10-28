

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
                                        <label class="form-label" for="name">User Number</label>

                                        <select  name="user_level" class="form-select mt-2" id="proof-update">
                                            @foreach (['admin','1','2','3','4','5'] as $val => $reader)
                                                <option
                                                     @if (isset($user) && $reader == $user->user_level)
                                                        selected
                                                     @endif
                                                     value="{{ $reader }}">{{ $reader }}</option>
                                            @endforeach

                                        </select>
                                   </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-select">
                                        <label class="form-label" for="name">Department</label>

                                        <select  name="department" class="form-select mt-2" id="department-update">
                                            @foreach ([''=>'Choose Department','seed' => 'Seed' , 'tranlation' => 'Translation'] as $val => $seed)
                                                <option
                                                     @if (isset($user) && $val == $user->department)
                                                        selected
                                                     @endif
                                                     value="{{ $val }}" >{{ $seed }}</option>
                                            @endforeach

                                        </select>
                                   </div>
                                </div>
                                @php
                                        $languageArr = [
                                             '' => 'Choose Language',
                                             'urdu' => 'Urdu',
                                             'english' => 'English',
                                             'arabic' => 'Arabic',
                                             'hindi' => 'Hindi',
                                             'indonesian' => 'Indonesian',
                                             'bengali' => 'Bengali',
                                             'persian' =>   'Persian',
                                             'turkish' =>  'Turkish',
                                        ];

                                    @endphp

                                <div class="col-md-6">
                                    <div class="input-select"  style="display: {{ (isset($user) &&  $user->department ==  'seed' ) ? 'none' : 'disply' }}" >
                                        <label class="form-label" for="name">Language</label>

                                        <select  name="language" class="form-select mt-2" id="lang-update">
                                            @foreach ($languageArr as $val => $lang)
                                                <option
                                                     @if (isset($user) && $val == $user->language)
                                                        selected
                                                     @endif
                                                     value="{{ $val }}" class="{{$val}}-ln" >{{ $lang }}</option>
                                            @endforeach

                                        </select>
                                   </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-select" style="display: {{ (isset($user) &&  $user->department ==  'seed' ) ? 'none' : 'disply' }}" >
                                        <label class="form-label" for="name">Second Language</label>

                                        <select  name="second_language" class="form-select mt-2" id="lang-update2">
                                            @foreach ($languageArr as $val => $lang)
                                                <option
                                                     @if (isset($user) && $val == $user->second_language)
                                                        selected
                                                     @endif
                                                     value="{{ $val }}" class="{{$val}}">{{ $lang }}</option>
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

@section('page_script')
<script>

    $("#department-update").change(function(){
        var department = $(this).val();
        if(department == 'seed'){
            $("#lang-update").parents('.input-select').fadeOut();
            $("#lang-update2").parents('.input-select').fadeOut();
        }else{
            $("#lang-update").parents('.input-select').fadeIn();
            $("#lang-update2").parents('.input-select').fadeIn();
        }
    })



</script>
@endsection
