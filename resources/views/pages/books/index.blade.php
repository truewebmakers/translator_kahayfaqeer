@extends('layouts.app')
@section('content')
    <style>
        .default-dashboard .transaction-history table tbody tr td {
            /* color: var(--dark); */
            font-weight: 100;
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
            width: 66%;
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


                            <h3>Books <button class="btn btn-outline-success btn-sm add-book"
                                    data-action="{{ route('book.store') }}" type="button" data-bs-toggle="modal"
                                    data-bs-target="#add-book-form-md">Add Book</button></h3>

                        </div>
                        <div class="card-body transaction-history pt-0">
                            <div class="table-responsive theme-scrollbar">
                                <table class="table display table-bordernone" id="transaction" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Bookno</th>
                                            <th>Chapter</th>
                                            <th>Pageno</th>
                                            <th>Sentence</th>

                                            @if(Auth::user()->department == 'seed')  <th>Supporting Language</th> @endif
                                            @if(Auth::user()->department == 'seed')  <th>Urdu</th>  @endif
                                            @if(Auth::user()->department == 'translation' && Auth::user()->language == 'english')  <th>English</th>  @endif
                                            @if(Auth::user()->department == 'translation' && Auth::user()->language == 'arabic')  <th>Arabic</th>  @endif
                                            @if(Auth::user()->department == 'translation' && Auth::user()->language == 'hindi')  <th>Hindi</th>  @endif
                                            @if(Auth::user()->department == 'translation' && Auth::user()->language == 'indonesian')  <th>Indonesian</th>  @endif
                                            @if(Auth::user()->department == 'translation' && Auth::user()->language == 'bengali')  <th>Bengali</th>  @endif
                                            @if(Auth::user()->department == 'translation' && Auth::user()->language == 'persian')  <th>Persian</th>  @endif
                                            @if(Auth::user()->department == 'translation' && Auth::user()->language == 'turkish')  <th>Turkish</th>  @endif



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
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        {{-- <div class="flex-shrink-0"><img src="../assets/images/dashboard-1/icon/1.png" alt=""/></div> --}}
                                                        <div class="flex-grow-1">
                                                            <a href="{{ route('book.create') }}">
                                                                <h6>{{ $listing->book_number }} </h6>
                                                            </a>
                                                            {{-- <p>Item Sold</p> --}}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $listing->chapter }}</td>
                                                <td>{{ $listing->page_number }}</td>
                                                <td>{{ $listing->sentence }}</td>

                                                @if(Auth::user()->department == 'seed')
                                                <td class="text-custom">

                                                    <div class="text-container" data-text="{{ $listing->text }}">
                                                        {!! substr_replace($listing->text, '...', 100) !!}
                                                        <div class="overlay" onclick="toggleModal(event)">
                                                            <i class="fa-solid fa-magnifying-glass" data-bs-toggle="modal"
                                                                data-bs-target="#myModal"></i>
                                                        </div>
                                                    </div>


                                                </td>
                                                @endif
                                                @if(Auth::user()->department == 'seed')

                                                <td class="text-custom">
                                                    <div class="text-container" data-text="{{ $listing->supporting_language }}">
                                                        <span class="text"> {!! substr_replace($listing->supporting_language, '...', 100) !!} </span>
                                                        <div class="overlay" onclick="toggleModal(event)">
                                                            <i class="fa-solid fa-magnifying-glass" data-bs-toggle="modal"
                                                                data-bs-target="#myModal"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                @endif
                                                @if(Auth::user()->department == 'translation' && Auth::user()->language == 'english')
                                                <td class="text-custom">
                                                    <div class="text-container" data-text="{{ $listing->urdu }}">
                                                        <span class="text"> {!! substr_replace($listing->urdu, '...', 100) !!} </span>
                                                        <div class="overlay" onclick="toggleModal(event)">
                                                            <i class="fa-solid fa-magnifying-glass" data-bs-toggle="modal"
                                                                data-bs-target="#myModal"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                @endif
                                                @if(Auth::user()->department == 'translation' && Auth::user()->language == 'english')

                                                <td class="text-custom">
                                                    <div class="text-container" data-text="{{ $listing->english }}">
                                                        <span class="text"> {!! substr_replace($listing->english, '...', 100) !!} </span>
                                                        <div class="overlay" onclick="toggleModal(event)">
                                                            <i class="fa-solid fa-magnifying-glass" data-bs-toggle="modal"
                                                                data-bs-target="#myModal"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                @endif

                                                @if(Auth::user()->department == 'translation' && Auth::user()->language == 'arabic')

                                                <td class="text-custom">
                                                    <div class="text-container" data-text="{{ $listing->arabic }}">
                                                        <span class="text"> {!! substr_replace($listing->arabic, '...', 100) !!} </span>
                                                        <div class="overlay" onclick="toggleModal(event)">
                                                            <i class="fa-solid fa-magnifying-glass" data-bs-toggle="modal"
                                                                data-bs-target="#myModal"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                @endif

                                                @if(Auth::user()->department == 'translation' && Auth::user()->language == 'hindi')

                                                <td class="text-custom">
                                                    <div class="text-container" data-text="{{ $listing->hindi }}">
                                                        <span class="text"> {!! substr_replace($listing->hindi, '...', 100) !!} </span>
                                                        <div class="overlay" onclick="toggleModal(event)">
                                                            <i class="fa-solid fa-magnifying-glass" data-bs-toggle="modal"
                                                                data-bs-target="#myModal"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                @endif

                                                @if(Auth::user()->department == 'translation' && Auth::user()->language == 'indonesian')

                                                <td class="text-custom">
                                                    <div class="text-container" data-text="{{ $listing->indonesian }}">
                                                        <span class="text"> {!! substr_replace($listing->indonesian, '...', 100) !!} </span>
                                                        <div class="overlay" onclick="toggleModal(event)">
                                                            <i class="fa-solid fa-magnifying-glass" data-bs-toggle="modal"
                                                                data-bs-target="#myModal"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                @endif
                                                @if(Auth::user()->department == 'translation' && Auth::user()->language == 'bengali')

                                                <td class="text-custom">
                                                    <div class="text-container" data-text="{{ $listing->bengali }}">
                                                        <span class="text"> {!! substr_replace($listing->bengali, '...', 100) !!} </span>
                                                        <div class="overlay" onclick="toggleModal(event)">
                                                            <i class="fa-solid fa-magnifying-glass" data-bs-toggle="modal"
                                                                data-bs-target="#myModal"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                @endif
                                                @if(Auth::user()->department == 'translation' && Auth::user()->language == 'persian')

                                                <td class="text-custom">
                                                    <div class="text-container" data-text="{{ $listing->persian }}">
                                                        <span class="text"> {!! substr_replace($listing->persian, '...', 100) !!} </span>
                                                        <div class="overlay" onclick="toggleModal(event)">
                                                            <i class="fa-solid fa-magnifying-glass" data-bs-toggle="modal"
                                                                data-bs-target="#myModal"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                @endif
                                                @if(Auth::user()->department == 'translation' && Auth::user()->language == 'turkish')

                                                <td class="text-custom">
                                                    <div class="text-container" data-text="{{ $listing->turkish }}">
                                                        <span class="text"> {!! substr_replace($listing->turkish, '...', 100) !!} </span>
                                                        <div class="overlay" onclick="toggleModal(event)">
                                                            <i class="fa-solid fa-magnifying-glass" data-bs-toggle="modal"
                                                                data-bs-target="#myModal"></i>
                                                        </div>
                                                    </div>
                                                </td>
                                                @endif




                                                @php
                                                    $userLevel = UserHelper::LastUserLevel(
                                                        $listing->comment->current_user_level,
                                                    );
                                                @endphp
                                                <td class="comment-store" style="width:20%">
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
                                                                <textarea class="form-control" cols="10" name="comment">{{ $listing->comment->comment }}</textarea>

                                                                @if (UserHelper::userCan(['create_comment', 'update_comment']))
                                                                    <button class="badge badge-success mt-1 submit-this"
                                                                        type="button"
                                                                        data-form="#form-{{ $listing->id }}"
                                                                        style="float: inline-end"><i  class="fa-solid fa-check"></i></button>
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
                                                                <textarea class="form-control" name="comment"> </textarea>

                                                                @if (UserHelper::userCan(['create_comment', 'update_comment']) && $userLevel == true)
                                                                    <button class="badge badge-success mt-1" type="button"
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
                                                        <source src="https://{{ $listing->urdu_audio }}" type="audio/mp3">
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
        $(".add-book").click(function() {
            $this = $(this);
            const formAction = $this.attr('data-action');
            $("#add-book-form").attr('action', formAction)
            $("#add-book-form-md").find('.modal-title').text("Add Book")
            $(".submit-add-book").text("Create");
        })
        $(".edit-listing").click(function() {
            $this = $(this);
            const listId = $this.attr('data-listId');
            const formAction = $this.attr('data-action');
            $("#add-book-form-md").find('.modal-title').text("Update Book")
            var urll = "{{ route('book.edit', ':bookId') }}".replace(':bookId', listId);
            $("#add-book-form").attr('action', formAction)
            $(".submit-add-book").text("Update");

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
                    $("textarea[name='text']").val(data.text)
                    $("textarea[name='supporting_language']").val(data.supporting_language)
                    $("input[name='urdu_audio']").val(data.urdu_audio)

                },
                error: function(xhr, status, error) {

                    toastr.error('An error occurred: ' + xhr.responseText);
                }
            });
        })



        $(".submit-add-book").click(function(e) {
            var cls = 'fa-solid fa-check';
            var loader = 'fa fa-spinner fa-spin';
            e.preventDefault();
            $this = $(this);
            $this.find('i').addClass(loader).removeClass(cls)
            var formId = "#add-book-form";
            const formAction = $this.attr('data-action');

            $("#add-book-form").attr('data-action', formAction)


            $.ajax({
                type: 'POST',
                url: $("#add-book-form").attr('action'),
                data: $("#add-book-form").serialize(), // Serialize the form data
                success: function(response) {
                    $this.find('i').addClass(cls).removeClass(loader)
                    toastr.success("Book submitted successfully!");
                },
                error: function(xhr, status, error) {

                    toastr.error('An error occurred: ' + xhr.responseText);
                }
            });

        })
        $(".submit-this").click(function(e) {
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
            console.log("dataText", text)
            document.getElementById("modalText").innerHTML = dataText; // Set text in modal
        }



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
