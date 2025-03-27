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
                            <li class="breadcrumb-item" aria-current="page">Role</li>
                            <li class="breadcrumb-item" aria-current="page">Add Role</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ sample-page ] start -->
            <div class="col-sm-12">
                <!-- HTML (DOM) Sourced Data table start -->
                <div class="col-sm-12">
                    <div class="card">

                        <div class="card-header">
                            <h3>EDIT ROLE</h3>
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

                            <form method="POST" action="{{ route('role.update', $role->id) }}">
                                @csrf
                                @method('PATCH')

                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Role:</strong>
                                            <input type="text" name="name" placeholder="Name" class="form-control"
                                                value="{{ $role->name }}" readonly>
                                        </div>
                                    </div>



                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <strong>Permissions:</strong>
                                            <br>
                                            @forelse ($permissions as $value => $label)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="selectedPermissions[]" value="{{ $value }}"
                                                        {{ isset($rolePermissions[$value]) ? 'checked' : '' }}
                                                        id="customCheckinlh1">
                                                    <label class="form-check-label" for="customCheckinlh1">
                                                        {{ $label }} </label>
                                                </div>
                                            @empty
                                                <p>No permissions found.</p>
                                            @endforelse

                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                      <a href="{{ route('role.index') }}" class="btn btn-secondary">Cancel</a>
                                      <button type="submit" class="btn btn-primary">Submit</button>
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
