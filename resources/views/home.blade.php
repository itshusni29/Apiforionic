@extends('layouts.master')

@section('title', 'Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-2 row-cols-xl-4">
              <div class="col">
                <div class="card radius-10">
                  <div class="card-body">
                      <div class="d-flex align-items-center">
                          <div>
                                <p class="mb-0 text-secondary">Total Buku</p>
                                <h4 class="my-1">{{ $totalBooks }}</h4>
                                <p class="mb-0 font-13 text-{{ $percentageChangeBooks >= 0 ? 'success' : 'danger' }}">
                                    <i class="bi bi-caret-{{ $percentageChangeBooks >= 0 ? 'up' : 'down' }}-fill"></i> 
                                    {{ number_format(abs($percentageChangeBooks), 2) }}% from last month
                                </p>
                          </div>
                          <div class="widget-icon-large bg-gradient-purple text-white ms-auto"><i class="bi bi-basket2-fill"></i>
                          </div>
                      </div>
                  </div>
                </div>
               </div>
               <div class="col">
                  <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0 text-secondary">Total User</p>
                                <h4 class="my-1">{{ $totalUsers }}</h4>
                                <p class="mb-0 font-13 text-{{ $percentageChangeUsers >= 0 ? 'success' : 'danger' }}">
                                    <i class="bi bi-caret-{{ $percentageChangeUsers >= 0 ? 'up' : 'down' }}-fill"></i> 
                                    {{ number_format(abs($percentageChangeUsers), 2) }}% from last month
                                </p>
                            </div>
                            <div class="widget-icon-large bg-gradient-success text-white ms-auto"><i class="bi bi-currency-exchange"></i>
                            </div>
                        </div>
                    </div>
                </div>
               </div>
               <div class="col">
                <div class="card radius-10">
                  <div class="card-body">
                      <div class="d-flex align-items-center">
                          <div>
                              <p class="mb-0 text-secondary">Total Peminjam</p>
                              <h4 class="my-1">{{ $totalLoans }}</h4>
                              <p class="mb-0 font-13 text-{{ $percentageChangeLoans >= 0 ? 'success' : 'danger' }}">
                                <i class="bi bi-caret-{{ $percentageChangeLoans >= 0 ? 'up' : 'down' }}-fill"></i> 
                                {{ number_format(abs($percentageChangeLoans), 2) }}% from last month
                              </p>
                          </div>
                          <div class="widget-icon-large bg-gradient-danger text-white ms-auto"><i class="bi bi-people-fill"></i>
                          </div>
                      </div>
                  </div>
               </div>
               </div>
               <div class="col">
                <div class="card radius-10">
                  <div class="card-body">
                      <div class="d-flex align-items-center">
                          <div>
                              <p class="mb-0 text-secondary">Stock</p>
                              <h4 class="my-1">{{ $totalAvailableBooks }}</h4>
                              <p class="mb-0 font-13 text-success"><i class="bi bi-caret-up-fill"></i> - </p>
                          </div>
                          <div class="widget-icon-large bg-gradient-info text-white ms-auto"><i class="bi bi-bar-chart-line-fill"></i>
                          </div>
                      </div>
                  </div>
                </div>
               </div>
            </div><!--end row-->

            <div class="row">
              <div class="col-12 col-lg-8 col-xl-8 d-flex">
                <div class="card radius-10 w-100">
                  <div class="card-body">
                     <div class="row row-cols-1 row-cols-lg-2 g-3 align-items-center pb-3">
                        <div class="col">
                          <h5 class="mb-0">Jumlah Pinjaman</h5>
                        </div>
                        <div class="col">
                          <div class="d-flex align-items-center justify-content-sm-end gap-3 cursor-pointer">
                             <div class="font-13"><i class="bi bi-circle-fill text-primary"></i><span class="ms-2">Sales</span></div>
                             <div class="font-13"><i class="bi bi-circle-fill text-success"></i><span class="ms-2">Orders</span></div>
                          </div>
                        </div>
                     </div>
                     <div id="chart1"></div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-4 col-xl-4 d-flex">
                <div class="card radius-10 w-100">
                  <div class="card-header bg-transparent">
                    <div class="row g-3 align-items-center">
                      <div class="col">
                        <h5 class="mb-0">Statistics</h5>
                      </div>
                     </div>
                  </div>
                  <div class="card-body">
                    <div id="chart2"></div>
                  </div>
                  <ul class="list-group list-group-flush mb-0">
                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent border-top">New Orders<span class="badge bg-primary badge-pill">25%</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">Completed<span class="badge bg-orange badge-pill">65%</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center bg-transparent">Pending<span class="badge bg-success badge-pill">10%</span>
                </li>
              </ul>
                </div>
              </div>
            </div><!--end row-->


            <div class="row">
              <div class="col-12 col-lg-6 col-xl-4 d-flex">
                <div class="card radius-10 w-100">
                 <div class="card-header bg-transparent">
                   <div class="row g-3 align-items-center">
                     <div class="col">
                       <h5 class="mb-0">Top Categories</h5>
                     </div>
                    </div>
                 </div>
                  <div class="card-body">
                    <div class="categories">
                      @foreach ($topCategories as $category)
                          <div class="progress-wrapper">
                              <p class="mb-2">{{ $category->kategori }} <span class="float-end">{{ $category->percentage }}%</span></p>
                              <div class="progress" style="height: 6px;">
                                  <div class="progress-bar bg-gradient-{{ $category->color }}" role="progressbar" style="width: {{ $category->percentage }}%;"></div>
                              </div>
                          </div>
                          @if (!$loop->last)
                              <div class="my-3 border-top"></div>
                          @endif
                      @endforeach

                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-lg-6 col-xl-4 d-flex">
               <div class="card radius-10 w-100">
                 <div class="card-header bg-transparent">
                   <div class="row g-3 align-items-center">
                     <div class="col">
                       <h5 class="mb-0">Best Buku</h5>
                     </div>
                    </div>
                 </div>
                 <div class="card-body p-0">
                    <div class="best-product p-2 mb-3">
                      @foreach ($mostBorrowedBooks as $book)
                          <div class="best-product-item">
                              <div class="d-flex align-items-center gap-3">
                                  <div class="product-box border">
                                      <img src="assets/images/products/01.png" alt="">
                                  </div>
                                  <div class="product-info">
                                      <h6 class="product-name mb-1">{{ $book->judul }}</h6>
                                      <div class="product-rating mb-0">
                                          @php
                                              $rating = $book->ratings ?? 0; // Mendapatkan rating buku, default 0 jika tidak ada rating
                                              $filledStars = min(5, max(0, (int) $rating)); // Batasi jumlah bintang maksimal 5 dan minimal 0
                                          @endphp
                                          @for ($i = 0; $i < $filledStars; $i++)
                                              <i class="bi bi-star-fill text-warning"></i>
                                          @endfor
                                      </div>
                                  </div>
                                  <div class="sales-count ms-auto">
                                      <p class="mb-0">{{ $book->loans_count }} Pinjaman</p>
                                  </div>
                              </div>
                          </div>
                      @endforeach
                    </div>
                 </div>
               </div>
             </div>
             <div class="col-12 col-lg-12 col-xl-4 d-flex">
               <div class="card radius-10 w-100">
                 <div class="card-header bg-transparent">
                   <div class="row g-3 align-items-center">
                     <div class="col">
                       <h5 class="mb-0">Pinjaman Terbaru</h5>
                     </div>
                    </div>
                 </div>
                 <div class="top-sellers-list p-2 mb-3">
                    @foreach($recentLoans as $loan)
                    <div class="d-flex align-items-center gap-3 sellers-list-item">
                        <img src="{{ asset('path/to/avatar/' . $loan->user->avatar) }}" class="rounded-circle" width="50" height="50" alt="">
                        <div>
                            <h6 class="mb-1">{{ $loan->book->judul }}</h6>
                            <p class="mb-0 font-13">{{ $loan->user->name }}</p>
                        </div>
                        <div class="d-flex align-items-center gap-3 fs-6 ms-auto">
                            <p class="mb-0">{{ $loan->book->ratings ?? '0.0' }} <i class="bi bi-star-fill text-warning"></i></p>
                        </div>
                    </div>
                    @endforeach
                </div>
               </div>
             </div>
           </div><!--end row-->




@endsection