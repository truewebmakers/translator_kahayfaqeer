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

        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 70%;
            /* Could be more or less, depending on screen size */
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .default-dashboard .transaction-history table tbody tr td .btn {
            min-width: 77px;
            padding: 2px 13px;
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
            <div class="row">
                <div class="col-xxl-12 col-xl-8 proorder-xxl-8 col-lg-12 col-md-6 box-col-7">
                    <div class="card">
                        <div class="card-header card-no-border pb-0">
                            <h3>Books</h3>
                        </div>
                        <div class="card-body transaction-history pt-0">
                            <div class="table-responsive theme-scrollbar">
                                <table class="table display table-bordernone" id="transaction" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Bookno/Chapter / Pageno / Sentence</th>

                                            <th>Language</th>
                                            <th>Supporting Language</th>
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
                                                                <h6>{{ $listing->book_number }} / {{ $listing->chapter }} /
                                                                    {{ $listing->page_number }} /
                                                                    {{ $listing->sentence }}</h6>
                                                            </a>
                                                            {{-- <p>Item Sold</p> --}}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-custom">

                                                    <div class="text-container">
                                                        <span class="text">{!! $listing->text !!}</span>
                                                        <div class="overlay" onclick="toggleModal(event)">
                                                            <span class="icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    x="0px" y="0px" width="50" height="50"
                                                                    viewBox="0 0 128 128">
                                                                    <path
                                                                        d="M 52.349609 14.400391 C 42.624609 14.400391 32.9 18.1 25.5 25.5 C 10.7 40.3 10.7 64.399219 25.5 79.199219 C 32.9 86.599219 42.600391 90.300781 52.400391 90.300781 C 62.200391 90.300781 71.900781 86.599219 79.300781 79.199219 C 94.000781 64.399219 93.999219 40.3 79.199219 25.5 C 71.799219 18.1 62.074609 14.400391 52.349609 14.400391 z M 52.300781 20.300781 C 60.500781 20.300781 68.700391 23.399219 74.900391 29.699219 C 87.400391 42.199219 87.4 62.5 75 75 C 62.5 87.5 42.199219 87.5 29.699219 75 C 17.199219 62.5 17.199219 42.199219 29.699219 29.699219 C 35.899219 23.499219 44.100781 20.300781 52.300781 20.300781 z M 52.300781 26.300781 C 45.400781 26.300781 38.9 29 34 34 C 29.3 38.7 26.700391 44.800391 26.400391 51.400391 C 26.300391 53.100391 27.600781 54.4 29.300781 54.5 L 29.400391 54.5 C 31.000391 54.5 32.300391 53.199609 32.400391 51.599609 C 32.600391 46.499609 34.699219 41.799219 38.199219 38.199219 C 41.999219 34.399219 47.000781 32.300781 52.300781 32.300781 C 54.000781 32.300781 55.300781 31.000781 55.300781 29.300781 C 55.300781 27.600781 54.000781 26.300781 52.300781 26.300781 z M 35 64 A 3 3 0 0 0 32 67 A 3 3 0 0 0 35 70 A 3 3 0 0 0 38 67 A 3 3 0 0 0 35 64 z M 83.363281 80.5 C 82.600781 80.5 81.850781 80.800391 81.300781 81.400391 C 80.100781 82.600391 80.100781 84.499609 81.300781 85.599609 L 83.800781 88.099609 C 83.200781 89.299609 82.900391 90.6 82.900391 92 C 82.900391 94.4 83.8 96.700391 85.5 98.400391 L 98.300781 111 C 100.10078 112.8 102.39922 113.69922 104.69922 113.69922 C 106.99922 113.69922 109.29961 112.79961 111.09961 111.09961 C 114.59961 107.59961 114.59961 101.90039 111.09961 98.400391 L 98.300781 85.599609 C 96.600781 83.899609 94.300391 83 91.900391 83 C 90.500391 83 89.2 83.300391 88 83.900391 L 85.5 81.400391 C 84.9 80.800391 84.125781 80.5 83.363281 80.5 z M 91.900391 88.900391 C 92.700391 88.900391 93.5 89.200781 94 89.800781 L 106.69922 102.5 C 107.89922 103.7 107.89922 105.59922 106.69922 106.69922 C 105.49922 107.89922 103.6 107.89922 102.5 106.69922 L 89.800781 94.099609 C 89.200781 93.499609 88.900391 92.700391 88.900391 91.900391 C 88.900391 91.100391 89.200781 90.300781 89.800781 89.800781 C 90.400781 89.200781 91.100391 88.900391 91.900391 88.900391 z">
                                                                    </path>
                                                                </svg></span>
                                                        </div>
                                                    </div>


                                                </td>
                                                <td class="text-custom">
                                                    <div class="text-container">
                                                        <span class="text">{!! $listing->supporting_language !!}</span>
                                                        <div class="overlay" onclick="toggleModal(event)">
                                                            <span class="icon"><svg xmlns="http://www.w3.org/2000/svg"
                                                                    x="0px" y="0px" width="50" height="50"
                                                                    viewBox="0 0 128 128">
                                                                    <path
                                                                        d="M 52.349609 14.400391 C 42.624609 14.400391 32.9 18.1 25.5 25.5 C 10.7 40.3 10.7 64.399219 25.5 79.199219 C 32.9 86.599219 42.600391 90.300781 52.400391 90.300781 C 62.200391 90.300781 71.900781 86.599219 79.300781 79.199219 C 94.000781 64.399219 93.999219 40.3 79.199219 25.5 C 71.799219 18.1 62.074609 14.400391 52.349609 14.400391 z M 52.300781 20.300781 C 60.500781 20.300781 68.700391 23.399219 74.900391 29.699219 C 87.400391 42.199219 87.4 62.5 75 75 C 62.5 87.5 42.199219 87.5 29.699219 75 C 17.199219 62.5 17.199219 42.199219 29.699219 29.699219 C 35.899219 23.499219 44.100781 20.300781 52.300781 20.300781 z M 52.300781 26.300781 C 45.400781 26.300781 38.9 29 34 34 C 29.3 38.7 26.700391 44.800391 26.400391 51.400391 C 26.300391 53.100391 27.600781 54.4 29.300781 54.5 L 29.400391 54.5 C 31.000391 54.5 32.300391 53.199609 32.400391 51.599609 C 32.600391 46.499609 34.699219 41.799219 38.199219 38.199219 C 41.999219 34.399219 47.000781 32.300781 52.300781 32.300781 C 54.000781 32.300781 55.300781 31.000781 55.300781 29.300781 C 55.300781 27.600781 54.000781 26.300781 52.300781 26.300781 z M 35 64 A 3 3 0 0 0 32 67 A 3 3 0 0 0 35 70 A 3 3 0 0 0 38 67 A 3 3 0 0 0 35 64 z M 83.363281 80.5 C 82.600781 80.5 81.850781 80.800391 81.300781 81.400391 C 80.100781 82.600391 80.100781 84.499609 81.300781 85.599609 L 83.800781 88.099609 C 83.200781 89.299609 82.900391 90.6 82.900391 92 C 82.900391 94.4 83.8 96.700391 85.5 98.400391 L 98.300781 111 C 100.10078 112.8 102.39922 113.69922 104.69922 113.69922 C 106.99922 113.69922 109.29961 112.79961 111.09961 111.09961 C 114.59961 107.59961 114.59961 101.90039 111.09961 98.400391 L 98.300781 85.599609 C 96.600781 83.899609 94.300391 83 91.900391 83 C 90.500391 83 89.2 83.300391 88 83.900391 L 85.5 81.400391 C 84.9 80.800391 84.125781 80.5 83.363281 80.5 z M 91.900391 88.900391 C 92.700391 88.900391 93.5 89.200781 94 89.800781 L 106.69922 102.5 C 107.89922 103.7 107.89922 105.59922 106.69922 106.69922 C 105.49922 107.89922 103.6 107.89922 102.5 106.69922 L 89.800781 94.099609 C 89.200781 93.499609 88.900391 92.700391 88.900391 91.900391 C 88.900391 91.100391 89.200781 90.300781 89.800781 89.800781 C 90.400781 89.200781 91.100391 88.900391 91.900391 88.900391 z">
                                                                    </path>
                                                                </svg></span>
                                                        </div>
                                                    </div>
                                                </td>

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
                                                                style="width: 110px">
                                                                @foreach ($statusArr as $val => $status)
                                                                    <option
                                                                        @if ($val == $listing->comment->text_status) class="{{ 'cl-' . $val }} selected" value="{{ $val }}" @else class="{{ 'cl-' . $val }}" value="{{ $val }}" @endif
                                                                        @if ($val == $listing->comment->text_status) selected @endif>
                                                                         {{ $status }}</option>
                                                                @endforeach

                                                            </select>
                                                            <div class="badge-area">
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
                                                                style="width: 110px">
                                                                @foreach ($statusArr as $val => $status)
                                                                    <option
                                                                        @if ($val == $listing->comment->urdu_audio_status) class="{{ 'cl-' . $val }} selected" value="{{ $val }}" @else class="{{ 'cl-' . $val }}" value="{{ $val }}" @endif
                                                                        @if ($val == $listing->comment->urdu_audio_status) selected @endif>
                                                                         {{ $status }}</option>
                                                                @endforeach

                                                            </select>
                                                            <div class="badge-area">
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
                                                <td>
                                                    @if (UserHelper::userCan(['update_book_sentence']) && $userLevel == true)
                                                        <a class="btn btn-primary"
                                                            href="{{ route('book.edit', $listing->id) }}">Edit</a>
                                                    @endif
                                                    @if (UserHelper::userCan(['delete_book_sentence']) && $userLevel == true)
                                                        <form method="POST"
                                                            action="{{ route('book.delete', $listing->id) }}"
                                                            style="display:inline">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger">Delete</button>
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
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">✖</span>
            <div id="modalText"></div>
            <div id="annotations"></div>
        </div>
    </div>
@endsection

@section('page_script')
    <script>
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
            const text = event.target.closest('.text-container').querySelector('.text').innerHTML; // Get the text content
            console.log("text", text)
            document.getElementById("modalText").innerHTML = text; // Set text in modal
            modal.style.display = (modal.style.display === "block") ? "none" : "block"; // Toggle modal visibility
            event.stopPropagation(); // Prevent click event from bubbling up
        }

        function closeModal() {
            const modal = document.getElementById("myModal");
            modal.style.display = "none"; // Hide the modal
        }

        // Close the modal when the user clicks anywhere outside of the modal content
        window.onclick = function(event) {
            const modal = document.getElementById("myModal");
            if (event.target === modal) {
                modal.style.display = "none";
            }
        }

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
