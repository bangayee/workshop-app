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
                            <li class="breadcrumb-item" aria-current="page">Supplier</li>
                            <li class="breadcrumb-item" aria-current="page">Show Supplier</li>
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
                            <h3>SHOW SUPPLIER</h3>
                        </div>
                        <div class="card-body">


                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Company:</strong>
                                        <input type="text" name="company" placeholder="Company" class="form-control"
                                            value="{{ $supplier->company }}" disabled>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Name:</strong>
                                        <input type="text" name="name" placeholder="Name" class="form-control"
                                            value="{{ $supplier->name }}" disabled>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Phone number:</strong>
                                        <input type="text" name="phone_number" placeholder="Phone number" class="form-control"
                                            value="{{ $supplier->phone_number }}" disabled>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Email:</strong>
                                        <input type="text" name="email" placeholder="Email" class="form-control"
                                            value="{{ $supplier->email }}" disabled>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Address:</strong>
                                        <textarea class="form-control" id="address" name="address" rows="3" disabled>{{ $supplier->address }}</textarea>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Note:</strong>
                                        <textarea class="form-control" id="note" name="note" rows="3" disabled>{{ $supplier->note }}</textarea>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <a href="{{ route('supplier.index') }}" class="btn btn-secondary btn-sm mt-2 mb-3"> Back</a>
                                </div>
                            </div>


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
