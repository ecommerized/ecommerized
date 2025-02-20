@if($currencyList != null && count($currencyList) > 0)
    <ul class="zList-pb-12 pt-20 mt-20 bd-t-one bd-c-black-stroke">
    @foreach($currencyList as $key=>$singleCurrency)
        <li class="d-flex justify-content-between align-items-center">
            <!--  -->
            <div class="zForm-wrap-radio">
                <input type="radio" name="currency_option" class="form-check-input currency-option" id="{{$key}}" data-id="{{$singleCurrency->id}}" />
                <label for="{{$key}}">{{$singleCurrency->currency}}</label>
            </div>
            <!--  -->
            <p class="fs-14 fw-400 lh-16 text-title-text">{{currentCurrency('symbol').$itemAmount.' * '.$singleCurrency->conversion_rate.' = '.getCurrency($singleCurrency->currency ,true) .($itemAmount * $singleCurrency->conversion_rate)}}</p>
        </li>
    @endforeach
    </ul>
@endif

