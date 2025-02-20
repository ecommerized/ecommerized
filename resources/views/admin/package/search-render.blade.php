
    @if(count($serviceList) > 0)
        <div data-aos="fade-up" data-aos-duration="1000" class="">
            <!-- Search - Filter - Create -->
            <div
                class="py-19 px-sm-30 px-15 bd-b-one bd-c-black-stroke d-flex justify-content-center justify-content-xxl-between align-items-center flex-wrap g-10">
                <!-- Left -->
                <ul class="nav nav-tabs zTab-reset zTab-serviceIcon justify-content-center justify-content-sm-start g-10"
                    id="myTab" role="tablist">

                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link active bg-transparent w-42 h-42 rounded-circle bd-one bd-c-black-stroke d-flex justify-content-center align-items-center"
                            id="serviceGrid-tab" data-bs-toggle="tab" data-bs-target="#serviceGrid-tab-pane" type="button"
                            role="tab" aria-controls="serviceGrid-tab-pane" aria-selected="true">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M0 0H4V4H0V0ZM6 0H10V4H6V0ZM12 0H16V4H12V0ZM0 6H4V10H0V6ZM6 6H10V10H6V6ZM12 6H16V10H12V6ZM0 12H4V16H0V12ZM6 12H10V16H6V12ZM12 12H16V16H12V12Z"
                                    fill="#5D697A"/>
                            </svg>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button
                            class="nav-link bg-transparent w-42 h-42 rounded-circle bd-one bd-c-black-stroke d-flex justify-content-center align-items-center"
                            id="serviceList-tab" data-bs-toggle="tab" data-bs-target="#serviceList-tab-pane" type="button"
                            role="tab" aria-controls="serviceList-tab-pane" aria-selected="false">
                            <svg width="18" height="10" viewBox="0 0 18 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4 2V3.4602e-06H18V2H4ZM4 6V4H18V6H4ZM4 10V8H18V10H4ZM1 2C0.71667 2 0.479003 1.904 0.287003 1.712C0.0950034 1.52 -0.000663206 1.28267 3.46021e-06 1C3.46021e-06 0.71667 0.0960036 0.479004 0.288004 0.287004C0.480004 0.0950036 0.717337 -0.000663206 1 3.4602e-06C1.28334 3.4602e-06 1.521 0.0960036 1.713 0.288004C1.905 0.480004 2.00067 0.717337 2 1C2 1.28334 1.904 1.521 1.712 1.713C1.52 1.905 1.28267 2.00067 1 2ZM1 6C0.71667 6 0.479003 5.904 0.287003 5.712C0.0950034 5.52 -0.000663206 5.28267 3.46021e-06 5C3.46021e-06 4.71667 0.0960036 4.479 0.288004 4.287C0.480004 4.095 0.717337 3.99934 1 4C1.28334 4 1.521 4.096 1.713 4.288C1.905 4.48 2.00067 4.71734 2 5C2 5.28334 1.904 5.521 1.712 5.713C1.52 5.905 1.28267 6.00067 1 6ZM1 10C0.71667 10 0.479003 9.904 0.287003 9.712C0.0950034 9.52 -0.000663206 9.28267 3.46021e-06 9C3.46021e-06 8.71667 0.0960036 8.479 0.288004 8.287C0.480004 8.095 0.717337 7.99934 1 8C1.28334 8 1.521 8.096 1.713 8.288C1.905 8.48 2.00067 8.71734 2 9C2 9.28334 1.904 9.521 1.712 9.713C1.52 9.905 1.28267 10.0007 1 10Z"
                                    fill="#5D697A"
                                />
                            </svg>
                        </button>
                    </li>
                </ul>
                <!-- Right -->
                <div
                    class="flex-grow-1 d-flex justify-content-center justify-content-xxl-end align-items-center flex-wrap g-12">
                    <!-- Add Service -->
                    <a href="{{route('admin.services.add-new')}}"
                       class="border-0 bg-button py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white">+ {{__("Add Service")}}</a>
                    <!-- Search -->
                    <div class="search-one flex-grow-1 max-w-282">
                        <input type="text" class="service-search" placeholder="{{__("Search here...")}}"/>
                        <button class="icon"><img src="{{ asset('assets/images/icon/search.svg') }}" alt=""/></button>
                    </div>
                    <!-- Icon -->
                </div>
            </div>
            <!-- Services item -->
            <div class="p-sm-30 p-15">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="serviceGrid-tab-pane" role="tabpanel"
                         aria-labelledby="serviceGrid-tab" tabindex="0">
                        <div class="row rg-15">
                            @foreach($serviceList as $service)
                                <div class="col-xxl-3 col-md-4 col-sm-6">
                                    <div class="p-16 bd-ra-10 bg-white">
                                        <!-- img -->
                                        <div class="overflow-hidden bd-ra-8 max-h-157 min-h-157 mb-13">
                                            <img src="{{getFileUrl($service->image)}}" alt="{{$service->service_name}}"
                                                 class="w-100 h-100 object-fit-cover"/>
                                        </div>
                                        <!-- Title - Price -->
                                        <div class="bd-b-one bd-c-black-stroke pb-14 mb-11">
                                            <!--  -->
                                            <h4 class="fs-15 fw-600 lh-18 text-title-text pb-9">{{$service->service_name}}</h4>
                                            <!--  -->
                                            <h4 class="fs-15 fw-500 lh-18 text-para-text">{{currentCurrency('symbol')}}{{$service->price}}</h4>
                                        </div>
                                        <!-- Details -->
                                        <a href="{{route('admin.services.details', encrypt($service->id))}}"
                                           class="d-flex justify-content-between align-items-center cg-8 fs-14 fw-500 lh-17 text-button">
                                            {{__("View Details")}}
                                            <i class="fa-solid fa-long-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else

        <div data-aos="fade-up" data-aos-duration="1000" class="p-sm-30 p-15">
            <div class="p-sm-20 p-15 bg-white bd-one bd-c-black-stroke bd-ra-10">
                <div class="pb-25 flex-grow-1 d-flex justify-content-center justify-content-xxl-end align-items-center flex-wrap g-12">
                    <!-- Add Service -->
                    <a href="{{route('admin.services.add-new')}}"
                       class="border-0 bg-button py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-white">+ {{__("Add Service")}}</a>
                    <!-- Search -->
                    <div class="search-one flex-grow-1 max-w-282">
                        <input type="text" class="service-search" placeholder="{{__("Search here...")}}"/>
                        <button class="icon"><img src="{{ asset('assets/images/icon/search.svg') }}" alt=""/></button>
                    </div>
                    <!-- Icon -->
                </div>
                <div class="create-wrap">
                    <div class="mb-22"><img src="{{ asset('assets/images/create-icon.png') }}" alt="" /></div>
                    <h4 class="pb-22 fs-24 fw-500 lh-30 text-title-text text-center">{{__("No Search Data Found!")}}</h4>
                </div>
            </div>
        </div>
    @endif
