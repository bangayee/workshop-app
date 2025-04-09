{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

  <!-- [ Main Content ] start -->
  <div class="pc-container">
    <div class="pc-content">
      <!-- [ breadcrumb ] start -->
      <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <div class="page-header-title">
                <h3 class="m-b-10">DASHBOARD</h3>
              </div>
              
            </div>
          </div>
        </div>
      </div>
      <!-- [ breadcrumb ] end -->
      <!-- [ Main Content ] start -->
      <div class="row">
        <!-- [ sample-page ] start -->
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body bg-light-primary">
              <h6 class="mb-2 f-w-400 text-muted">Total Transactions</h6>
              <h4 class="mb-3">{{$data['total_order']}} </h4>
              <p class="mb-0 text-muted text-sm">Remaining <span class="text-primary">{{$data['remaining_order']}} </span> orders
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body bg-light-success">
              <h6 class="mb-2 f-w-400 text-muted">Product Order</h6>
              <h4 class="mb-3">{{$data['total_product']}} </h4>
              <p class="mb-0 text-muted text-sm">Remaining <span class="text-success">{{$data['remaining_product']}}</span> items</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body bg-light-warning">
              <h6 class="mb-2 f-w-400 text-muted">Total Customers</h6>
              <h4 class="mb-3">{{$data['total_customer']}}</h4>
              <p class="mb-0 text-muted text-sm">Orders from <span class="text-warning">{{$data['total_cities']}}</span> cities</p>
            </div>
          </div>
        </div>
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body bg-light-danger">
              <h6 class="mb-2 f-w-400 text-muted">Total Sales</h6>
              <h4 class="mb-3">{{$data['total_sales']}}</h4>
              <p class="mb-0 text-muted text-sm">Remaining payment <span class="text-danger">{{$data['remaining_payment']}}</span> 
              </p>
            </div>
          </div>
        </div>

        <div class="col-md-12 col-xl-8">
          <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="mb-0">Transaction</h5>
            <ul class="nav nav-pills justify-content-end mb-0" id="chart-tab-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="chart-tab-home-tab" data-bs-toggle="pill" data-bs-target="#chart-tab-home"
                  type="button" role="tab" aria-controls="chart-tab-home" aria-selected="true">Month</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="chart-tab-profile-tab" data-bs-toggle="pill"
                  data-bs-target="#chart-tab-profile" type="button" role="tab" aria-controls="chart-tab-profile"
                  aria-selected="false">Week</button>
              </li>
            </ul>
          </div>
          <div class="card">
            <div class="card-body">
              <div class="tab-content" id="chart-tab-tabContent">
                <div class="tab-pane" id="chart-tab-home" role="tabpanel" aria-labelledby="chart-tab-home-tab" tabindex="0">
                  <div id="visitor-chart-1"></div>
              </div>
              <div class="tab-pane show active" id="chart-tab-profile" role="tabpanel" aria-labelledby="chart-tab-profile-tab" tabindex="0">
                <div id="visitor-chart"></div>
            </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12 col-xl-4">
          <h5 class="mb-3">Remaining Order</h5>
          <div class="card">
              <div class="card-body">
                  <div id="order-status-pie-chart"></div>
              </div>
          </div>
      
      </div>

        

        <div class="col-md-12 col-xl-8">
          <h5 class="mb-3">Old Transactions</h5>
          <div class="card tbl-card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover table-borderless mb-0">
                    <thead>
                        <tr>
                            <th>TRX ID</th>
                            <th>CUSTOMER</th>
                            <th>TOTAL PRODUCT</th>
                            <th>STATUS</th>
                            <th class="text-end">GRAND TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data['oldTransactions'] as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('transaction.show', $item->id) }}" class="text-muted">
                                        {{ $item->transaction_number }}
                                    </a>
                                </td>
                                <td>{{ $item->customer->name }}</td>
                                <td>{{ $item->total_quantity }}</td>
                                <td>
                                    <span class="d-flex align-items-center gap-2">
                                        <i class="fas fa-circle text-{{ $item->workflow->color }} f-10 m-r-5"></i>
                                        {{ $item->workflow->name }}
                                    </span>
                                </td>
                                <td class="text-end">{{ number_format($item->grand_total, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">No data available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Links -->
            <div class="mt-3">
                {{ $data['oldTransactions']->links('pagination::bootstrap-5') }}
            </div>
            </div>
          </div>
        </div>
        
        <div class="col-md-12 col-xl-4">
          <h5 class="mb-3">Pending Order in Suppliers</h5>
          <div class="card">
            <div class="list-group list-group-flush">
              
              @forelse ($data['order_in_suppliers'] as $item)
              <a href="{{route('order_supplier.index')}}" class="list-group-item list-group-item-action">
                <div class="d-flex">
                  <div class="flex-shrink-0">
                    <div class="avtar avtar-s rounded-circle text-success bg-light-success">
                      <i class="ti ti-man f-18"></i>
                    </div>
                  </div>
                  <div class="flex-grow-1 ms-3">
                    <h6 class="mb-1">{{$item->supplier->company}}</h6>
                    <p class="mb-0 text-muted">{{$item->supplier->name}}</P>
                  </div>
                  <div class="flex-shrink-0 text-end">
                    <h6 class="mb-1">{{$item->count}} items</h6>
                    <p class="mb-0 text-muted"> </P>
                  </div>
                </div>
              </a>
              @empty
                  <p>No data available</p>
              @endforelse
              


            </div>
          </div>
        </div>

        
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->

    <!-- [Page Specific JS] start -->
    {{-- <script src="{{asset('assets/js/plugins/apexcharts.min.js')}}"></script> --}}
    {{-- <script src="{{asset('assets/js/pages/dashboard-default.js')}}"></script> --}}
    <!-- [Page Specific JS] end -->

    <script>
      const monthlyTransactions = @json($data['monthlyTransactions']);
      // const weeklyTransactions = @json($data['weeklyTransactions']);
      const dailyTransactions = @json($data['dailyTransactions']);
      const orderStatusData = @json($data['orderStatusData']);
  </script>

<script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Prepare data for the monthly chart
        const monthlyLabels = monthlyTransactions.map(item => {
            const monthNames = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            return monthNames[item.month - 1];
        });
        const monthlyData = monthlyTransactions.map(item => item.count);
        const productDataMonthly = monthlyTransactions.map(item => item.total_products);

        // Render the monthly chart
        const monthlyChartOptions = {
            chart: {
                type: 'area',
                toolbar: 'false',
                height: 350
            },
            series: [{
                name: 'Transactions',
                data: monthlyData
            },
            {
                    name: 'Total Products',
                    data: productDataMonthly
                }],
            xaxis: {
                categories: monthlyLabels
            }
        };
        const monthlyChart = new ApexCharts(document.querySelector("#visitor-chart-1"), monthlyChartOptions);
        monthlyChart.render();

        // Prepare data for the weekly chart
        // const weeklyLabels = weeklyTransactions.map(item => `Week ${item.week}`);
        // const weeklyData = weeklyTransactions.map(item => item.count);

        // // Render the weekly chart
        // const weeklyChartOptions = {
        //     chart: {
        //         type: 'line',
        //         height: 350
        //     },
        //     series: [{
        //         name: 'Transactions',
        //         data: weeklyData
        //     }],
        //     xaxis: {
        //         categories: weeklyLabels
        //     }
        // };
        // const weeklyChart = new ApexCharts(document.querySelector("#visitor-chart"), weeklyChartOptions);
        // weeklyChart.render();

        const dailyLabels = [];
        const dailyData = [];
        const productData = [];
        const startDate = new Date(dailyTransactions[0].date);
        const endDate = new Date(dailyTransactions[dailyTransactions.length - 1].date);

        for (let date = new Date(startDate); date <= endDate; date.setDate(date.getDate() + 1)) {
            const formattedDate = date.toISOString().split('T')[0];
            dailyLabels.push(formattedDate);

            const transaction = dailyTransactions.find(item => item.date === formattedDate);
            dailyData.push(transaction ? transaction.count : 0);
            productData.push(transaction ? transaction.total_products : 0);
        }
        // const dailyData = dailyTransactions.map(item => item.count);

        // Render the daily chart
        const dailyChartOptions = {
            chart: {
                type: 'area',
                toolbar: 'false',
                height: 350
            },
            series: [{
                name: 'Transactions',
                data: dailyData
            },
                {
                    name: 'Total Products',
                    data: productData
                }],
            xaxis: {
                categories: dailyLabels,
                labels: {
                    format: 'yyyy-MM-dd' // Format the date labels
                }
            }
        };
        const dailyChart = new ApexCharts(document.querySelector("#visitor-chart"), dailyChartOptions);
        dailyChart.render();
    });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
      // Prepare data for the pie chart
      const orderStatusLabels = orderStatusData.map(item => item.workflow_name); // Use workflow_name for labels
      const orderStatusCounts = orderStatusData.map(item => item.count);

      // Render the pie chart
      const pieChartOptions = {
          chart: {
              type: 'pie',
              toolbar: 'false',
              height: 350
          },
          series: orderStatusCounts,
          labels: orderStatusLabels, // Set labels to workflow names
          legend: {
              position: 'bottom'
          },
          tooltip: {
              y: {
                  formatter: function (val) {
                      return `${val} transactions`;
                  }
              }
          }
      };

      const pieChart = new ApexCharts(document.querySelector("#order-status-pie-chart"), pieChartOptions);
      pieChart.render();
  });
</script>