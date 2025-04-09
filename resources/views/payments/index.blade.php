
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
                <li class="breadcrumb-item" aria-current="page">Payment</li>
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
        <h3>PAYMENTS</h3>
        <small>
          </small
        >
      </div>
      <div class="card-body">
        <div class="dt-responsive table-responsive">
          <table id="dom-table" class="table table-striped table-bordered nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>TRX ID</th>
                    <th>Payment date</th>
                    <th>Customer</th>
                    <th>Image</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody></tbody>
          </table>
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

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/dataTables.bootstrap5.min.js') }}"></script>

  <script type="text/javascript">
    $(function () {
        var table = $('#dom-table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            ajax: "{{ route('payment.index') }}",
            dom: '<"d-flex justify-content-between"lf>t<"d-flex justify-content-center"p>',
            columns: [
                {
                    data: null,
                    name: 'row_number',
                    render: function (data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    },
                    orderable: false,
                    searchable: false
                },
                {data: 'transaction_number', name: 'transaction_number'},
                {data: 'payment_date', name: 'payment_date'},
                {data: 'customer', name: 'customer'},
                {data: 'image', name: 'image'},
                {data: 'amount', name: 'amount'},
            ]
        });
    });
</script>



<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="imageModalLabel">Payment Image</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
        <img id="modalImage" src="" alt="Payment Image" class="img-fluid">
      </div>
    </div>
  </div>
</div>

<script>
  $(document).on('click', '.image-link', function (e) {
      e.preventDefault();
      const imageUrl = $(this).data('image');
      $('#modalImage').attr('src', imageUrl);
  });
</script>