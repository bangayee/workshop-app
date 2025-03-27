
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
                <li class="breadcrumb-item" aria-current="page">Product</li>
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
        <h3>PRODUCTS</h3>
        <small>
          </small
        >
      </div>
      <div class="card-body">
        <div class="dt-responsive table-responsive">
            <div class="text-end p-4 pb-0">
                <a href="{{route('product.create')}}" class="btn btn-primary">
                  <i class="ti ti-plus f-18"></i> Add Product
                </a>
              </div>
          <table id="dom-table" class="table table-striped table-bordered nowrap">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody></tbody>

            {{-- <thead>
              <tr>
                <th>#</th>
                <th>Name</th>
                <th>Category</th>
                <th>Description</th>
              </tr>
            </thead> --}}
            {{-- <tbody>
                @php
                    $i = 1;
                @endphp
                @forelse ($products as $item)
                <tr>
                    <td>{{ $i }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category->name}}</td>
                    <td>{{$item->description}}</td>
                </tr>
                @php
                    $i++;
                @endphp
                @empty
                    <p> Data tidak ditemukan</p>
                @endforelse

                
          
            </tbody> --}}
            
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

{{-- <script type="text/javascript">
    $(function () {
      var table = $('#dom-table').DataTable({
          processing: true,
          serverSide: true,
          pageLength: 10,
          ajax: "{{ route('product.index') }}",
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
            {data: 'name', name: 'name'},   {data: 'category', name: 'category'},
              {data: 'description', name: 'description'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });
    });
  </script> --}}


  <script type="text/javascript">
    $(function () {
        var table = $('#dom-table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            ajax: "{{ route('product.index') }}",
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
                {data: 'name', name: 'name'},
                {data: 'category', name: 'category'},
                {data: 'price', name: 'price'},
                {
                    data: 'image',
                    name: 'image',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });
</script>