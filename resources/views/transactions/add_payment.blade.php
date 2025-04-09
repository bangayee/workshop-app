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
          <h3>ADD PAYMENT</h3>
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
        <span><span class="lead m-t-0"><b>Payments</b></span>
        <br><br>
        <div class="form-group">
          <label class="badge bg-light-primary">Add Payment</label><br>
          <form action="{{ route('transaction.store_payment') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="transaction_id" value="{{$transaction->id}}">

            <div class="row">

              <div class="col-md-6">
                  <div class="form-group" >
                    <label>Payment Date</label>
                    <input type="date" class="form-control" id="payment_date" name="payment_date" value="{{date('d-m-Y')}}">
                    </div>
                  <div class="form-group" >
                    <label>Amount</label>
                    <input type="number" class="form-control" id="amount" name="amount" >
                    </div>
                    <div class="form-group" >
                      <label>Payment Method</label>
                      <select class="form-select" id="payment_method" name="payment_method">
                        <option value="" selected>Choose...</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Credit Card">Credit Card</option>
                        <option value="Cash">Cash</option>
                        <option value="E-Wallet">E-Wallet</option>
                        <option value="Other">Other</option>
                      </select>
                      </div>
              </div>

              <div class="col-md-6">
                
                  <div class="form-group" >
                    <label>Type</label>
                    <select class="form-select" id="payment_type" name="payment_type">
                      <option value="" selected>Choose...</option>

                        @forelse ($payment_terms as $item)
                          <option value="{{$item->id}}">{{$item->note}}</option>
                        @empty
                          <option value="" selected>-</option>
                        @endforelse
                    </select>
                  </div>
                  <div class="form-group" >
                    <label>Image</label>
                    <input type="file" class="form-control" id="image" name="image" >
                  </div>
                    
              </div>

            </div>

            <div class="d-flex justify-content-between">
              <span></span>
              <div class="d-flex justify-content-end">
                <button type="submit" name="submit_button" value="save" class="btn btn-primary">Save</button>
              </div>
            </div>
          </form>
        </div>

        <hr /><br />

        <div class="form-group">
          <label class="badge bg-light-primary">Payments</label><br>
          

          <div class="card-body">
            <div class="dt-responsive table-responsive">
              <table id="dom-table" class="table table-striped table-bordered nowrap">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Payment Date</th>
                        <th>Method</th>
                        <th>Type </th>
                        <th>Image </th>
                        <th>Amount</th>
                        <th width="100px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($payments as $item)
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{date('d-m-Y', strtotime($item->payment_date))}}</td>
                        <td>{{$item->payment_method}}</td>
                        {{-- <td>{{$item->payment_type}}</td> --}}
                        <td>{{$item->payment_terms->note}}</td>
                        <td>
                          @if ($item->image && file_exists(public_path('storage/uploads/transactions/'.$item->image)))
                            <a href="{{ asset('storage/uploads/transactions/'.$item->image) }}" target="_blank" data-bs-toggle="modal" data-bs-target="#imageModal{{$item->id}}">
                            <img src="{{ asset('storage/uploads/transactions/'.$item->image) }}" alt="Image" width="50" height="50">
                            </a>

                            <!-- Modal -->
                            <div class="modal fade" id="imageModal{{$item->id}}" tabindex="-1" aria-labelledby="imageModalLabel{{$item->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel{{$item->id}}">Payment Image</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body text-center">
                                <img src="{{ asset('storage/uploads/transactions/'.$item->image) }}" alt="Image" class="img-fluid">
                              </div>
                              </div>
                            </div>
                            </div>
                          @else
                          <span class="text-muted">No Image</span>
                          @endif
                        </td>
                        <td style="text-align: right;">{{ number_format($item->amount,0,",",".") }}</td>
                        <td>
                          <form action="{{ route('transaction.delete_payment', [$item->transaction_id, $item->id]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this payment?')">Delete</button>
                          </form>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="7" class="text-center">No Data Available</td>
                      </tr>
                    @endforelse
                    @if ($payments->count() > 0)
                      <tr>
                        <td colspan="5" class="text-end"><strong>Paid Amount:</strong></td>
                        <td style="text-align: right;"><strong>{{ number_format($payments->sum('amount'),0,",",".") }}</strong></td>
                        <td></td>
                      </tr>
                    @endif
                    @if ($payments->count() > 0)
                      <tr>
                        <td colspan="5" class="text-end"><strong>Grand Total:</strong></td>
                        <td style="text-align: right;"><strong>{{number_format($transaction->grand_total,0,",",".") }}</strong></td>
                        <td></td>
                      </tr>
                    @endif
                    
                    @if ($payments->count() > 0)
                      <tr>
                        <td colspan="5" class="text-end"><strong>Remaining Payment:</strong></td>
                        <td style="text-align: right;"><strong>{{ number_format($transaction->remaining_balance,0,",",".") }}</strong></td>
                        <td></td>
                      </tr>
                    @endif
                    
                    @if ($payments->count() > 0)
                      <tr>
                        <td colspan="5" class="text-end"><strong>Payment Status:</strong></td>
                        <td style="text-align: center;"><strong>{{$transaction->payment_status  }}</strong></td>
                        <td></td>
                      </tr>
                    @endif
                    

                </tbody>
                
              </table>
            </div>
          </div>
      </div>
     
          
      
   
       
      
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

