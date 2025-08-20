<?php
require_once("config.php");
?>

<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Blank Page</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Blank Page</li>
          </ol>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Your Content Title</h3>
        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">
        <!-- Your content goes here -->
        <div class="row">
    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <div class="card bg-success text-white shadow-lg h-100 animated-card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-sm rounded-circle bg-white text-success mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-calendar-check" style="font-size: 20px;"></i>
                    </div>
                    <h5 class="card-title mb-0 font-weight-bold">Today's Booking</h5>
                </div>
                <div class="text-center">
                    <h4 class="mb-0 font-weight-bold">15</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <div class="card bg-info text-white shadow-lg h-100 animated-card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-sm rounded-circle bg-white text-info mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-chart-line" style="font-size: 20px;"></i>
                    </div>
                    <h5 class="card-title mb-0 font-weight-bold">Profit</h5>
                </div>
                <div class="text-center">
                    <h4 class="mb-0 font-weight-bold">$1,100</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <div class="card bg-warning text-white shadow-lg h-100 animated-card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-sm rounded-circle bg-white text-warning mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-dollar-sign" style="font-size: 20px;"></i>
                    </div>
                    <h5 class="card-title mb-0 font-weight-bold">Sales</h5>
                </div>
                <div class="text-center">
                    <h4 class="mb-0 font-weight-bold">$3,500</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
        <div class="card bg-danger text-white shadow-lg h-100 animated-card">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="avatar-sm rounded-circle bg-white text-danger mr-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="fas fa-exchange-alt" style="font-size: 20px;"></i>
                    </div>
                    <h5 class="card-title mb-0 font-weight-bold">Transactions</h5>
                </div>
                <div class="text-center">
                    <h4 class="mb-0 font-weight-bold">$5,200</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.animated-card {
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.animated-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}
</style>

      <!-- Your content ends here -->
      </div>

      <div class="card-footer">
        </div>
    </div>
  </section>
</div>