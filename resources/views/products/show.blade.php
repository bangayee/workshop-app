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
                            <li class="breadcrumb-item" aria-current="page">Product</li>
                            <li class="breadcrumb-item" aria-current="page">Show Product</li>
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
                            <h3>SHOW PRODUCT</h3>
                        </div>
                        <div class="card-body">


                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Name:</strong>
                                        <input type="text" name="name" placeholder="Name" class="form-control"
                                            value="{{ $product->name }}" disabled>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Price:</strong>
                                        <input type="text" name="price" placeholder="Price" class="form-control"
                                            value="{{ $product->price }}" disabled>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Category:</strong>
                                        <input type="text" name="category" placeholder="Category" class="form-control"
                                            value="{{ $product->category ? $product->category->name : 'No category available' }}" disabled>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Description:</strong>
                                        <textarea name="description" placeholder="Description" class="form-control" rows="3" disabled>{{ $product->description }}</textarea>
                                    </div>
                                </div>
                                
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <strong>Image:</strong>
                                        <br>
                                        @if($product->image)
                                            <img src="{{ asset('storage/uploads/products/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid" style="max-width: 200px;">
                                        @else
                                            <p>No image available</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                    <a href="{{ route('product.index') }}" class="btn btn-secondary btn-sm mt-2 mb-3"> Back</a>
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
