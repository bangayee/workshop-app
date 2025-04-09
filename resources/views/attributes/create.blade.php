
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
          <h3>ADD ATTRIBUTE</h3>
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
 
          <form action="{{ route('attribute.store') }}" method="POST" >
            
            @csrf
            <div class="form-group">
              <label for="name">Attribute </label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Enter attribute">
            </div>
            <div class="form-group">
              <label for="category">Type</label>
              <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="type" value="shorttext">
                <label for="customCheckc3">shorttext</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="type" value="text">
                <label for="customCheckc3">text</label>
              </div>
              <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="type" value="image">
                <label for="customCheckc3">image</label>
              </div>
            </div>

            <div class="form-group">
              <label for="note">Note</label>
              <input type="text" class="form-control" id="note" name="note" placeholder="Note">
            </div>
            
          <div class="d-flex justify-content-between">
            <a href="{{ route('attribute.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit</button>
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/dataTables.bootstrap5.min.js') }}"></script>