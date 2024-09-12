@extends('layouts.app')
@section('content')
<style>
    div#comment-box p {
    padding: 12px;
}
button#btnPostReplay {
    float: right;
}
.card-header.card-no-border.pb-0.custom-head {
    display: flex;
    justify-content: space-between;
}

option.cl-approved_without_comment {
    color:#458e88
}
option.cl-approved_with_comment {
    color: lightgreen;
}
option.cl-reject_revise_and_resubmit {
    color: black;
}
option.cl-under_review {
    color: #e19924;
}
option.cl-in-process {
    color: orangered;
}
    </style>
    <div class="page-body">
        @include('breadcrumb')
        <!-- Container-fluid starts-->


        <div class="container-fluid" id="container" data-bookid="{{$book->id}}">
            <div class="row">
                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-header card-no-border pb-0 custom-head">
                            <h3 class="mb-0">Book Text</h3>
                            <a href="{{route('book.edit',$book->id)}}" class="btn btn-warning form-btn float-right mr-2">Edit</a>
                        </div>
                        <div class="card-body">
                            <p> {!!$book->text!!}</p>
                        </div>
                        <div class="p-3 bg-primary">
                            <button id="btnPostReplay" class="btn btn-outline-white rounded-0 fa-lg">
                                <i class="fas fa-comment-alt mr-2"></i>
                                Post Reply</button>
                        </div>
                        <div class="card-body ticket-add-replay m-0 px-3 pb-0 display-none" id="ticketAddReplay"
                            style="display: none;">
                            <textarea name="comment" id="div_editor1" cols="30" rows="10"></textarea>
                            <div class="text-left mt-3">
                                <button type="submit" class="btn btn-primary custom-ticket-btn" id="addTicketReply"
                                    data-loading-text="<span class='spinner-border spinner-border-sm'></span>Processing...">Post
                                    Reply</button>
                                {{-- <button type="button" id="attachmentButton" data-toggle="modal" data-target="#addAttachment" class="btn btn-info btn-icon custom-ticket-btn">
                                    <i class="fas fa-paperclip"></i>
                                    Add Attachments
                                </button> --}}
                                <button type="button" id="btnCancelReplay"
                                    class="btn btn-secondary mt-sm-0 text-dark custom-ticket-btn">
                                    Cancel
                                </button>

                            </div>

                        </div>
                        {{-- Coment Added  --}}
                        <div id="comment-box">
                            @foreach($book->comment as $comment)

                            <div class="card-body mt-3">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h5 class="f-w-600">{{ $comment->type }}</h5>
                                        {!!$comment->comment!!}
                                    </div>
                                    <p> {{ $comment->created_at->format('d M Y h:i A') }} </p>
                                </div>
                            </div>
                            <hr>
                            @endforeach

                        </div>



                    </div>
                </div>

                @php
                    $statusArr = [
                        'approved_without_comment' => 'Approved WithOut Comment',
                        'approved_with_comment' => 'Approved With Comment',
                        'reject_revise_and_resubmit' => 'Reject Revise and Resubmit',
                        'under_review' => 'Under Review',
                        'in-process' => 'In Progress',
                    ];
                @endphp

                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-header card-no-border pb-0">
                            <h3 class="mb-0">Book Details</h3>
                            <select class="form-select mt-2" id="status-update">
                                @foreach ($statusArr as $val => $status)
                                    <option @if ($val == $book->text_status) class="{{'cl-'.$val}} selected" value="{{ $val }}" @else class="{{'cl-'.$val}}" value="{{ $val }}" @endif  @if ($val == $book->text_status) selected @endif>
                                        Status : {{ $status }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="card-body">
                            <p><strong>Book Number : </strong>{{ $book->book_number }}</p>
                            <p><strong>Book Chapter : </strong>{{ $book->chapter }}</p>
                            <p><strong>Book Sentence : </strong>{{ $book->sentence }}</p>
                            <p><strong>Page Number : </strong>{{ $book->page_number }}</p>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_script')
    <script>
        var editor1 = new RichTextEditor("#div_editor1");
        var bookId = $('#container').data('bookid');

        //editor1.setHTMLCode("Use inline HTML or setHTMLCode to init the default content.");
    </script>
    <script>
        $("#btnPostReplay").click(function() {
            $("#ticketAddReplay").toggle('slow')
        })
        $("#btnCancelReplay").click(function() {
            $("#ticketAddReplay").toggle('slow')
        })
        $("#addTicketReply").click(function() {

            var $button = $(this);


            $button.html("<span class='spinner-border spinner-border-sm'></span> Processing...");

            $button.prop('disabled', true);

            var getHtml = editor1.getHTMLCode();
            var getText = editor1.getPlainText();
            var url = "{{ route('book.comment.store', ':bookId') }}".replace(':bookId', bookId);

            $.ajax({
                url: url,
                type: 'POST',
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    book_translation_id: $("#container").attr('data-bookid'),
                    comment: getHtml,
                    type : 'comment',

                },
                success: function(response) {
                    // Handle success
                    console.log('Success:', response);
                    var commentHtml = `<div class="card-body mt-3">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h5 class="f-w-600">${response.data.type}</h5>
                                ${response.data.comment}
                                </div>
                            </div>
                        </div>`;
                    $("#comment-box").append(commentHtml)
                    $("#ticketAddReplay").toggle('slow')
                    $button.html("Post Reply");
                    $button.prop('disabled', false);
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.log('Error:', error);
                    $button.html("Post Reply");
                    $button.prop('disabled', false);
                }
            });



            // setTimeout(function() {
            // $button.html("Post Reply");
            // $button.prop('disabled', false);
            // }, 2000);
        })
        $("#status-update").change(function() {
            var urll = "{{ route('book.comment.status.update', ':bookId') }}".replace(':bookId', bookId);

            if (confirm("You want to change status")) {

                $.ajax({
                url: urll,
                type: 'POST',
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    text_status: $(this).val(),

                },
                success: function(response) {
                    alert("status update")
                    location.reload();
                },
                error: function(xhr, status, error) {

                }
            });

            }
            return false


        })
    </script>
@endsection
