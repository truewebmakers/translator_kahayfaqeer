@extends('layouts.app')
@section('content')
    <style>
        .default-dashboard .transaction-history table tbody tr td {
            /* color: var(--dark); */
            font-weight: 100;
        }
        div#audio-data {
            margin-top: 20px;
        }

        .badge-area span {
            width: 100%;
        }

        .badge-area {
            width: 100%;
            text-align: center;
            padding: 10px;
        }

        td.text-custom {
            width: 20%;
        }

        i.fa-solid.fa-magnifying-glass {
            background: #55b963;
            padding: 10px;
            border-radius: 50%;
        }

        .text {
            display: inline;
        }

        .text-container {
            position: relative;
            display: inline-block;
            /* Allow overlay positioning */
        }

        .text {
            display: inline;
            /* Text is visible */
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Semi-transparent overlay */
            display: none;
            /* Hide overlay by default */
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .icon {
            color: white;
            /* Icon color */
            font-size: 20px;
            /* Adjust size as needed */
            display: inline;
            /* Show icon */
        }

        .text-container:hover .overlay {
            display: flex;
            /* Show overlay on hover */
        }

        #annotations {
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .annotation {
            background: yellow;
            display: inline;
            cursor: pointer;
        }

        td.audio-container {
            text-align: center;
        }

        td.audio-container audio {
            width: 100%;
        }

        .status-update {
            width: 110px;
        }

        .modal-content {
            align-items: center;
            display: flex;
            font-size: 16px;
            font-weight: 100 !important;
        }

        /* .modal-footer form {
            width: 100%;
        } */

        /* button.badge.badge-success.mt-1.submit-this {
    font-size: 14px;
} */
    </style>
    @php
        use App\Helpers\UserHelper;
        $role = UserHelper::userRole();
        $user = Auth::user();

    @endphp
    <div class="page-body">

        @include('breadcrumb')
        <!-- Container-fluid starts-->
        <div class="container-fluid default-dashboard">
            @include('alerts')
            <div class="row">
                <div class="col-xxl-12 col-xl-8 proorder-xxl-8 col-lg-12 col-md-6 box-col-7">
                    <div class="card">
                        <div class="card-header card-no-border pb-0">


                            <h3>Books
                                @if( UserHelper::userCan(['create_book_sentence', 'delete_book_sentence','read_book_sentence','update_book_sentence']))
                                <button class="btn btn-outline-success btn-sm add-book"
                                    data-action="{{ route('book.store') }}" type="button" data-bs-toggle="modal"
                                    data-bs-target="#add-book-form-md">Add Book</button>
                                @endif
                            </h3>

                        </div>
                        <div class="card-body transaction-history pt-0">
                            <div class="table-responsive theme-scrollbar">
                                <table class="table display table-bordernone" id="transaction" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Created By</th>
                                            <th>Bookno</th>
                                            <th>Chapter</th>
                                            <th>Pageno</th>
                                            <th>Sentence</th>
                                            <th>Paragraph</th>
                                            <th>Second Supporting</th>
                                            <th>Comment</th>
                                            <th class="text-center">Book Status</th>
                                            <th class="text-center">Audio</th>
                                            <th class="text-center">Audio Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($booklistings as $listing)
                                            <tr>
                                                <td> {{ $listing->user->name }} </td>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        {{-- <div class="flex-shrink-0"><img src="../assets/images/dashboard-1/icon/1.png" alt=""/></div> --}}
                                                        <div class="flex-grow-1">

                                                                <h6>{{ $listing->book_number }}</h6>

                                                            {{-- <p>Item Sold</p> --}}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $listing->chapter }}</td>
                                                <td>{{ $listing->page_number }}</td>
                                                <td>{{ $listing->sentence }}</td>

                                                <td class="text-custom">
                                                    <div class="text-container" data-text="{{ UserHelper::getListingContent($listing, Auth::user()->language) }}">
                                                        {!! substr_replace(UserHelper::getListingContent($listing, Auth::user()->language), '...', 100) !!}
                                                        <div class="overlay" onclick="toggleModal(event)">
                                                            <i class="fa-solid fa-magnifying-glass view-more"
                                                                data-target="#commentForm{{ $listing->id }}"
                                                                data-bs-toggle="modal" data-bs-target="#myModal"></i>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td class="text-custom">
                                                    <div class="text-container" data-text="{{ UserHelper::getListingContent($listing, Auth::user()->supporting_language) }}">
                                                        {!! substr_replace(UserHelper::getListingContent($listing, Auth::user()->supporting_language), '...', 100) !!}
                                                        <div class="overlay" onclick="toggleModal(event)">
                                                            <i class="fa-solid fa-magnifying-glass view-more"
                                                                data-target="#commentForm{{ $listing->id }}"
                                                                data-bs-toggle="modal" data-bs-target="#myModal"></i>
                                                        </div>
                                                    </div>
                                                </td>

                                                @php
                                                    $userLevel = UserHelper::LastUserLevel(
                                                        $listing->comment->current_user_level,
                                                    );
                                                @endphp
                                                <td class="comment-store" style="width:20%"
                                                    id="commentForm{{ $listing->id }}">
                                                    @if (UserHelper::userCan(['create_comment', 'update_comment', 'read_comment'], false) && $userLevel == true)
                                                        @if (!empty($listing->comment))
                                                            <form id="form-{{ $listing->id }}"
                                                                action="{{ route('book.comment.store', $listing->id) }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="comment_id"
                                                                    value="{{ $listing->comment->id }}">
                                                                <input type="hidden" name="book_translation_id"
                                                                    value="{{ $listing->id }}">
                                                                <input type="hidden" name="type" value="comment">
                                                                <textarea class="form-control" placeholder="write you commment here" cols="10" name="comment">{{ $listing->comment->comment }}</textarea>

                                                                @if (UserHelper::userCan(['create_comment', 'update_comment']))
                                                                    <button class="badge badge-success mt-1 submit-this"
                                                                        type="button"
                                                                        data-form="#form-{{ $listing->id }}"
                                                                        style="float: inline-end"><i
                                                                            class="fa-solid fa-check"></i></button>
                                                                @endif
                                                            </form>
                                                        @else
                                                            <form id="form-{{ $listing->id }}"
                                                                action="{{ route('book.comment.store', $listing->id) }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="comment_id" value="">
                                                                <input type="hidden" name="book_translation_id"
                                                                    value="{{ $listing->id }}">
                                                                <input type="hidden" name="type" value="comment">
                                                                <textarea placeholder="write you commment here" class="form-control" name="comment"></textarea>

                                                                @if (UserHelper::userCan(['create_comment', 'update_comment']) && $userLevel == true)
                                                                    <button class="badge badge-success mt-1"
                                                                        type="button"
                                                                        data-form="#form-{{ $listing->id }}"
                                                                        placeholder="comment" style="float: inline-end"><i
                                                                            class="fa-solid fa-check"></i></button>
                                                                @endif
                                                            </form>
                                                        @endif
                                                    @endif

                                                </td>

                                                <td class="text-end">
                                                    @php
                                                        $statusArr = [
                                                            'approved_without_comment' => 'A',
                                                            'approved_with_comment' => 'B',
                                                            'reject_revise_and_resubmit' => 'C',
                                                            'under_review' => 'U',
                                                            'in-process' => 'I',
                                                        ];
                                                    @endphp


                                                    @if ($listing->comment && $userLevel == true)
                                                        <div class="card-heade">
                                                            <select class="form-select status-update"
                                                                data-bookid="{{ $listing->comment->id }}"
                                                                style="width: 80px">
                                                                @foreach ($statusArr as $val => $status)
                                                                    <option
                                                                        @if ($val == $listing->comment->text_status) class="{{ 'cl-' . $val }} selected" value="{{ $val }}" @else class="{{ 'cl-' . $val }}" value="{{ $val }}" @endif
                                                                        @if ($val == $listing->comment->text_status) selected @endif>
                                                                        {{ $status }}</option>
                                                                @endforeach

                                                            </select>
                                                            <div class="badge-area d-none">
                                                                @if ($listing->comment->text_status == 'approved_without_comment')
                                                                    <span class="badge badge-success">A</span>
                                                                @elseif($listing->comment->text_status == 'approved_with_comment')
                                                                    <span class="badge badge-info">B</span>
                                                                @elseif($listing->comment->text_status == 'reject_revise_and_resubmit')
                                                                    <span class="badge badge-danger">C</span>
                                                                @elseif($listing->comment->text_status == 'under_review')
                                                                    <span class="badge badge-warning">U</span>
                                                                @elseif($listing->comment->text_status == 'in-process')
                                                                    <span class="badge badge-secondary">I</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="audio-container" style="width:20%">
                                                    <audio controls>
                                                        <source src="https://{{ $listing->urdu_audio }}"
                                                            type="audio/mp3">
                                                    </audio>
                                                </td>
                                                <td class="text-end">
                                                    @php
                                                        $statusArr = [
                                                            'approved_without_comment' => 'A',
                                                            'approved_with_comment' => 'B',
                                                            'reject_revise_and_resubmit' => 'C',
                                                            'under_review' => 'U',
                                                            'in-process' => 'I',
                                                        ];
                                                    @endphp


                                                    @if ($listing->comment && $userLevel == true)
                                                        <div class="card-heade">
                                                            <select class="form-select status-update-audio"
                                                                data-bookid="{{ $listing->comment->id }}"
                                                                style="width: 80px">
                                                                @foreach ($statusArr as $val => $status)
                                                                    <option
                                                                        @if ($val == $listing->comment->urdu_audio_status) class="{{ 'cl-' . $val }} selected" value="{{ $val }}" @else class="{{ 'cl-' . $val }}"
                                                                            value="{{ $val }}" @endif
                                                                        @if ($val == $listing->comment->urdu_audio_status) selected @endif>
                                                                        {{ $status }}</option>
                                                                @endforeach

                                                            </select>
                                                            <div class="badge-area d-none">
                                                                @if ($listing->comment->urdu_audio_status == 'approved_without_comment')
                                                                    <span class="badge badge-success">A</span>
                                                                @elseif($listing->comment->urdu_audio_status == 'approved_with_comment')
                                                                    <span class="badge badge-info">B</span>
                                                                @elseif($listing->comment->urdu_audio_status == 'reject_revise_and_resubmit')
                                                                    <span class="badge badge-danger">C</span>
                                                                @elseif($listing->comment->urdu_audio_status == 'under_review')
                                                                    <span class="badge badge-warning">U</span>
                                                                @elseif($listing->comment->urdu_audio_status == 'in-process')
                                                                    <span class="badge badge-secondary">I</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td class="d-flex justify-content-evenly w-100 ">
                                                    @if (UserHelper::userCan(['update_book_sentence']) && $userLevel == true)
                                                        <button type="button"
                                                            data-action="{{ route('book.update', $listing->id) }}"
                                                            class="btn-primary btn-sm edit-listing"
                                                            data-lang="{{Auth::user()->language}}"
                                                            data-listId ="{{ $listing->id }}" data-bs-toggle="modal"
                                                            data-bs-target="#add-book-form-md">
                                                            <i class="fa-solid fa-pencil "></i>
                                                        </button>
                                                    @endif
                                                    @if (UserHelper::userCan(['delete_book_sentence']) && $userLevel == true)
                                                        <form method="POST"
                                                            action="{{ route('book.delete', $listing->id) }}"
                                                            style="display:inline">
                                                            @method('POST')
                                                            @csrf
                                                            <button type="submit" class="btn-danger btn-sm"><i
                                                                    class="fa-solid fa-trash "></i></button>
                                                        </form>
                                                    @endif
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
        @include('modals')
    </div>

    {{-- <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">✖</span>
            <div id="modalText"></div>
            <div id="annotations"></div>
        </div>
    </div> --}}

