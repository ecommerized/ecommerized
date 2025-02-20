<div>
    <div class="modal-header bg-stroke border-0">
        <h4 class="fs-18 fw-600 lh-22 text-title-text">{{__('Task Requirement') }}</h4>
        <button type="button"
                class="w-30 h-30 border-0 rounded-circle bg-white text-para-text d-flex justify-content-center align-items-center"
                data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
    </div>
    <div class="modal-body task-modalBody-height overflow-y-auto">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="bd-b-one bd-c-black-stroke">
            <ol class="breadcrumb sf-breadcrumb justify-content-start">
                <li class="breadcrumb-item"><p>{{__('Dashboard')}}</p></li>
                <li class="breadcrumb-item">{{__('Orders')}}</li>
                <li class="breadcrumb-item">{{__('Task Board')}}</li>
                <li class="breadcrumb-item active">#{{$orderTask->taskId}}</li>
            </ol>
        </nav>
        <!--  -->
        <div class="py-20 rg-20 row">
            <div class="col-12">
                <label class="zForm-label">{{ __('Service Name') }}</label>
                <p class="zForm-control">{{$orderItem->service->title ?? '' }}</p>
            </div>
            @if($orderTaskRequirement)
                <!-- Left -->
                <div class="col-12">
                    <label for="description" class="zForm-label mb-0">{{ __("Task Description") }}</label>
                    <div>
                        {!! $orderTaskRequirement->description !!}
                    </div>
                </div>
                @if($orderTaskRequirement->file)
                    <div class="col-12">
                        <div class="d-flex align-items-center g-10 pb-16">
                            <label class="zForm-label mb-0">{{__('Attachments')}}</label>
                        </div>
                        <ul class="d-flex flex-column flex-wrap g-10">
                            @foreach(json_decode($orderTaskRequirement->file) as $attachment)
                                <li class="bd-one bd-c-black-stroke bd-ra-6 p-10 d-flex align-items-center g-10">
                                    <div class="flex-grow-1 d-flex align-items-center g-10">
                                        <div class="img max-w-50 max-h-50 overflow-hidden bd-one bd-c-black-stroke bd-ra-4">
                                            @if(in_array(getFileData($attachment, 'extension'), ['jpg','png','jpeg','webp','JPG','PNG','JPEG','WEBP']))
                                                <img src="{{ getFileUrl($attachment) }}" alt="">
                                            @else
                                                <img src="{{ asset('assets/images/icon/files-1.svg')}}" alt=""/>
                                            @endif
                                        </div>
                                        <div class="">
                                            <h4 class="fs-14 fw-400 lh-17 text-title-text">{{getFileData($attachment, 'file_name')}}</h4>
                                            <p class="fs-12 fw-400 lh-15 text-para-text">
                                                {{getFileData($attachment, 'size')}} B
                                                <span>.</span>
                                                <span>({{getFileData($attachment, 'extension')}})</span>
                                            </p>
                                        </div>
                                    </div>
                                    <a href="{{ getFileUrl($attachment)  }}" target="_blank"
                                       class="text-black flex-shrink-0 border-0 bg-transparent d-flex justify-content-center align-items-center"><i
                                            class="fa-solid fa-circle-down"></i></a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            @else
                <div class="col-12">
                    <h6 class="fs-14 fw-400 lh-24 text-para-text">{{__('Not Submitted Yet')}}</h6>
                </div>
            @endif
        </div>
    </div>
    <div class="modal-footer">
        <button type="button"
                class="bd-ra-8 bg-para-text border-0 d-inline-flex fs-15 fw-600 lh-25 px-26 py-8 text-white"
                data-bs-dismiss="modal">{{__('Close')}}</button>
    </div>
</div>
