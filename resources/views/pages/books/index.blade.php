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
    </style>
@php
    use App\Helpers\UserHelper;
    $role= UserHelper::userRole();
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
                                            <th>Book Number</th>
                                            <th>Chapter</th>
                                            <th>Page Number / Sentence</th>
                                            <th>Text</th>
                                            <th>Comment</th>
                                            <th class="text-center">Book Status</th>
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
                                                                <h6>{{ $listing->book_number }}</h6>
                                                            </a>
                                                            {{-- <p>Item Sold</p> --}}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $listing->chapter }}</td>
                                                <td class="text-success">{{ $listing->page_number }} /
                                                    {{ $listing->sentence }}</td>
                                                <td>
                                                    {!! $listing->text !!}
                                                </td>
                                                <td>
                                                    @if (!empty($listing->comment))
                                                        <form action="{{ route('book.comment.store', $listing->id) }}"
                                                            method="post">
                                                            @csrf
                                                            <input type="hidden" name="comment_id"
                                                                value="{{ $listing->comment->id }}">
                                                            <input type="hidden" name="book_translation_id"
                                                                value="{{ $listing->id }}">
                                                            <input type="hidden" name="type" value="comment">
                                                            <textarea class="form-control" name="comment">{{ $listing->comment->comment }}</textarea>
                                                            <button class="badge badge-success mt-1" type="submit"
                                                                style="float: inline-end"><i
                                                                    class="fa-solid fa-check"></i></button>
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
                                                            <button class="badge badge-success mt-1" type="submit"
                                                                placeholder="comment" style="float: inline-end"><i
                                                                    class="fa-solid fa-check"></i></button>
                                                        </form>
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

                                                    @if ($listing->comment)
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

                    }
                });

            }
            return false


        })
    </script>
@endsection
