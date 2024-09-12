@extends('layouts.app')
@section('content')

<style>
.default-dashboard .transaction-history table tbody tr td {
    /* color: var(--dark); */
    font-weight: 100;
}

</style>
    <div class="page-body">
        @include('breadcrumb')
        <!-- Container-fluid starts-->
        <div class="container-fluid default-dashboard">
            <div class="row">
                <div class="col-xxl-12 col-xl-8 proorder-xxl-8 col-lg-12 col-md-6 box-col-7">
                    <div class="card">
                        <div class="card-header card-no-border pb-0">
                            <h3>Transition History</h3>
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
                                            <th>Comment Count</th>
                                            <th class="text-center">Text Status</th>
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
                                                    {!!$listing->text!!}
                                                </td>
                                                <td>{{$listing->comment->count()}}</td>
                                                <td class="text-end">
                                                    <a href="{{ route('book.comment',$listing->id) }}">
                                                    @if ($listing->text_status == 'in-process')
                                                        <div class="btn bg-light-warning border-light-warning text-warning">
                                                            In Process</div>
                                                    @elseif($listing->text_status == 'approved_without_comment')
                                                        <div class="btn bg-light-success border-light-success text-success">
                                                            Approved without comment</div>
                                                    @elseif($listing->text_status == 'approved_with_comment')
                                                    <div class="btn bg-light-success border-light-success text-success">
                                                        Approved with comment</div>
                                                    @elseif($listing->text_status == 'reject_revise_and_resubmit')
                                                    <div class="btn bg-light-success border-light-success text-success">
                                                        Reject Revise Resubmit</div>
                                                    @elseif($listing->text_status == 'under_review')
                                                        <div class="btn bg-light-danger border-light-danger text-danger">
                                                            Under Review</div>
                                                    @endif
                                                    </a>
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
