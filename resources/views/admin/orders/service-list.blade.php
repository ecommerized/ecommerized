@extends(auth()->user()->role == USER_ROLE_CLIENT ? 'user.layouts.app' : 'admin.layouts.app')
@push('title')
    {{$pageTitle}}
@endpush
@section('content')
    <!-- Content -->
    <div data-aos="fade-up" data-aos-duration="1000" class="p-sm-30 p-15">
        <h4 class="fs-18 fw-600 lh-20 text-title-text pb-18">{{$order->order_id}}</h4>
        <div class="bg-white bd-one bd-c-stroke bd-ra-10 p-sm-30 p-15">
            <table class="zTable zTable-last-item-right table">
                <thead>
                <th>
                    <div>{{__('Service')}}</div>
                </th>
                <th>
                    <div>{{__('Action')}}</div>
                </th>
                </thead>
                <tbody>
                @foreach($order->client_order_items as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center g-10">
                                <div>
                                    @if($item->status == WORKING_STATUS_PENDING)
                                        <img src="{{asset('assets/images/task-pending.png')}}" alt="">
                                    @elseif($item->status == WORKING_STATUS_WORKING)
                                        <img src="{{asset('assets/images/task-processing.png')}}" alt="">
                                    @elseif($item->status == WORKING_STATUS_CANCELED)
                                        <img src="{{asset('assets/images/task-pending.png')}}" alt="">
                                    @else
                                        <img src="{{asset('assets/images/task-completed.png')}}" alt="">
                                    @endif
                                </div>
                                <p class="fs-14 fw-500 lh-16">
                                    @if($item->quantity > 1)
                                        {{$item->quantity}}
                                    @endif
                                    @if($item->quantity == 1)
                                        {{__('Unlimited')}}
                                    @endif
                                    {{$item->service->title}}
                                </p>
                            </div>
                        </td>
                        <td>
                            <div class="align-items-center d-flex g-10 justify-content-end">
                                @if(auth()->user()->role == USER_ROLE_CLIENT)
                                    <a href="{{route('user.orders.task-board.index', $item->id) }}"
                                       class="text-nowrap border-0 bg-badge-trackOrder-bg py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-badge-trackOrder-text"
                                       title="{{ __('Task Board') }}"><span>{{ __('Task Board') }}</span></a>
                                @else
                                    <a href="{{route('admin.client-orders.task-board.index', $item->id) }}"
                                       class="text-nowrap border-0 bg-badge-trackOrder-bg py-8 px-26 bd-ra-8 fs-15 fw-600 lh-25 text-badge-trackOrder-text"
                                       title="{{ __('Task Board') }}"><span>{{ __('Task Board') }}</span></a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
