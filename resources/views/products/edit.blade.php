
  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item" aria-current="page">Product</li>
                <li class="breadcrumb-item" aria-current="page">Add Product</li>
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
          <h3>EDIT PRODUCT</h3>
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
 
          <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
    
            <div class="form-group">
                <label for="name">Product Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
            </div>
    
            <div class="form-group">
              <label for="category_id">Category</label>
              <select name="category_id" id="category_id" class="form-control" required>
                  <option value="">-- Select Category --</option>
                  @foreach ($categories as $category)
                      <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                          {{ $category->name }}
                      </option>
                  @endforeach
              </select>
          </div>
    
            <div class="form-group">
              <label for="name">Price</label>
              <input type="text" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" required>
          </div>

            <div class="form-group">
              <label for="description">Description</label>
              <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="form-group">
              <label for="image">Image</label>
              <br>
              <img src="{{ asset('storage/uploads/products/'.$product->image) }}" alt="" style="width: 200px;">
              <br>
              <input type="file" name="image" id="image" class="form-control">
            </div>
    
            <div class="d-flex justify-content-between">
              <a href="{{ route('product.index') }}" class="btn btn-secondary">Cancel</a>
              <button type="submit" class="btn btn-primary">Update</button>
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
