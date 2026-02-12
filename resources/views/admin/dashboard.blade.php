@extends('layouts.app')

@section('content')
<!-- ===== Page Wrapper Start ===== -->
<div class="flex h-screen overflow-hidden">
  <!-- ===== Sidebar Start ===== -->
  @include('partials.sidebar')
  <!-- ===== Sidebar End ===== -->

  <!-- ===== Content Area Start ===== -->
  <div
    class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto"
  >
    <!-- Small Device Overlay Start -->
    @include('partials.overlay')
    <!-- Small Device Overlay End -->

    <!-- ===== Header Start ===== -->
    @include('partials.header')
    <!-- ===== Header End ===== -->


    <!-- ===== Main Content Start ===== -->
    <main>
      <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
        <div class="grid grid-cols-12 gap-4 md:gap-6">
          <div class="col-span-12 space-y-6 xl:col-span-7">
            <!-- Metric Group One -->
            @include('partials.metric-group.metric-group-01')
            <!-- Metric Group One -->

            <!-- ====== Chart One Start -->
            @include('partials.chart.chart-01')
            <!-- ====== Chart One End -->
          </div>
          <div class="col-span-12 xl:col-span-5">
            <!-- ====== Chart Two Start -->
            @include('partials.chart.chart-02')
            <!-- ====== Chart Two End -->
          </div>


          <div class="col-span-12">
            <!-- ====== Chart Three Start -->
            @include('partials.chart.chart-03')
            <!-- ====== Chart Three End -->
          </div>

          <div class="col-span-12 xl:col-span-5">
            <!-- ====== Map One Start -->
            @include('partials.map-01')
            <!-- ====== Map One End -->
          </div>

          <div class="col-span-12 xl:col-span-7">
            <!-- ====== Table One Start -->
            @include('partials.table.table-01')
            <!-- ====== Table One End -->
          </div>
        </div>
      </div>
    </main>
    <!-- ===== Main Content End ===== -->
  </div>
  <!-- ===== Content Area End ===== -->
</div>
@endsection