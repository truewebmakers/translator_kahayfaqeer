<div class="modal fade" id="add-book-form-md" tabindex="-1" aria-labelledby="mdModalLabel" style="display: none;"
    aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="mdModalLabel">Add Book </h3>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body dark-modal ">

                <div class="modal-details">
                    <div class="form theme-form basic-form">
                          <form id="add-book-form" action="{{ route('book.store') }}" method="post" enctype="multipart/form-data">


                        @csrf

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <h5 class="f-w-600 mb-2">Book Number</h5>
                                    <input class="form-control" type="text" placeholder="Book Number"
                                        name="book_number" value="{{ isset($book) ? $book->book_number : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <h5 class="f-w-600 mb-2">Chapter Number</h5>
                                    <input class="form-control" type="text" placeholder="Chapter Number"
                                        name="chapter" value="{{ isset($book) ? $book->chapter : '' }}">
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <h5 class="f-w-600 mb-2">Page Number</h5>
                                    <input class="form-control" type="text" placeholder="Enter Page Number"
                                        name="page_number" value="{{ isset($book) ? $book->page_number : '' }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <h5 class="f-w-600 mb-2">Sentence</h5>
                                    <input class="form-control" type="text" placeholder="Enter Sentence"
                                        name="sentence" value="{{ isset($book) ? $book->sentence : '' }}">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <h5 class="f-w-600 mb-2">Add Your Language ( {{Auth::user()->language }} )</h5>
                                    <textarea class="form-control" id="bookLine" name="text" rows="10">{{ isset($book) ? $book->text : '' }}</textarea>
                                </div>
                            </div>
                        </div>

{{--
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <h5 class="f-w-600 mb-2">Second Language </h5>
                                    <textarea class="form-control" id="bookLine2" name="supporting_language" rows="3">{{ isset($book) ? $book->supporting_language : '' }}</textarea>
                                </div>
                            </div>
                        </div> --}}

                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <h5 class="f-w-600 mb-2">Upload Audio file</h5>

                                    <div class="col-12">
                                        <input class="form-control" id="formFile" type="file"
                                            value="{{ isset($book) ? $book->urdu_audio : '' }}" name="urdu_audio">
                                    </div>
                                    <div id="audio-data">
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="text-end">
                                    <button class="btn btn-success me-3 submit-add-book"> {{ isset($book) ? 'Update' : 'Create' }}<i class="fa-solid fa-check"></i></button>

                                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>

                </div>
            </div>
            {{-- <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
          <button class="btn btn-primary" type="button">Save changes </button>
        </div> --}}
        </div>
    </div>
</div>



<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenter1"  aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered   modal-xl" role="document">

        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLongTitle">Expended Text</h3>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
            <div class="modal-body">
                <div class="modal-toggle-wrapper" id="modalText">

                </div>
            </div>

             <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
