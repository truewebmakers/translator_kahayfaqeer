@if ($message = Session::get('success'))
    <div class="alert text-success border-success outline-2x alert-dismissible fade show alert-icons mb-0" role="alert">
        <i class="fa-regular fa-thumbs-up"></i>
        <p class="mb-0"><b>Well done! </b> {{ $message }}</p>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($error = Session::get('error'))
    <div class="alert text-danger border-danger outline-2x alert-dismissible fade show alert-icons" role="alert">
        <i class="fa-regular fa-thumbs-up"></i>
        <p class="mb-0"><b>Ahhh !! </b> {{ $error }}</p>
        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif


