
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
                <li class="breadcrumb-item" aria-current="page">Workflow</li>
                <li class="breadcrumb-item" aria-current="page">Add Workflow</li>
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
          <h3>EDIT WORKFLOW</h3>
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
 
          <form action="{{ route('workflow.update', $workflow->id) }}" method="POST" >
            @csrf
            @method('PATCH')
    
            <div class="form-group">
                <label for="name">Workflow status</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $workflow->name) }}" {{ $workflow->status == 'order' || $workflow->status == 'done' ? 'readonly' : '' }} required>   </div>
            <div class="form-group">
              <label for="order">Order number</label>
              <input type="number" class="form-control" id="order" name="order" placeholder="Number" value="{{ old('order', $workflow->order) }}">
            </div>
            
            <div class="form-group">
              <label for="category">Color Option</label>
              <div class="form-check mb-2">
                <input class="form-check-input input-primary" type="radio" name="color" value="primary" {{ old('color', $workflow->color) == 'primary' ? 'checked' : '' }}>
                <label class="badge bg-light-primary" for="customCheckc1">primary</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input input-secondary" type="radio" name="color" value="secondary" {{ old('color', $workflow->color) == 'secondary' ? 'checked' : '' }}>
                <label class="badge bg-light-secondary" for="customCheckc2">secondary</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input input-success" type="radio" name="color" value="success" {{ old('color', $workflow->color) == 'success' ? 'checked' : '' }}>
                <label class="badge bg-light-success" for="customCheckc3">success</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input input-danger" type="radio" name="color" value="danger" {{ old('color', $workflow->color) == 'danger' ? 'checked' : '' }}>
                <label class="badge bg-light-danger" for="customCheckc4">danger</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input input-warning" type="radio" name="color" value="warning" {{ old('color', $workflow->color) == 'warning' ? 'checked' : '' }}>
                <label class="badge bg-light-warning" for="customCheckc5">warning</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input input-info" type="radio" name="color" value="info" {{ old('color', $workflow->color) == 'info' ? 'checked' : '' }}>
                <label class="badge bg-light-info" for="customCheckc6">info</label>
              </div>
              <div class="form-check mb-0">
                <input class="form-check-input input-dark" type="radio" name="color" value="dark" {{ old('color', $workflow->color) == 'dark' ? 'checked' : '' }}>
                <label class="badge bg-light-dark" for="customCheckc7">dark</label>
              </div>
            </div>


            <div class="d-flex justify-content-between">
              <a href="{{ route('workflow.index') }}" class="btn btn-secondary">Cancel</a>
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