@endsection

@section('page_script')

    <script>
        var userLang =
        $(".add-book").click(function() {
            $this = $(this);
            $("#add-book-form")[0].reset()
            const formAction = $this.attr('data-action');
            $("#add-book-form").attr('action', formAction)
            $("#add-book-form-md").find('.modal-title').text("Add Book")
            $(".submit-add-book").text("Create").attr("data-button", 'add');
            $("#audio-data").hide()
        })
        $(".edit-listing").click(function() {
            $this = $(this);
            var lang = $this.attr('data-lang');
            const listId = $this.attr('data-listId');
            const formAction = $this.attr('data-action');
            $("#add-book-form-md").find('.modal-title').text("Update Book")
            var urll = "{{ route('book.edit', ':bookId') }}".replace(':bookId', listId);
            $("#add-book-form").attr('action', formAction)

            $(".submit-add-book").text("Update").attr("data-button", 'update');

            $.ajax({
                type: 'GET',
                url: urll,
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    var data = response.data;
                    $("input[name='book_number']").val(data.book_number)
                    $("input[name='chapter']").val(data.chapter)
                    $("input[name='page_number']").val(data.page_number)
                    $("input[name='sentence']").val(data.chapter)
                    if(lang == 'urdu'){
                        $("textarea[name='text']").val(data.urdu)
                    }else if(lang == 'hindi'){
                        $("textarea[name='text']").val(data.arabic)
                    }else if(lang == 'indonesian'){
                        $("textarea[name='text']").val(data.indonesian)
                    }else if(lang == 'bengali'){
                        $("textarea[name='text']").val(data.bengali)
                    }else if(lang == 'persian'){
                        $("textarea[name='text']").val(data.persian)
                    }else if(lang == 'turkish'){
                        $("textarea[name='text']").val(data.turkish)
                    }else if(lang == 'english'){
                        $("textarea[name='text']").val(data.english)
                    }else if(lang == 'arabic'){
                        $("textarea[name='text']").val(data.arabic)
                    }else{
                        $("textarea[name='text']").val(data.text)
                    }

                    $("textarea[name='supporting_language']").val(data.supporting_language)

                    $("#audio-data").html(`<audio controls  ><source src="${'https://'+data.urdu_audio}" type="audio/mp3"></audio>`);


                },
                error: function(xhr, status, error) {

                    toastr.error('An error occurred: ' + xhr.responseText);
                }
            });
        })

        // Assuming you have a form with id "add-book-form" that includes a file input



        $(".submit-add-book").click(function(e) {
            var cls = 'fa-solid fa-check';
            var loader = 'fa fa-spinner fa-spin';
            e.preventDefault();
            $this = $(this);
            $this.find('i').addClass(loader).removeClass(cls)
            var formId = "#add-book-form";
            const formAction = $this.attr('data-action');
            var button = $this.attr('data-button');

            $("#add-book-form").attr('data-action', formAction)


            if (button == 'add') {
                $this.text("Creating..")
            } else {
                $this.text("Updating..")

            }
            var formData = new FormData(document.getElementById("add-book-form"));

            $.ajax({
                type: 'POST',
                url: $("#add-book-form").attr('action'),
                data: formData,
                processData: false, // Prevent jQuery from automatically processing the data
                contentType: false, // Prevent jQuery from setting the content type
                success: function(response) {
                    $this.find('i').addClass(cls).removeClass(loader);
                    setTimeout(() => {
                        if (button === 'add') {
                            $this.text("Create");
                        } else {
                            $this.text("Update");
                        }
                    }, 800);

                    toastr.success("Book submitted successfully!");
                },
                error: function(xhr, status, error) {

                    toastr.error('An error occurred: ' +error.message);
                }
            });


        })
        $(document).on("click", ".submit-this", function(e) {

            var cls = 'fa-solid fa-check';
            var loader = 'fa fa-spinner fa-spin';
            e.preventDefault();
            $this = $(this);
            $this.find('i').addClass(loader).removeClass(cls)
            var formId = $this.attr('data-form');
            $.ajax({
                type: 'POST',
                url: $(formId).attr('action'),
                data: $(formId).serialize(), // Serialize the form data
                success: function(response) {
                    $this.find('i').addClass(cls).removeClass(loader)
                    toastr.success("Comment submitted successfully!");
                },
                error: function(xhr, status, error) {

                    toastr.error('An error occurred: ' + xhr.responseText);
                }
            });

        })


        $(".status-update-audio").change(function() {
            $this = $(this);
            var bookId = $this.attr('data-bookid');
            var urll = "{{ route('book.comment.status.audioupdate', ':bookId') }}".replace(':bookId', bookId);

            if (confirm("are you sure you want to update the status for this Audio file?")) {

                $.ajax({
                    url: urll,
                    type: 'POST',
                    headers: {
                        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        urdu_audio_status: $(this).val(),

                    },
                    success: function(response) {
                        toastr.success("Audio Status Successfully Updated");
                    },
                    error: function(xhr, status, error) {
                        toastr.error("There is some error at backend");

                    }
                });

            }
            return false


        })
        $(".status-update").change(function() {
            $this = $(this);
            var bookId = $this.attr('data-bookid');
            var urll = "{{ route('book.comment.status.update', ':bookId') }}".replace(':bookId', bookId);

            if (confirm("are you sure you want to update the status for this sentance?")) {

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

                        toastr.success("Text Status Successfully Updated");
                    },
                    error: function(xhr, status, error) {
                        toastr.error("There is some error at backend");
                    }
                });

            }
            return false


        })

        function toggleModal(event) {
            const modal = document.getElementById("myModal");

            const text = event.target.closest('.text-container'); // Get the text content

            const dataText = text.getAttribute('data-text');

            document.getElementById("modalText").innerHTML = dataText; // Set text in modal
        }

        // $(".view-more").click(function(){
        //     var tar = $(this).attr('data-target');
        //     var html = $(tar).html();

        //     $("#myModal").find('.modal-footer').html(html)

        //     console.log("html",html)
        // })


        // Close the modal when the user clicks anywhere outside of the modal content


        document.getElementById('text-content').addEventListener('mouseup', function() {
            const selection = window.getSelection();
            const selectedText = selection.toString();

            if (selectedText) {
                const annotation = prompt("Add your annotation:");
                if (annotation) {
                    const range = selection.getRangeAt(0);
                    const span = document.createElement('span');
                    span.className = 'annotation';
                    span.title = annotation;
                    span.textContent = selectedText;
                    span.onclick = () => alert(annotation); // Display annotation on click

                    range.deleteContents();
                    range.insertNode(span);

                    const annotationsDiv = document.getElementById('annotations');
                    const newAnnotation = document.createElement('div');
                    newAnnotation.textContent = `Annotation: ${annotation}`;
                    annotationsDiv.appendChild(newAnnotation);
                }
                selection.removeAllRanges(); // Clear selection
            }
        });

        document.getElementById('close-popup').addEventListener('click', function() {
            document.getElementById('popup').style.display = 'none';
        });

        // Function to open the popup (for demonstration)
        function openPopup() {
            document.getElementById('popup').style.display = 'block';
        }

        // Call this function to open the popup
        openPopup();
    </script>
@endsection
