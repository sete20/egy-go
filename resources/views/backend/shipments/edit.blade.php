@extends('backend.layouts.app')

@section('content')
@php
    $auth_user = Auth::user();
    $checked_google_map = \App\BusinessSetting::where('type', 'google_map')->first();
    $countries = \App\Country::where('covered',1)->get();
        $packages = \App\Package::all();
    $deliveryTimes = \App\DeliveryTime::all();

@endphp
<style>
    label {
        font-weight: bold !important;
    }
</style>
<div class="mx-auto col-lg-12">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Shipment Info')}}</h5>
        </div>

        <form class="form-horizontal" action="{{ route('admin.shipments.update-shipment',['shipment'=>$shipment->id]) }}" id="kt_form_1" method="POST" enctype="multipart/form-data">
            @csrf
            {{ method_field('PATCH') }}
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">

                        <div class="form-group row">
                            <label class="col-2 col-form-label">{{translate('Shipment Type')}}</label>
                            <div class="col-9 col-form-label">
                                <div class="radio-inline">
                                    <label class="radio radio-success btn btn-default">
                                        <input type="radio" name="Shipment[type]" @if($shipment->type == \App\Shipment::getType(\App\Shipment::PICKUP)) checked @endif value="{{\App\Shipment::PICKUP}}" />
                                        <span></span>
                                           {{translate("(التوصيل من الباب الي الباب)")}}
                                    </label>
                                    <label class="radio radio-success btn btn-default">
                                        <input type="radio" name="Shipment[type]" @if($shipment->type == \App\Shipment::getType(\App\Shipment::DROPOFF)) checked @endif value="{{\App\Shipment::DROPOFF}}" />
                                        <span></span>
                                           {{translate("(تسـليم المكتب    )")}}
                                    </label>
                                </div>

                            </div>
                        </div>
                       <hr>

                             <div class="form-group row">
                            <label class="col-2 col-form-label">{{translate('يوجد مرتجع ؟')}}</label>
                            <div class="col-9 col-form-label">
                                <div class="radio-inline">
                                    <label class="radio radio-success btn btn-default">
                                        <input  type="radio" name="Shipment[package_return]" @if($shipment->package_return == 1)
                                            checked
                                        @endif value="1" />
                                        <span></span>
                                        {{translate("نعم")}}
                                    </label>
                                    <label class="radio radio-success btn btn-default">
                                        <input checked="checked" type="radio" name="Shipment[package_return]" @if($shipment->package_return == 0)
                                            checked
                                        @endif value="0" />
                                        <span></span>
                                        {{translate("لا")}}
                                    </label>
                                </div>

                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{translate('Branch')}}:</label>
                                    <select class="form-control kt-select2 select-branch" disabled id="select-how" name="Shipment[branch_id]">

                                        @foreach($branchs as $branch)
                                        <option @if($shipment->branch_id == $branch->id) selected @endif value="{{$branch->id}}">{{$branch->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                            @if(\App\ShipmentSetting::getVal('is_date_required') == '1' || \App\ShipmentSetting::getVal('is_date_required') == null)
                                <div class="form-group">
                                    <label>{{translate('Shipping Date')}}:</label>
                                    <div class="input-group date">
                                        <input type="text" name="Shipment[shipping_date]" value="{{$shipment->shipping_date}}" class="form-control" id="kt_datepicker_3" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="la la-calendar"></i>
                                            </span>
                                        </div>
                                    </div>

                                </div>
                                @endif
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{translate('Customer/Sender')}}:</label>
                                    @if($auth_user->user_type == "customer")
                                        <input type="text" placeholder="" class="form-control" name="" value="{{$auth_user->name}}" disabled>
                                    @else
                                        <select disabled class="form-control kt-select2 select-client" id="select-how" name="Shipment[client_id]">

                                            @foreach($clients as $client)
                                            <option @if($shipment->client_id == $client->id) selected @endif data-phone="{{$client->responsible_mobile}}" value="{{$client->id}}">{{$client->name}}</option>
                                            @endforeach

                                        </select>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{translate('هاتف العميل')}}:</label>
                                    <input name="Shipment[client_phone]" disabled class="form-control" id="client_phone" value="{{$client->follow_up_mobile}}" id="">

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{translate('عنوان العميل ')}}:</label>
                                    <input name="Shipment[client_address]" disabled class="form-control" value="{{$client->address}}" id="">

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{translate('Receiver Name')}}:</label>
                                    <input type="text" name="Shipment[reciver_name]" class="form-control" value="{{$shipment->reciver_name}}" />

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{translate('هاتف المستلم')}}:</label>
                                    <input type="text" name="Shipment[reciver_phone]" class="form-control" value="{{$shipment->reciver_phone}}" />

                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{translate('Receiver Address')}}:</label>
                                    <input type="text" name="Shipment[reciver_address]" class="form-control" value="{{$shipment->reciver_address}}" />

                                </div>
                            </div>
                            @if($checked_google_map->value == 1 )
                                <div class="col-md-12">
                                    <div class="location-receiver">
                                        <label>{{translate('Receiver Location')}}:</label>
                                        <input type="text" value="{{$shipment->reciver_street_address_map}}" class="form-control address-receiver " placeholder="{{translate('Receiver Location')}}" name="Shipment[reciver_street_address_map]"  rel="receiver" value="" />
                                        <input type="hidden" value="{{$shipment->reciver_lat}}" class="form-control lat" data-receiver="lat" name="Shipment[reciver_lat]" />
                                        <input type="hidden" value="{{$shipment->reciver_lng}}" class="form-control lng" data-receiver="lng" name="Shipment[reciver_lng]" />
                                        <input type="hidden" value="{{$shipment->reciver_url}}" class="form-control url" data-receiver="url" name="Shipment[reciver_url]" />

                                        <div class="mt-2 col-sm-12 map_canvas map-receiver" style="width:100%;height:300px;"></div>
                                        <span class="form-text text-muted">{{'Change the pin to select the right location'}}</span>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <hr>
                                    {{--  <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label>{{translate('From Country')}}:</label>
                                    <select id="change-country" name="Shipment[from_country_id]" class="form-control select-country">
                                        <option value=""></option>
                                        @foreach($countries as $country)
                                        <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{translate('من محافظة')}}:</label>
                                    <select id="change-state-from" name="Shipment[from_state_id]" class="form-control select-state">
                                        <option value=""></option>

                                    </select>
                                </div>
                            </div>

               <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{translate('From Area')}}:</label>
                                    <select name="Shipment[from_area_id]" id="from_area_id" class="form-control select-area">
                                        <option value=""></option>

                                    </select>
                                </div>
                            </div>
                        </div>  --}}

                        <hr>
                      <div id="kt_repeater_1">
                            <div class="row" id="kt_repeater_1">
                                <h2 class="text-left">{{translate('Package Info')}}:</h2>
                                <div data-repeater-list="Package" class="col-lg-12">
                                    <div data-repeater-item class="row align-items-center" style="margin-top: 15px;padding-bottom: 15px;padding-top: 15px;border-top:1px solid #ccc;border-bottom:1px solid #ccc;">



                                        <div class="col-md-3">

                                            <label>{{translate('Package Type')}}:</label>
                                            <select class="form-control kt-select2 package-type-select" name="package_id">
                                                <option></option>
                                                @foreach($packages as $package)
                                                <option @if(\App\ShipmentSetting::getVal('def_package_type')==$package->id) selected @endif value="{{$package->id}}">{{$package->name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">
                                            <label>{{translate('description')}}:</label>
                                            <input type="text" placeholder="{{translate('description')}}" class="form-control" name="description">
                                            <div class="mb-2 d-md-none"></div>
                                        </div>
                                        <div class="col-md-3">

                                            <label>{{translate('Quantity')}}:</label>

                                            <input class="kt_touchspin_qty" placeholder="{{translate('Quantity')}}" type="number" min="1" name="qty" class="form-control" value="1" />
                                            <div class="mb-2 d-md-none"></div>

                                        </div>

                                        <div class="col-md-3">

                                            <label>{{translate('Weight')}}:</label>

                                            <input type="number" min="1" placeholder="{{translate('Weight')}}" name="weight" class="form-control weight-listener kt_touchspin_weight" onchange="calcTotalWeight()" value="1" />
                                            <div class="mb-2 d-md-none"></div>

                                        </div>


                                    </div>
                                </div>
                            </div>


                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>{{translate('Amount to be Collected')}}:</label>
                                        <input id="kt_touchspin_3" class="amount_to_be_collected" placeholder="{{translate('Amount to be Collected')}}" type="text" min="0" class="form-control" value="0" name="Shipment[amount_to_be_collected]" />
                                    </div>
                                </div>
                            </div>
                     <div class="row">
                                <div class="col-md-12" style="display: none">
                                    <div class="form-group">
                                        <label>{{translate('المبلغ المراد توريده')}}:</label>
                                        <input
                                         id="kt_touchspin_3"
                                        placeholder=
                                        "{{translate('amount to be supply')}}"
                                         type="number"
                                         class="form-control amount_to_be_supply"
                                         value=""
                                          name="Shipment[amount_to_be_supply]"
                                           />
                                    </div>
                                </div>
                            </div>


                            <div class="row">
                         <div class="col-md-4">
                                  <div class="form-group">
                                        <label>{{translate('تكاليف الشحن')}}:</label>
                                        <select class="form-control" id="shipment_price" name="Shipment[shipment_price]">
                                           @php
                                            $prices  = \App\StatePrice::get();
                                           @endphp
                                            @foreach($prices as $price)
                                                <option value="{{$price->price}}">{{translate($price->state->name)}} - {{translate($price->price)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{translate('Delivery Time')}}:</label>
                                        <select class="form-control kt-select2 delivery-time" id="delivery_time" name="Shipment[delivery_time]">
                                            @foreach($deliveryTimes as $deliveryTime)
                                                <option value="{{$deliveryTime->name}}">{{translate($deliveryTime->name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>{{translate('Total Weight')}}:</label>
                                        <input id="kt_touchspin_4" placeholder="{{translate('Total Weight')}}" type="text" min="1" class="form-control total-weight" value="1" name="Shipment[total_weight]" />
                                    </div>
                                </div>

                            </div>




                        </div>

                    </div>





                    {!! hookView('shipment_addon',$currentView) !!}

                    <div class="mb-0 text-right form-group">
                        <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                    </div>
                </div>
        </form>

    </div>
</div>

@endsection

@section('script')
<script src="{{ static_asset('assets/dashboard/js/geocomplete/jquery.geocomplete.js') }}"></script>
<script src="//maps.googleapis.com/maps/api/js?libraries=places&key={{$checked_google_map->key}}"></script>

<script type="text/javascript">
    $('.address-receiver').each(function(){
        var address = $(this);

        var lat = '{{$shipment->reciver_lat}}';
        lat = parseFloat(lat);
        var lng = '{{$shipment->reciver_lng}}';
        lng = parseFloat(lng);

        address.geocomplete({
            map: ".map_canvas.map-receiver",
            mapOptions: {
                zoom: 18,
                center: { lat: lat, lng: lng },
            },
            markerOptions: {
                draggable: true
            },
            details: ".location-receiver",
            detailsAttribute: 'data-receiver',
            autoselect: true,
            restoreValueAfterBlur: true,
        });
        address.bind("geocode:dragged", function(event, latLng){
            $("input[data-receiver=lat]").val(latLng.lat());
            $("input[data-receiver=lng]").val(latLng.lng());
        });
    });


    $('.select-client').select2({
        placeholder: "Select Client",
    });
    $('.select-client').change(function(){

        var client_phone = $(this).find(':selected').data('phone');

        document.getElementById("client_phone").value = client_phone;
    })
    $('.select-branch').select2({
        placeholder: "Select Branch",
    });
    $(document).ready(function() {
        var inputs = document.getElementsByTagName('input');

        for (var i = 0; i < inputs.length; i++) {
            if (inputs[i].type.toLowerCase() == 'number') {
                inputs[i].onkeydown = function(e) {
                    if (!((e.keyCode > 95 && e.keyCode < 106) ||
                            (e.keyCode > 47 && e.keyCode < 58) ||
                            e.keyCode == 8)) {
                        return false;
                    }
                }
            }
        }
        $('#kt_datepicker_3').datepicker({
            orientation: "bottom auto",
            autoclose: true,
            format: 'yyyy-mm-dd',
            todayBtn: true,
            todayHighlight: true,
			startDate: new Date(),
        });
        $('#kt_repeater_1').repeater({
            initEmpty: false,

            defaultValues: {
                'text-input': 'foo'
            },

            show: function() {
                $(this).slideDown();
                $('.dimensions_r').TouchSpin({
                    buttondown_class: 'btn btn-secondary',
                    buttonup_class: 'btn btn-secondary',

                    min: -1000000000,
                    max: 1000000000,
                    stepinterval: 50,
                    maxboostedstep: 10000000,
                });
            },

            hide: function(deleteElement) {
                $(this).slideUp(deleteElement);
            }
        });

        $('#kt_touchspin_2, #kt_touchspin_2_2').TouchSpin({
            buttondown_class: 'btn btn-secondary',
            buttonup_class: 'btn btn-secondary',

            min: -1000000000,
            max: 1000000000,
            stepinterval: 50,
            maxboostedstep: 10000000,
            prefix: '%'
        });
        $('#kt_touchspin_3').TouchSpin({
            buttondown_class: 'btn btn-secondary',
            buttonup_class: 'btn btn-secondary',

            min: -1000000000,
            max: 1000000000,
            stepinterval: 50,
            maxboostedstep: 10000000,
            prefix: '{{currency_symbol()}}'
        });
        $('#kt_touchspin_3_3').TouchSpin({
            buttondown_class: 'btn btn-secondary',
            buttonup_class: 'btn btn-secondary',

            min: -1000000000,
            max: 1000000000,
            stepinterval: 50,
            maxboostedstep: 10000000,
            prefix: '{{currency_symbol()}}'
        });
        $('#kt_touchspin_4').TouchSpin({
            buttondown_class: 'btn btn-secondary',
            buttonup_class: 'btn btn-secondary',

            min: -1000000000,
            max: 1000000000,
            stepinterval: 50,
            maxboostedstep: 10000000,
            prefix: 'Kg'
        });
        $('#kt_touchspin_weight').TouchSpin({
            buttondown_class: 'btn btn-secondary',
            buttonup_class: 'btn btn-secondary',

            min: -1000000000,
            max: 1000000000,
            stepinterval: 50,
            maxboostedstep: 10000000,
            prefix: 'Kg'
        });
        $('.dimensions_r').TouchSpin({
            buttondown_class: 'btn btn-secondary',
            buttonup_class: 'btn btn-secondary',

            min: -1000000000,
            max: 1000000000,
            stepinterval: 50,
            maxboostedstep: 10000000,
        });

        $('#kt_touchspin_qty').TouchSpin({
            buttondown_class: 'btn btn-secondary',
            buttonup_class: 'btn btn-secondary',

            min: -1000000000,
            max: 1000000000,
            stepinterval: 50,
            maxboostedstep: 10000000,
        });
        FormValidation.formValidation(
            document.getElementById('kt_form_1'), {
                fields: {
                    "Shipment[type]": {
                        validators: {
                            notEmpty: {
                                message: '{{translate("This is required!")}}'
                            }
                        }
                    },
                    "Shipment[shipping_date]": {
                        validators: {
                            notEmpty: {
                                message: '{{translate("This is required!")}}'
                            }
                        }
                    },
                    "Shipment[branch_id]": {
                        validators: {
                            notEmpty: {
                                message: '{{translate("This is required!")}}'
                            }
                        }
                    },
                    "Shipment[client_id]": {
                        validators: {
                            notEmpty: {
                                message: '{{translate("This is required!")}}'
                            }
                        }
                    },
                    "Shipment[client_address]": {
                        validators: {
                            notEmpty: {
                                message: '{{translate("This is required!")}}'
                            }
                        }
                    },
                    "Shipment[client_phone]": {
                        validators: {
                            notEmpty: {
                                message: '{{translate("This is required!")}}'
                            }
                        }
                    },
                    "Shipment[payment_type]": {
                        validators: {
                            notEmpty: {
                                message: '{{translate("This is required!")}}'
                            }
                        }
                    },
                    "Shipment[payment_method_id]": {
                        validators: {
                            notEmpty: {
                                message: '{{translate("This is required!")}}'
                            }
                        }
                    },
                    "Shipment[tax]": {
                        validators: {
                            notEmpty: {
                                message: '{{translate("This is required!")}}'
                            }
                        }
                    },
                    "Shipment[insurance]": {
                        validators: {
                            notEmpty: {
                                message: '{{translate("This is required!")}}'
                            }
                        }
                    },
                    "Shipment[shipping_cost]": {
                        validators: {
                            notEmpty: {
                                message: '{{translate("This is required!")}}'
                            }
                        }
                    },
                    "Shipment[delivery_time]": {
                        validators: {
                            notEmpty: {
                                message: '{{translate("This is required!")}}'
                            }
                        }
                    },
                    "Shipment[delivery_time]": {
                        validators: {
                            notEmpty: {
                                message: '{{translate("This is required!")}}'
                            }
                        }
                    },
                    "Shipment[total_weight]": {
                        validators: {
                            notEmpty: {
                                message: '{{translate("This is required!")}}'
                            }
                        }
                    },
                    "Shipment[reciver_name]": {
                        validators: {
                            notEmpty: {
                                message: '{{translate("This is required!")}}'
                            }
                        }
                    },
                    "Shipment[reciver_phone]": {
                        validators: {
                            notEmpty: {
                                message: '{{translate("This is required!")}}'
                            }
                        }
                    },
                    "Shipment[reciver_address]": {
                        validators: {
                            notEmpty: {
                                message: '{{translate("This is required!")}}'
                            }
                        }
                    },

                },


                plugins: {
                    autoFocus: new FormValidation.plugins.AutoFocus(),
                    trigger: new FormValidation.plugins.Trigger(),
                    // Bootstrap Framework Integration
                    bootstrap: new FormValidation.plugins.Bootstrap(),
                    // Validate fields when clicking the Submit button
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    // Submit the form when all fields are valid
                    defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                    icon: new FormValidation.plugins.Icon({
                        valid: 'fa fa-check',
                        invalid: 'fa fa-times',
                        validating: 'fa fa-refresh',
                    }),
                }
            }
        );
    });



</script>
@endsection
