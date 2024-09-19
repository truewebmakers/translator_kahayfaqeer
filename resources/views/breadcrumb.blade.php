@php
    use App\Helpers\Breadcrumb;
    $breadcrumbs = Breadcrumb::generate();
@endphp
<div class="container-fluid">
    <div class="page-title">
        <div class="row">
            {{-- <div class="col-sm-6 col-12">
                <h2>Default Dashboard</h2>
                <p class="mb-0 text-title-gray">Welcome back! Let’s start from where you left.</p>
            </div> --}}
            <div class="col-sm-12 col-12">
                <ol class="breadcrumb">
                    @foreach ($breadcrumbs as $breadcrumb)
                        <li class="breadcrumb-item">
                            <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </div>
</div>
