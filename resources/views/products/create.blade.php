
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
                <li class="breadcrumb-item" aria-current="page">Add Product</li>
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
          <h3>ADD PRODUCT</h3>
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
 
          <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
            
            @csrf
            <div class="form-group">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
            </div>
            <div class="form-group">
              <label for="category">Category</label>
              <select class="form-select" id="category" name="category_id">
                <option value="" selected>Choose...</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="name">Price</label>
              <input type="number" class="form-control" id="price" name="price" placeholder="Enter price" >
            </div>
            <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
          </div>
          <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control" id="image" name="image" placeholder="Enter image">


          </div>
          <div class="d-flex justify-content-between">
            <a href="{{ route('product.index') }}" class="btn btn-secondary">Cancel</a>
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
<script>
    // [ dom table ]
    $('#dom-table').DataTable();

    // [ Javascript source table ]
    // var dataSet = [
    //     ['Tiger Nixon', 'System Architect', 'Edinburgh', '5421', '2011/04/25', '$320,800'],
    //     ['Garrett Winters', 'Accountant', 'Tokyo', '8422', '2011/07/25', '$170,750'],
    //     ['Ashton Cox', 'Junior Technical Author', 'San Francisco', '1562', '2009/01/12', '$86,000'],
    //     ['Cedric Kelly', 'Senior Javascript Developer', 'Edinburgh', '6224', '2012/03/29', '$433,060'],
    //     ['Airi Satou', 'Accountant', 'Tokyo', '5407', '2008/11/28', '$162,700'],
    //     ['Brielle Williamson', 'Integration Specialist', 'New York', '4804', '2012/12/02', '$372,000'],
    //     ['Herrod Chandler', 'Sales Assistant', 'San Francisco', '9608', '2012/08/06', '$137,500'],
    //     ['Rhona Davidson', 'Integration Specialist', 'Tokyo', '6200', '2010/10/14', '$327,900'],
    //     ['Colleen Hurst', 'Javascript Developer', 'San Francisco', '2360', '2009/09/15', '$205,500'],
    //     ['Sonya Frost', 'Software Engineer', 'Edinburgh', '1667', '2008/12/13', '$103,600'],
    //     ['Jena Gaines', 'Office Manager', 'London', '3814', '2008/12/19', '$90,560'],
    //     ['Quinn Flynn', 'Support Lead', 'Edinburgh', '9497', '2013/03/03', '$342,000'],
    //     ['Charde Marshall', 'Regional Director', 'San Francisco', '6741', '2008/10/16', '$470,600'],
    //     ['Haley Kennedy', 'Senior Marketing Designer', 'London', '3597', '2012/12/18', '$313,500'],
    //     ['Tatyana Fitzpatrick', 'Regional Director', 'London', '1965', '2010/03/17', '$385,750'],
    //     ['Michael Silva', 'Marketing Designer', 'London', '1581', '2012/11/27', '$198,500'],
    //     ['Paul Byrd', 'Chief Financial Officer (CFO)', 'New York', '3059', '2010/06/09', '$725,000'],
    //     ['Gloria Little', 'Systems Administrator', 'New York', '1721', '2009/04/10', '$237,500'],
    //     ['Bradley Greer', 'Software Engineer', 'London', '2558', '2012/10/13', '$132,000'],
    //     ['Dai Rios', 'Personnel Lead', 'Edinburgh', '2290', '2012/09/26', '$217,500']
    // ];

    // $('#jsource-table').DataTable({
    //     // data: dataSet,
    //     columns: [
    //     {
    //         title: 'Name'
    //     },
    //     {
    //         title: 'Position'
    //     },
    //     {
    //         title: 'Office'
    //     },
    //     {
    //         title: 'Extn.'
    //     },
    //     {
    //         title: 'Start date'
    //     },
    //     {
    //         title: 'Salary'
    //     }
    //     ]
    // });
</script>