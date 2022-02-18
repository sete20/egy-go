@extends('backend.layouts.app')

@section('content')
<style>
    label {
        font-weight: bold !important;
    }
</style>
<div class="mx-auto col-lg-12">
    <div class="card">

        <div class="card-header">
            <h5 class="mb-0 h6">{{translate('Add State Price')}}</h5>
        </div>

        <form class="form-horizontal" action="{{ route('price.store') }}" id="kt_form_1" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{translate('States')}}:</label>
                                    <select class="form-control kt-select2 select-branch" name="state_id" onchange="enable_select(this)">
                                        @foreach($states as $key=>$state)
                                            <option value="{{$state->id}}">{{$state->name}}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>


                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{translate('Amount')}}:</label>
                                    <input id="kt_touchspin_4" placeholder="{{translate('Amount')}}" type="number" class="form-control total-weight" value="0" name="price" />
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="mb-0 text-right form-group">
                            <button type="submit" class="btn btn-sm btn-primary">{{translate('Save')}}</button>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

@endsection

@section('script')
    <script type="text/javascript">

    </script>
@endsection
