<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
  $(document).ready(function() {
    // Ensure Select2 is loaded before initializing
    if (typeof $.fn.select2 === 'function') {
      $('.select2').select2({
        placeholder: "Choose...",
        allowClear: true
      });
    } else {
      console.error("Select2 is not loaded properly. Please check the script order or CDN links.");
    }
  });
</script>

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
                <li class="breadcrumb-item" aria-current="page">Transaction</li>
                <li class="breadcrumb-item" aria-current="page">Add Transaction</li>
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
          <h3>ADD TRANSACTION</h3>
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
 
          <form action="{{ route('transaction.store') }}" method="POST" enctype="multipart/form-data">
            
            @csrf
            <div class="form-group">
              <label for="transaction_number">Transaction Number</label>
              <input type="text" class="form-control" value="{generated_by_system}" readonly>
            </div>
            <div class="form-group">
              <label for="transaction_number">Order Date</label>
              <input type="date" class="form-control" name="order_date" value="{{ date('d-m-Y') }}">
            </div>
            <div class="form-group">
              <label for="customer">Customer Name</label>
              <select class="form-select select2" id="customer" name="customer_id" style="width: 100%;">
                <option value="" selected>Choose...</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }} </option>
                @endforeach
              </select>
            </div>
            

            
          <div class="d-flex justify-content-between">
            <a href="{{ route('transaction.index') }}" class="btn btn-secondary">Cancel</a>
            <div class="d-flex justify-content-end">
              <button type="submit" name="submit_button" value="save" class="btn btn-primary me-2">Save</button>
              <button type="submit" name="submit_button" value="next" class="btn btn-success">Add Product</button>
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
