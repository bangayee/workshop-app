
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
                <li class="breadcrumb-item" aria-current="page">Supplier</li>
                <li class="breadcrumb-item" aria-current="page">Add Supplier</li>
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
          <h3>EDIT SUPPLIER</h3>
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
 
          <form action="{{ route('supplier.update', $supplier->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
    
            <div class="form-group">
              <label for="company">Company</label>
              <input type="text" name="company" id="company" class="form-control" value="{{ old('company', $supplier->company) }}" required>
          </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $supplier->name) }}" required>
            </div>

            <div class="form-group">
              <label for="phone_number">Phone number</label>
              <input type="number" name="phone_number" id="phone_number" class="form-control" value="{{ old('phone_number', $supplier->phone_number) }}" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $supplier->email) }}" required>
        </div>
    
            <div class="form-group">
              <label for="address">Address</label>
              <textarea name="address" id="address" class="form-control" rows="5" required>{{ old('address', $supplier->address) }}</textarea>
            </div>
            <div class="form-group">
              <label for="note">Note</label>
              <textarea name="note" id="note" class="form-control" rows="5" required>{{ old('note', $supplier->note) }}</textarea>
            </div>
            
        

            <div class="d-flex justify-content-between">
              <a href="{{ route('supplier.index') }}" class="btn btn-secondary">Cancel</a>
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
