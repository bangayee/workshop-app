
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
                <li class="breadcrumb-item" aria-current="page">Permission</li>
                <li class="breadcrumb-item" aria-current="page">Add Permission</li>
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
          <h3>EDIT PERMISSION</h3>
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
 
          <form action="{{ route('permission.update', $permission->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
    
            <div class="form-group">
                <label for="name">Permission Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $permission->name) }}" required>
            </div>
    
            <div class="form-group">
              <label for="guard_name">Guard Name</label>
              <input type="text" name="guard_name" id="guard_name" class="form-control" value="{{ old('guard_name', $permission->guard_name) }}" required>
            </div>

            <div class="d-flex justify-content-between">
              <a href="{{ route('permission.index') }}" class="btn btn-secondary">Cancel</a>
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
