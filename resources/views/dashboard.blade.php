@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('js_after')
<script src="{{ asset('js/plugins/chart.js/Chart.bundle.min.js') }}"></script>
@endsection

@section('hero')
<div class="bg-image overflow-hidden" style="background-image: url('media/photos/photo3@2x.jpg');">
  <div class="bg-primary-dark-op">
    <div class="content content-narrow content-full">
      <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center mt-5 mb-2 text-center text-sm-left">
        <div class="flex-sm-fill">
          <h1 class="font-w600 text-white mb-0 invisible" data-toggle="appear">Dashboard</h1>
          <h2 class="h4 font-w400 text-white-75 mb-0 invisible" data-toggle="appear" data-timeout="250">Welcome {{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h2>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')

@hasanyrole('Admin|Asset Manager|IT Support')
<!-- Stats -->
<div class="row">
  <div class="col-6 col-md-3 col-lg-6 col-xl-3">
    <a class="block block-rounded block-link-pop border-left border-primary border-4x" href="{{ route('machines.index') }}">
      <div class="block-content block-content-full">
        <div class="font-size-sm font-w600 text-uppercase text-muted">Machines</div>
        <div class="font-size-h2 font-w400 text-dark">{{ $machinesCount }}</div>
      </div>
    </a>
  </div>
  <div class="col-6 col-md-3 col-lg-6 col-xl-3">
    <a class="block block-rounded block-link-pop border-left border-primary border-4x" href="{{ route('licenses.index') }}">
      <div class="block-content block-content-full">
        <div class="font-size-sm font-w600 text-uppercase text-muted">Licenses</div>
        <div class="font-size-h2 font-w400 text-dark">{{ $licensesCount + $installsCount }}</div>
      </div>
    </a>
  </div>
  <div class="col-6 col-md-3 col-lg-6 col-xl-3">
    <a class="block block-rounded block-link-pop border-left border-primary border-4x" href="javascript:void(0)">
      <div class="block-content block-content-full">
        <div class="font-size-sm font-w600 text-uppercase text-muted">Checkouts</div>
        <div class="font-size-h2 font-w400 text-dark">{{ $checkoutsCount }}</div>
      </div>
    </a>
  </div>
  <div class="col-6 col-md-3 col-lg-6 col-xl-3">
    <a class="block block-rounded block-link-pop border-left border-primary border-4x" href="javascript:void(0)">
      <div class="block-content block-content-full">
        <div class="font-size-sm font-w600 text-uppercase text-muted">Installs</div>
        <div class="font-size-h2 font-w400 text-dark">{{ $installsCount }}</div>
      </div>
    </a>
  </div>
</div>
<div class="row">
  <div class="col-xl-6">
    <!-- Donut Chart -->
    <div class="block">
      <div class="block-header">
        <h3 class="block-title">Machine Types</h3>
      </div>
      <div class="block-content block-content-full text-center">
        <div class="py-3">
          <!-- Donut Chart Container -->
          <canvas class="js-chartjs-machine-types"></canvas>
        </div>
      </div>
    </div>
    <!-- END Donut Chart -->
  </div>

  <div class="col-xl-6">
    <!-- Donut Chart -->
    <div class="block">
      <div class="block-header">
        <h3 class="block-title">Software Types</h3>
      </div>
      <div class="block-content block-content-full text-center">
        <div class="py-3">
          <!-- Donut Chart Container -->
          <canvas class="js-chartjs-software-types"></canvas>
        </div>
      </div>
    </div>
    <!-- END Donut Chart -->
  </div>
</div>
<!-- END Stats -->
@endhasanyrole

@role('User')
<div class="block">
  <div class="block-header block-header-default">
    <h3 class="block-title">Machines</h3>
  </div>
  <div class="block-content">

    <div class="table-responsive">
      <table class="table table-bordered table-striped table-vcenter">
        <thead>
          <tr>
            <th>#</th>
            <th>Machine Tag</th>
            <th>Name</th>
          </tr>
        </thead>
        <tbody>
          @forelse($machines as $index => $machine)
          <tr>
            <td>{{ ++$index }}</td>
            <td>{{ $machine->checkable->machine_tag }}</td>
            <td>{{ $machine->checkable->name }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="3" class="text-center">No machines to show</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endrole

@endsection

@hasanyrole('Admin|Asset Manager|IT Support')
@push('scripts')
<script>
  jQuery.ajaxSetup({
    async: false
  });

  let dynamicColors = function() {
    let r = Math.floor(Math.random() * 255);
    let g = Math.floor(Math.random() * 255);
    let b = Math.floor(Math.random() * 255);
    return "rgb(" + r + "," + g + "," + b + ")";
  }

  function chart1() {
    let chartDonutCon1 = jQuery('.js-chartjs-machine-types');
    let chartDonut1;
    let url1 = "{{url('chart/machine-types')}}";
    let Labels1 = new Array();
    let Totals1 = new Array();
    let Colors1 = new Array();
    let chartPolarPieDonutData1;

    $.get(url1, function(response) {
      response.forEach(function(data) {
        Labels1.push(data.label);
        Totals1.push(data.total);
        Colors1.push(dynamicColors());
      });
    });

    chartPolarPieDonutData1 = {
      labels: Labels1,
      datasets: [{
        data: Totals1,
        backgroundColor: Colors1
      }]
    };

    if (chartDonutCon1.length) {
      chartDonut1 = new Chart(chartDonutCon1, {
        type: 'doughnut',
        data: chartPolarPieDonutData1,
        options: {
          animation: {
            easing: 'linear',
          }
        }
      });
    }
  }

  function chart2() {
    let chartDonutCon2 = jQuery('.js-chartjs-software-types');
    let chartDonut2;
    let url2 = "{{url('chart/software-types')}}";
    let Labels2 = new Array();
    let Totals2 = new Array();
    let Colors2 = new Array();
    let chartPolarPieDonutData2;

    $.get(url2, function(response) {
      response.forEach(function(data) {
        Labels2.push(data.label);
        Totals2.push(data.total);
        Colors2.push(dynamicColors());
      });
    });

    chartPolarPieDonutData2 = {
      labels: Labels2,
      datasets: [{
        data: Totals2,
        backgroundColor: Colors2
      }]
    };

    if (chartDonutCon2.length) {
      chartDonut2 = new Chart(chartDonutCon2, {
        type: 'doughnut',
        data: chartPolarPieDonutData2,
        options: {
          animation: {
            easing: 'linear',
          }
        }
      });
    }
  }

  function initChartsChartJS() {
    chart1();
    chart2();
  }

  window.onload = initChartsChartJS();
</script>
@endpush
@endhasanyrole