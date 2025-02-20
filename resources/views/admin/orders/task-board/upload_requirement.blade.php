<div>
    <form method="POST"
          action="{{route('user.orders.task-board.upload_requirements.store', [$orderItem->id, $orderTask->id])}}"
          data-handler="commonResponse" class="ajax">
        @csrf
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
                    <input disabled type="text" class="pe-none form-control zForm-control" id="service_name"
                           value="{{ $orderItem->service->title ?? '' }}"/>
                </div>
                <!-- Left -->
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center g-10 pb-8">
                        <label for="description" class="zForm-label mb-0">{{ __("Task Description") }}</label>
                    </div>
                    <textarea name="description" id="requirement-description"
                              class="form-control zForm-control summernoteOne" rows="3"
                              placeholder="{{ __('Requirement Description') }}">{!! $orderTaskRequirement->description ?? '' !!}</textarea>
                </div>
                <div class="col-12">
                    <div class="file-input-wrapper">
                        <div class="d-flex gap-1">
                            <p class="fs-15 fw-600 lh-24 text-title-text pb-12">{{__("Upload Image")}}</p>
                            <div data-bs-toggle="tooltip" data-bs-html="true"
                                 title="Accepted documents: csv, odt, doc, docx, htm, html, pdf, ppt, pptx, txt, xls, xlsx, jpg, jpeg, png, gif, webp, svg, ai, mp4, mp3, wav, zip, rar">
                                <svg class="w-16" focusable="false" aria-hidden="true" viewBox="0 0 24 24">
                                    <path
                                        d="M11 7h2v2h-2zm0 4h2v6h-2zm1-9C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="file-upload-one file-upload-one-alt">
                            <label for="mAttachment5">
                                <p class="fs-12 fw-500 lh-16 text-para-text">{{__("Choose File to upload")}}</p>
                                <p class="fs-12 fw-500 lh-16 text-white">{{__("Browse File")}}</p>
                            </label>
                            <input type="file" name="attachment[]" id="mAttachment5"
                                   class="attachments file-input invisible position-absolute" multiple=""/>
                        </div>
                        <div class="files-area">
                            <span class="filesList">
                                <span class="files-names">
                                     @if(($orderTaskRequirement->file ?? null) != null)
                                        @foreach (json_decode($orderTaskRequirement->file) as $item)
                                            <span class="file-block"><span class="file-icon"><i
                                                        class="fa-solid fa-file"></i></span>
                                        <input type="hidden" name="oldFiles[]" value="{{$item }}">
                                        <p class="name">{{ getFileData($item,'original_name') }}</p>
                                        <span class="file-delete"><i class="fa-solid fa-xmark"></i></span>
                                    </span>
                                        @endforeach
                                    @endif
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button"
                    class="bd-ra-8 bg-para-text border-0 d-inline-flex fs-15 fw-600 lh-25 px-26 py-8 text-white"
                    data-bs-dismiss="modal">{{__('Close')}}</button>
            <button type="submit"
                    class="bd-ra-8 bg-button border-0 d-inline-flex fs-15 fw-600 lh-25 px-26 py-8 text-white">{{__('Save')}}</button>
        </div>
    </form>
</div>
