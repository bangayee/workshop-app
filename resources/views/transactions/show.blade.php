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
                <li class="breadcrumb-item" aria-current="page">Show Transaction</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      @if (session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
  @endif

  @if (session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
          {{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
  @endif
      <!-- [ Main Content ] start -->
      <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-sm-12">
<!-- HTML (DOM) Sourced Data table start -->
<div class="col-sm-12">
    <div class="card">
      
        <div class="card-header">
          <h3>SHOW TRANSACTION</h3>
        </div>
        <div class="card-body">
            <div class="row">
            <div class="col-sm-6">
            <div class="form-group">
              <label for="transaction_number">Transaction Number</label>
              <input type="text" class="form-control"  value="{{$transaction->transaction_number}}" readonly>
            </div>
            <div class="form-group">
              <label >Customer Name</label>
              <input type="text" class="form-control"  value="{{$transaction->customer->name}}" readonly>
            </div>
            <div class="form-group">
                <label >Order Date</label>
                <input type="text" class="form-control"  value="{{date_format(date_create($transaction->order_date), 'd-m-Y') }}" readonly>
            </div>
            <div class="form-group">
                <label >Order Status </label>
                <input type="text" class="form-control"  value="{{$transaction->workflow->name}}" readonly>
            </div>
            <div class="form-group">
                <label >Payment Status</label>
                <input type="text" class="form-control"  value="{{$transaction->payment_status}}" readonly>
            </div>
            <div class="form-group">
                <label >Quantity</label>
                <input type="text" class="form-control"  value="{{$transaction->total_quantity}}" readonly>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label >Total Price</label>
                <input type="text" class="form-control"  value="{{number_format($transaction->total_price, 0, ",", ".")}}" readonly>
            </div>
            <div class="form-group">
                <label >Shipping Cost</label>
                <input type="text" class="form-control"  value="{{number_format($transaction->shipping_cost, 0, ",", ".")}}" readonly>
            </div>
            <div class="form-group">
                <label >Discount</label>
                <input type="text" class="form-control"  value="{{number_format($transaction->total_discount, 0, ",", ".") }}" readonly>
            </div>
            <div class="form-group"> 
                <label >Grand Total</label>
                <input type="text" class="form-control"  value="{{number_format($transaction->grand_total, 0, ",", ".") }}" readonly>
            </div>
            <div class="form-group">
                <label >Remaining Payment</label>
                <input type="text" class="form-control"  value="{{number_format($transaction->remaining_balance, 0, ",", ".") }}" readonly>
            </div>
        </div>
            </div>
      </div>
      <hr>

      <div class="card-body">
        <span><span class="lead m-t-0"><b>DETAIL PRODUCTS</b></span></span>
        <br><br>
        @php
            $i = 1;   
        @endphp
       @forelse ($transaction_products as $item)
            <div class="form-group">
                <label class="badge bg-light-primary">{{$i}}. {{$item->product->name}}</label><br>
                
              


                <br>
                <div class="form-group" >
                    <label>Quantity</label>
                    <input type="number" class="form-control" value="{{$item->quantity}}" name="quantity" readonly>
                </div>
                <div class="form-group" >
                    <label>Unit Price</label>
                    <input type="text" class="form-control" value="{{number_format($item->unit_price, 0, ",", ".") }}" name="unit_price" readonly>
                </div>
                <div class="form-group" >
                    <label>Total Amount</label>
                    <input type="text" class="form-control" value="{{number_format($item->total_amount, 0, ",", ".") }}" name="total_amount" readonly>
                </div>
            </div>
            <span class="lead m-t-0"><b>Detail Custom Product</b></span>
            <br>
                @forelse ($item->product_transaction as $productTransaction)
                    <div class="form-group">
                        <label>{{$productTransaction->attribute->name}}</label>
                            @if ($productTransaction->attribute->type == 'image')
                                <br><img src="{{ asset('storage/uploads/product_details/' . $productTransaction->attribute_value) }}" class="img-fluid" style="max-width: 500px;">
                            @elseif($productTransaction->attribute->type == 'text')
                                <textarea class="form-control"  rows="3" readonly>{{ $productTransaction->attribute_value }}</textarea>
                            @else
                                <input type="text" class="form-control" value="{{ $productTransaction->attribute_value }}" readonly>
                            @endif
                        
                    </div>
                @empty
                    <p><i>Data custom product not available</i></p>
                @endforelse

                <span class="lead m-t-0"><b>Suppliers</b></span>
                <br> 
                @forelse ($item->product_transaction_supplier as $productTransactionSupplier)
                    <div class="form-group">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-3 col-sm-12 text-lg-end">{{$productTransactionSupplier->supplier->company}} ({{$productTransactionSupplier->supplier->name}})</label>
                            <div class="col-lg-6 col-md-6">
                              <input type="text" class="form-control" value="{{ $productTransactionSupplier->workflow->name }}" readonly>
                            </div>
                          </div>

                       
                    </div>
                @empty
                     <p><i>Data supplier not available</i></p>
                @endforelse


            <hr>
            @php
                $i++;   
            @endphp
       @empty
           <p><i>Data product not available</i> </p>
       @endforelse
        
          
      
   
       
      
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

