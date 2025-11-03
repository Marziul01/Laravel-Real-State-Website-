@extends('admin.master')

@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-6 mb-4 order-0">
                <div class="card contact-card">
                    <div class="d-flex align-items-start row">
                        <div class="col-md-6">
                            <div class="card-body">
                                <h5 class="card-title text-primary mb-3">Hello, Welcome again <span
                                        class="text-uppercase">{{ Auth::user()->name }}</span>! 🎉</h5>
                                <h6 class="text-secondary mb-3">
                                    @php
                                        use Carbon\Carbon;

                                        $now = Carbon::now();
                                        $hour = $now->format('H');

                                        if ($hour >= 3 && $hour < 12) {
                                            $greeting = 'Good Morning';
                                        } elseif ($hour >= 12 && $hour < 18) {
                                            $greeting = 'Good Afternoon';
                                        } elseif ($hour >= 18 && $hour < 20) {
                                            $greeting = 'Good Evening';
                                        } else {
                                            $greeting = 'Good Night';
                                        }
                                    @endphp

                                    <p>{{ $greeting }}. Today {{ $now->format('d F Y, l') }}</p>
                                </h6>
                                <a href="" class="btn btn-sm btn-outline-primary">View Profile</a>
                            </div>
                        </div>
                        <div class="col-md-6 text-center text-sm-left d-none d-md-block">
                            <div class="card-body pb-0 px-0 px-md-6">
                                <img src="{{ asset('admin-assets') }}/assets/img/illustrations/man.png" height="230px"
                                    class="scaleX-n1-rtl" alt="View Badge User" />
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            {{-- <div class="col-lg-4 col-md-4">
                <div class="row">
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card h-100 contact-card">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-3">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/chart-success.png"
                                            alt="chart success" class="rounded" />
                                    </div>
                                    
                                </div>
                                <p class="mb-0">This Month Income</p>
                                <h4 class="card-title ttoalsamount mb-0"> BDT
                                </h4>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card h-100 contact-card">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-3">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/wallet-info.png"
                                            alt="wallet info" class="rounded" />
                                    </div>
                                    
                                </div>
                                <p class="mb-0">This Month Expenses</p>
                                <h4 class="card-title ttoalsamount mb-0">
                                    BDT</h4>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card h-100 contact-card">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-3">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/chart-success.png"
                                            alt="chart success" class="rounded" />
                                    </div>
                                    
                                </div>
                                <p class="mb-0">This Month Assets</p>
                                <h4 class="card-title ttoalsamount mb-0"> BDT
                                </h4>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card h-100 contact-card">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-3">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/wallet-info.png"
                                            alt="wallet info" class="rounded" />
                                    </div>
                                    
                                </div>
                                <p class="mb-0">This Month Liabilities</p>
                                <h4 class="card-title ttoalsamount mb-0">
                                    BDT</h4>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card h-100 contact-card">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-3">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/chart-success.png"
                                            alt="chart success" class="rounded" />
                                    </div>
                                    
                                </div>
                                <p class="mb-0">This Month Investments</p>
                                <h4 class="card-title ttoalsamount mb-0"> BDT
                                </h4>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-6 mb-4">
                        <div class="card h-100 contact-card">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-3">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/wallet-info.png"
                                            alt="wallet info" class="rounded" />
                                    </div>
                                    
                                </div>
                                <p class="mb-0">This Month Bank Amount</p>
                                <h4 class="card-title ttoalsamount mb-0">
                                    BDT</h4>
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-12 mb-3 mt-1">
                <div class="row">
                    <div class="col-lg-2 col-md-3 col-6 mb-4">
                        <div class="card contact-card h-100">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-3">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/chart-success.png"
                                            alt="chart success" class="rounded" />
                                    </div>
                                    
                                </div>
                                <p class="mb-0">Total Incomes</p>
                                <h4 class="card-title ttoalsamount mb-0"> BDT
                                </h4>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-6 mb-4">
                        <div class="card contact-card h-100">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/wallet-info.png"
                                            alt="wallet info" class="rounded" />
                                    </div>
                                    
                                </div>
                                <p class="mb-0">Total Expenses</p>
                                <h4 class="card-title ttoalsamount mb-0">
                                    BDT</h4>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-6 mb-4">
                        <div class="card contact-card h-100">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-3">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/paypal.png"
                                            alt="paypal" class="rounded" />
                                    </div>
                                    
                                </div>
                                <p class="mb-0">Total Assets</p>
                                <h4 class="card-title mb-3 ttoalsamount mb-0">BDT
                                </h4>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-6 mb-4">
                        <div class="card contact-card h-100">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-3">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/cc-primary.png"
                                            alt="Credit Card" class="rounded" />
                                    </div>
                                    
                                </div>
                                <p class="mb-0">Total Liability</p>
                                <h4 class="card-title mb-0 ttoalsamount">
                                     BDT</h4>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-6 mb-4">
                        <div class="card contact-card h-100">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-3">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/paypal.png"
                                            alt="paypal" class="rounded" />
                                    </div>
                                    
                                </div>
                                <p class="mb-0">Total Investments</p>
                                <h4 class="card-title mb- ttoalsamount">
                                     BDT</h4>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 col-6 mb-4">
                        <div class="card contact-card h-100">
                            <div class="card-body p-4">
                                <div class="card-title d-flex align-items-start justify-content-between mb-3">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{ asset('admin-assets') }}/assets/img/icons/unicons/cc-primary.png"
                                            alt="Credit Card" class="rounded" />
                                    </div>
                                    
                                </div>
                                <p class="mb-0">Total Bank Amount</p>
                                <h4 class="card-title mb-0 ttoalsamount"> BDT</h4>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 order-0 mb-6">
                <div class="card contact-card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title mb-0">
                            <h5 class="mb-1 me-2">Transaction Statistics</h5>

                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless mb-0 no-colors"> 
                            <tbody>
                               
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-6 order-1 mb-6">
                <div class="card  contact-card h-100">
                    <div class="card-header nav-align-top">
                        <h5 class="mb-1 me-2 mb-4">Monthly Statistics</h5>
                        <ul class="nav nav-pills" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#income-tab">Income</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#expenses-tab">Expense</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#assets-tab">Asset</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#liabilities-tab">Liability</button>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content p-0">
                            <div class="tab-pane fade show active" id="income-tab"> <!-- added show active -->
                                <div id="incomeChart"></div>
                            </div>
                            <div class="tab-pane fade" id="expenses-tab">
                                <div id="expensesChart"></div>
                            </div>
                            <div class="tab-pane fade" id="assets-tab">
                                <div id="assetsChart"></div>
                            </div>
                            <div class="tab-pane fade" id="liabilities-tab">
                                <div id="liabilitiesChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Total Revenue -->
            <div class="col-12 col-xxl-8 order-2 order-md-3 order-xxl-2 mb-6">
                <div class="card contact-card">
                    <div class="row row-bordered g-0">
                        <div class="col-lg-12">
                            <div class="card-header d-flex align-items-start justify-content-start flex-column">
                                <div class="card-title mb-4">
                                    <h5 class="m-0 me-2">Total Revenue</h5>
                                </div>
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <button class="nav-link active" data-bs-toggle="tab"
                                            data-bs-target="#revenue-income">Income</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab"
                                            data-bs-target="#revenue-expense">Expense</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab"
                                            data-bs-target="#revenue-asset">Asset</button>
                                    </li>
                                    <li class="nav-item">
                                        <button class="nav-link" data-bs-toggle="tab"
                                            data-bs-target="#revenue-liability">Liability</button>
                                    </li>
                                </ul>
                            </div>
                        
                            <div class="mt-4">
                                <div id="totalRevenueChart"></div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 order-2 mb-6">
                <div class="card contact-card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title m-0 me-2">Bank Transactions</h5>
                    </div>
                    <div class="card-body pt-4">
                        <table class="table table-borderless mb-0 no-colors">
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body d-flex justify-content-center flex-column align-items-center auth-success-modal">
                    <img src="{{ asset('admin-assets/img/double-check.gif') }}" width="25%" alt="">
                    <h5 class="modal-title text-center" id="successModalLabel">Success</h5>
                    <p id="successMessage" class="text-center">Login successful!</p>
                </div>
            </div>
        </div>
    </div>

    <div id="fullscreenLoader" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.5); z-index:9999;">
        <div style="display:flex; justify-content:center; align-items:center; width:100%; height:100%;">
            <div class="loader-custom"></div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
