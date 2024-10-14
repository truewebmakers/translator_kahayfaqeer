@extends('layouts.app')
@section('content')
    <div class="page-body">
        @include('breadcrumb')
        <!-- Container-fluid starts-->
        <div class="container-fluid default-dashboard">
            @include('alerts')
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form theme-form basic-form">
                                @if(isset($book))
                                <form action="{{route('book.update',$book->id)}}" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="text_status" id="text_status" value="{{$book->text_status}}">
                                @else
                                <form action="{{route('book.store')}}" method="post" enctype="multipart/form-data">

                                @endif

                                    @csrf

                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <h5 class="f-w-600 mb-2">Book Number</h5>
                                            <input class="form-control" type="text" placeholder="Book Number" name="book_number" value="{{ isset($book) ? $book->book_number : ''}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <h5 class="f-w-600 mb-2">Chapter Number</h5>
                                            <input class="form-control" type="text"   placeholder="Chapter Number" name="chapter" value="{{ isset($book) ? $book->chapter : ''}}" >
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <h5 class="f-w-600 mb-2">Page Number</h5>
                                            <input class="form-control" type="text" placeholder="Enter Page Number" name="page_number" value="{{ isset($book) ? $book->page_number : ''}}">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="mb-3">
                                            <h5 class="f-w-600 mb-2">Sentence</h5>
                                            <input class="form-control" type="text" placeholder="Enter Sentence" name="sentence" value="{{ isset($book) ? $book->sentence : ''}}">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <h5 class="f-w-600 mb-2">Book Line </h5>
                                            <textarea class="form-control" id="bookLine" name="text" rows="3">

                                                {{ isset($book) ? $book->text : ''}}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <h5 class="f-w-600 mb-2">Supporting Language  </h5>
                                            <textarea class="form-control" id="bookLine2" name="supporting_language" rows="3">

                                                {{ isset($book) ? $book->supporting_language : ''}}
                                            </textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="mb-3">
                                            <h5 class="f-w-600 mb-2">Upload Audio file</h5>

                                            <div class="col-12">
                                                <input class="form-control" id="formFile" type="file" value="{{ isset($book) ? $book->urdu_audio : ''}}" name="urdu_audio">
                                              </div>
                                              @if($book)
                                                <audio controls>
                                                    <source src="https://{{ $book->urdu_audio }}" type="audio/mp3">
                                                </audio>
                                              @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="text-end">
                                            <button class="btn btn-success me-3 ">{{ isset($book) ? 'Update' : 'Create'}}</button>
                                            <a class="btn btn-danger" href="#">Cancel </a></div>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('page_script')
    <script>
        var editor1 = new RichTextEditor("#bookLine");
        var editor2 = new RichTextEditor("#bookLine2");

        //editor1.setHTMLCode("Use inline HTML or setHTMLCode to init the default content.");
    </script>
@endsection
