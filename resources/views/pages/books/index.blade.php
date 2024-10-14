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

                                            <th>Text</th>
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
                                                            <span class="icon">➕</span>
                                                        </div>
                                                    </div>


                                                </td>
                                                <td class="text-custom">
                                                    <div class="text-container">
                                                        <span class="text">{!! $listing->supporting_language !!}</span>
                                                        <div class="overlay" onclick="toggleModal(event)">
                                                            <span class="icon">➕</span>
                                                        </div>
                                                    </div>
                                                </td>

                                                @php
                                                    $userLevel = UserHelper::LastUserLevel(
                                                        $listing->comment->current_user_level,
                                                    );
                                                @endphp
                                                <td>
                                                    @if (UserHelper::userCan(['create_comment', 'update_comment', 'read_comment'], false) && $userLevel == true)
                                                        @if (!empty($listing->comment))
                                                            <form action="{{ route('book.comment.store', $listing->id) }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="comment_id"
                                                                    value="{{ $listing->comment->id }}">
                                                                <input type="hidden" name="book_translation_id"
                                                                    value="{{ $listing->id }}">
                                                                <input type="hidden" name="type" value="comment">
                                                                <textarea class="form-control" cols="10" name="comment">{{ $listing->comment->comment }}</textarea>

                                                                @if (UserHelper::userCan(['create_comment', 'update_comment']))
                                                                    <button class="badge badge-success mt-1" type="submit"
                                                                        style="float: inline-end"><i
                                                                            class="fa-solid fa-check"></i></button>
                                                                @endif
                                                            </form>
                                                        @else
                                                            <form action="{{ route('book.comment.store', $listing->id) }}"
                                                                method="post">
                                                                @csrf
                                                                <input type="hidden" name="comment_id" value="">
                                                                <input type="hidden" name="book_translation_id"
                                                                    value="{{ $listing->id }}">
                                                                <input type="hidden" name="type" value="comment">
                                                                <textarea class="form-control" name="comment"> </textarea>

                                                                @if (UserHelper::userCan(['create_comment', 'update_comment']) && $userLevel == true)
                                                                    <button class="badge badge-success mt-1" type="submit"
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
                                                                data-bookid="{{ $listing->comment->id }}">
                                                                @foreach ($statusArr as $val => $status)
                                                                    <option
                                                                        @if ($val == $listing->comment->text_status) class="{{ 'cl-' . $val }} selected" value="{{ $val }}" @else class="{{ 'cl-' . $val }}" value="{{ $val }}" @endif
                                                                        @if ($val == $listing->comment->text_status) selected @endif>
                                                                        Status : {{ $status }}</option>
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
                                                <td>
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
                                                                data-bookid="{{ $listing->comment->id }}">
                                                                @foreach ($statusArr as $val => $status)
                                                                    <option
                                                                        @if ($val == $listing->comment->text_status) class="{{ 'cl-' . $val }} selected" value="{{ $val }}" @else class="{{ 'cl-' . $val }}" value="{{ $val }}" @endif
                                                                        @if ($val == $listing->comment->text_status) selected @endif>
                                                                        Status : {{ $status }}</option>
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

                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        alert('some issue')
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
