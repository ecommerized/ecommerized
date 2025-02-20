<form class="ajax" data-handler="commonResponseWithPageLoad"
      action="{{route('admin.client-orders.task-board.store', [$orderItem->id, $orderTask->id])}}" method="POST">
    @csrf
    <div class="modal-header">
        <h5 class="fs-18 fw-600 lh-24 text-title-text">{{__('Update Task')}}</h5>
        <button type="button" class="w-30 h-30 flex-shrink-0 d-flex justify-content-center align-items-center bd-one bd-c-stroke rounded-circle bg-transparent fs-20 text-para-text " data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
    </div>
    <div class="modal-body task-modalBody-height overflow-y-auto">
        @include('admin.orders.task-board.form')
    </div>
    <div class="modal-footer">
        <button type="button" class="bd-ra-8 bg-para-text border-0 d-inline-flex fs-15 fw-600 lh-25 px-26 py-8 text-white" data-bs-dismiss="modal">{{__('Close')}}</button>
        <button type="submit" class="bd-ra-8 bg-button border-0 d-inline-flex fs-15 fw-600 lh-25 px-26 py-8 text-white">{{__('Save')}}</button>
    </div>
</form>
