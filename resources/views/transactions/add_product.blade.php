<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
  $(document).ready(function() {
    if (typeof $.fn.select2 === 'function') {
      // Initialize Select2 for selectProduct
      $('.selectProduct').select2({
        placeholder: "Choose a product...",
        allowClear: true
      });

      // Initialize Select2 for selectSupplier
      $('.selectSupplier').select2({
        placeholder: "Choose a supplier...",
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
                <li class="breadcrumb-item" aria-current="page">Add Product Transaction</li>
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
          <h3>ADD PRODUCT TRANSACTION</h3>
        </div>
        <div class="card-body">
          
            <div class="form-group">
              <label for="transaction_number">Transaction Number</label>
              <input type="text" class="form-control"  value="{{$transaction->transaction_number}}" readonly>
            </div>
            <div class="form-group">
              <label >Customer Name</label>
              <input type="text" class="form-control"  value="{{$transaction->customer->name}}" readonly>
            </div>
        
      </div>
      <hr>

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
        <form action="{{ route('transaction.store_product') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="transaction_id" value="{{$transaction->id}}">
          <div class="form-group">
            <label class="badge bg-light-primary">Select product</label><br><br>
            <div class="form-group" >
              <label>Select Product</label>
              <select class="form-select selectProduct" id="product" name="product_id" style="width: 100%;" data-placeholder="Choose a product...">
                <option value="" disabled selected>Choose a product...</option>
                @foreach ($products as $product)
                  <option value="{{ $product->id }}" data-price="{{ $product->price }}">{{ $product->name }}</option>
                @endforeach
              </select>
              </div>
              <div class="form-group" >
                <label>Unit Price</label>
                <input type="number" class="form-control" id="unit_price" name="unit_price" >
                </div>
              <div class="form-group" >
                <label>Quantity</label>
                <input type="number" class="form-control" id="quantity" name="quantity" >
                </div>
          </div>
          <hr>
          <div id="attributes">
            <div class="form-group">
              <label class="badge bg-light-primary">Custom Attributes (optional)</label>
              <div id="attribute-container">
                @forelse ($attributes as $item)
                  <div class="form-group attribute-item" data-attribute-id="{{ $item->id }}">
                    <label>{{ $item->name }}</label>
                    @if ($item->type == 'image')
                      <input type="file" class="form-control" name="attribute[{{ $item->id }}]" placeholder="{{ $item->name }}">
                    @elseif ($item->type == 'text')
                      <textarea class="form-control" name="attribute[{{ $item->id }}]" rows="3"></textarea>
                    @else
                      <input type="text" class="form-control" name="attribute[{{ $item->id }}]" placeholder="{{ $item->name }}">
                    @endif
                  </div>
                @empty
                  <p>No Data Available</p>
                @endforelse
              </div>
            </div>
          </div>
          
          <hr>
          <div class="form-group">
            <label class="badge bg-light-primary">Suppliers (optional)</label><br><br>
            <div class="form-group">
              <select class="form-group form-select selectSupplier" id="supplier" name="supplier_id[]" style="width: 100%;" multiple>
                @foreach ($suppliers as $supplier)
                  <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="d-flex justify-content-between">
            <a href="{{ route('transaction.index') }}" class="btn btn-secondary">Cancel</a>
            <div class="d-flex justify-content-end">
              
              <button type="submit" name="submit_button" value="add_another" class="btn btn-success me-2">Add Another Product</button>
              <button type="submit" name="submit_button" value="save" class="btn btn-primary">Save</button>
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

  <script>
    $(document).ready(function() {
      // Initialize Select2 for selectProduct
      if (typeof $.fn.select2 === 'function') {
        $('.selectProduct').select2({
          placeholder: "Choose a product...",
          allowClear: true
        });
      }
  
      // Update unit_price when a product is selected
      $('#product').on('change', function() {
        // Get the selected option's data-price attribute
        const selectedPrice = $(this).find(':selected').data('price');
        
        // Set the value of the unit_price input
        $('#unit_price').val(selectedPrice || '');
      });
    });
  </script>