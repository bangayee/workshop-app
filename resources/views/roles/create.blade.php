
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
                <li class="breadcrumb-item" aria-current="page">User</li>
                <li class="breadcrumb-item" aria-current="page">Add User</li>
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
          <h3>ADD ROLE</h3>
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
 
          <form action="{{ route('role.store') }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="name">Role</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
            </div>
              <div class="form-group">
                  <strong>Permissions:</strong>
                  <br>
                  @forelse ($permissions as $value => $label)
                      <div class="form-check form-check-inline">
                          <input class="form-check-input" type="checkbox"
                              name="selectedPermissions[]" value="{{ $value }}"
                              
                              id="customCheckinlh1">
                          <label class="form-check-label" for="customCheckinlh1">
                              {{ $label }} </label>
                      </div>
                  @empty
                      <p>No permissions found.</p>
                  @endforelse

          </div>
            
            <div class="d-flex justify-content-between">
              <a href="{{ route('role.index') }}" class="btn btn-secondary">Cancel</a>
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