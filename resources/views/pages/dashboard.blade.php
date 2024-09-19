@extends('layouts.app')
@section('content')

<div class="page-body">
    @include('breadcrumb');
    <!-- Container-fluid starts-->
    <div class="container-fluid default-dashboard">
      <div class="row">
        <div class="col-xl-6 proorder-xxl-1 col-sm-6 box-col-6">
          <div class="card welcome-banner">
            <div class="card-header p-0 card-no-border">
              <div class="welcome-card"><img class="w-100 img-fluid" src="../assets/images/dashboard-1/welcome-bg.png" alt=""/><img class="position-absolute img-1 img-fluid" src="../assets/images/dashboard-1/img-1.png" alt=""/><img class="position-absolute img-2 img-fluid" src="../assets/images/dashboard-1/img-2.png" alt=""/><img class="position-absolute img-3 img-fluid" src="../assets/images/dashboard-1/img-3.png" alt=""/><img class="position-absolute img-4 img-fluid" src="../assets/images/dashboard-1/img-4.png" alt=""/><img class="position-absolute img-5 img-fluid" src="../assets/images/dashboard-1/img-5.png" alt=""/></div>
            </div>
            <div class="card-body">
              <div class="d-flex align-center">
                <h1>Hello, {{( Auth::check()) ? ucwords(Auth::user()->name)  : ''}}  <img src="../assets/images/dashboard-1/hand.png" alt=""/></h1>
              </div>
              <p> Welcome back! Let’s start from where you left.</p>
              {{-- <div class="d-flex align-center justify-content-between"><a class="btn btn-pill btn-primary" href="">Whats New!</a> --}}
                <span id="timeSpan">

                  </span>

                </div>
            </div>
          </div>
        </div>

        <div class="col-xxl-6 col-xl-8 proorder-xxl-8 col-lg-12 col-md-6 box-col-7 d-none">
          <div class="card">
            <div class="card-header card-no-border pb-0">
              <h3>Transition History</h3>
            </div>
            <div class="card-body transaction-history pt-0">
              <div class="table-responsive theme-scrollbar">
                <table class="table display table-bordernone" id="transaction" style="width:100%">
                  <thead>
                    <tr>
                      <th>Item Name</th>
                      <th>Invoice No.</th>
                      <th>Credit/Debit</th>
                      <th>Date/Time</th>
                      <th class="text-center">Status</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                          <div class="flex-shrink-0"><img src="../assets/images/dashboard-1/icon/1.png" alt=""/></div>
                          <div class="flex-grow-1"><a href="product-page.html">
                              <h6>Samsung TV</h6></a>
                            <p>Item Sold</p>
                          </div>
                        </div>
                      </td>
                      <td> #px0101</td>
                      <td class="text-success">+ $3460</td>
                      <td>
                        <div class="d-flex">
                          <div class="flex-grow-1">
                            <h6>Jan 25</h6>
                            <p>08:35:65</p>
                          </div>
                        </div>
                      </td>
                      <td class="text-end">
                        <div class="btn bg-light-success border-light-success text-success">Completed</div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                          <div class="flex-shrink-0"><img src="../assets/images/dashboard-1/icon/2.png" alt=""/></div>
                          <div class="flex-grow-1"><a href="product-page.html">
                              <h6>Spring Bed</h6></a>
                            <p>Bought item</p>
                          </div>
                        </div>
                      </td>
                      <td> #rf304f</td>
                      <td class="text-danger">- $910</td>
                      <td>
                        <div class="d-flex">
                          <div class="flex-grow-1">
                            <h6>Feb 20</h6>
                            <p>12:35:00  </p>
                          </div>
                        </div>
                      </td>
                      <td class="text-end">
                        <div class="btn bg-light-success border-light-success text-success">Completed</div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                          <div class="flex-shrink-0"><img src="../assets/images/dashboard-1/icon/3.png" alt=""/></div>
                          <div class="flex-grow-1"><a href="product-page.html">
                              <h6>Long Dress</h6></a>
                            <p>Bought item</p>
                          </div>
                        </div>
                      </td>
                      <td> #dnj480</td>
                      <td class="text-success">+ $4380</td>
                      <td>
                        <div class="d-flex">
                          <div class="flex-grow-1">
                            <h6>Oct 25</h6>
                            <p>04:39:08</p>
                          </div>
                        </div>
                      </td>
                      <td class="text-end">
                        <div class="btn bg-light-warning border-light-warning text-warning">Pending</div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                          <div class="flex-shrink-0"><img src="../assets/images/dashboard-1/icon/4.png" alt=""/></div>
                          <div class="flex-grow-1"><a href="product-page.html">
                              <h6>Phillip Lightbulb</h6></a>
                            <p>Item Sold</p>
                          </div>
                        </div>
                      </td>
                      <td> #g189d0</td>
                      <td class="text-success">+ $246</td>
                      <td>
                        <div class="d-flex">
                          <div class="flex-grow-1">
                            <h6>Dec 25</h6>
                            <p>08:35:65</p>
                          </div>
                        </div>
                      </td>
                      <td class="text-end">
                        <div class="btn bg-light-danger border-light-danger text-danger">Canceled</div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                          <div class="flex-shrink-0"><img src="../assets/images/dashboard-1/icon/5.png" alt=""/></div>
                          <div class="flex-grow-1"><a href="product-page.html">
                              <h6>Sofa Hauga</h6></a>
                            <p>Item Sold</p>
                          </div>
                        </div>
                      </td>
                      <td> #31d8fs</td>
                      <td class="text-danger">- $220</td>
                      <td>
                        <div class="d-flex">
                          <div class="flex-grow-1">
                            <h6>Jan 25</h6>
                            <p>10:20:87</p>
                          </div>
                        </div>
                      </td>
                      <td class="text-end">
                        <div class="btn bg-light-success border-light-success text-success">Completed</div>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center gap-3">
                          <div class="flex-shrink-0"><img src="../assets/images/dashboard-1/icon/6.png" alt=""/></div>
                          <div class="flex-grow-1"><a href="product-page.html">
                              <h6>Apple iMac 19”</h6></a>
                            <p>Item Sold</p>
                          </div>
                        </div>
                      </td>
                      <td> #g5384h</td>
                      <td class="text-success">+ $983</td>
                      <td>
                        <div class="d-flex">
                          <div class="flex-grow-1">
                            <h6>Feb 05</h6>
                            <p>10:49:50</p>
                          </div>
                        </div>
                      </td>
                      <td class="text-end">
                        <div class="btn bg-light-success border-light-success text-success">Completed</div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  @endsection

@section('page_script')
<script>
    // Function to update the time
    function updateTime() {
        console.log("asd")
      const timeSpan = document.getElementById('timeSpan');
      const now = new Date();
      const options = { hour: '2-digit', minute: '2-digit', hour12: false };
      const timeString = now.toLocaleTimeString([], options);

      // Update the text content with the current time
      timeSpan.innerHTML = `
        <svg class="stroke-icon">
          <use href="../assets/svg/icon-sprite.svg#watch"></use>
        </svg> ${timeString}`;
    }

    // Update the time every second
    setInterval(updateTime, 1000);

    // Initial call to display the time immediately
    updateTime();
  </script>

  @endsection
