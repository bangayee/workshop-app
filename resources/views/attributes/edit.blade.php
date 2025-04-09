
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
                <li class="breadcrumb-item" aria-current="page">Attribute</li>
                <li class="breadcrumb-item" aria-current="page">Add Attribute</li>
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
          <h3>EDIT ATTRIBUTE</h3>
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
 
          <form action="{{ route('attribute.update', $attribute->id) }}" method="POST" >
            @csrf
            @method('PATCH')
    
            <div class="form-group">
                <label for="name">Attribute</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $attribute->name) }}" required>
            </div>
            <div class="form-group">
              <label for="category">Type</label>
              <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="type" value="shorttext" {{ old('type', $attribute->type) == 'shorttext' ? 'checked' : '' }}>
                <label for="customCheckc3">shorttext</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="type" value="text" {{ old('type', $attribute->type) == 'text' ? 'checked' : '' }}>
                <label for="customCheckc3">text</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="type" value="image" {{ old('type', $attribute->type) == 'image' ? 'checked' : '' }}>
                <label for="customCheckc3">image</label>
              </div>
            </div>
            <div class="form-group">
              <label for="note">Note</label>
              <input type="text" class="form-control" id="note" name="note" placeholder="Note" value="{{ old('note', $attribute->note) }}">
            </div>
            
            <div class="d-flex justify-content-between">
              <a href="{{ route('attribute.index') }}" class="btn btn-secondary">Cancel</a>
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
