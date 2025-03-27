<!-- [ Main Content ] start -->
<div class="pc-container">
    <div class="pc-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item" aria-current="page">Setting</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ sample-page ] start -->
            <div class="col-sm-12">
                <!-- HTML (DOM) Sourced Data table start -->
                <div class="col-sm-12">
                    <div class="card">

                        <div class="card-header">
                            <h3>SETTINGS</h3>
                        </div>
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('setting.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PATCH')

                                <div class="row">

                                    @for ($i = 0; $i < $settings->count(); $i++)
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>{{ $settings[$i]->setting_name }}:</strong>
            @if ($settings[$i]->type == 'image')
                <br>
                <img src="{{ asset('storage/uploads/setting_file/' . $settings[$i]->value) }}" alt="image" style="width: 100px; height: 100px;">
                <input type="file" name="setting_image[{{$settings[$i]->setting_name}}]" class="form-control">
            @else
                <input type="text" name="setting[{{$settings[$i]->setting_name}}]" placeholder="{{ $settings[$i]->setting_name }}" class="form-control"
                    value="{{ $settings[$i]->value }}">
            @endif
        </div>
    </div>
@endfor

                              
                                   
                                    
                                    <div class="d-flex justify-content-between">
                                        <a class="btn btn-secondary" href="{{ route('dashboard') }}">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </form>

                        </div>

                    </div>
                    <!-- HTML (DOM) Sourced Data table end -->


                </div>
                <!-- [ sample-page ] end -->
            </div>
            <!-- [ Main Content ] end -->
        </div>
    </div>
    <!-- [ Main Content ] end -->
