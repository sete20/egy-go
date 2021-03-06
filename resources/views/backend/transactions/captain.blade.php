@extends('backend.layouts.app')


@section('sub_title'){{translate('Transactions')}}@endsection
@section('subheader')
    <!--begin::Subheader-->
    <div class="py-2 subheader py-lg-6 subheader-solid" id="kt_subheader">
        <div class="flex-wrap container-fluid d-flex align-items-center justify-content-between flex-sm-nowrap">
            <!--begin::Info-->
            <div class="flex-wrap mr-1 d-flex align-items-center">
                <!--begin::Page Heading-->
                <div class="flex-wrap mr-5 d-flex align-items-baseline">
                    <!--begin::Page Title-->
                    <h5 class="my-1 mr-5 text-dark font-weight-bold">{{translate('Transactions')}}</h5>
                    <!--end::Page Title-->
                    <!--begin::Breadcrumb-->
                    <ul class="p-0 my-2 mr-5 breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold font-size-sm">
                        <li class="breadcrumb-item text-muted">
                            <a href="{{ route('admin.dashboard')}}" class="text-muted">{{translate('Dashboard')}}</a>
                        </li>
                        <li class="breadcrumb-item text-muted">
                            <a href="#" class="text-muted">{{ translate('Transactions') }}</a>
                        </li>
                    </ul>
                    <!--end::Breadcrumb-->
                </div>
                <!--end::Page Heading-->
            </div>
            <!--end::Info-->
        </div>
    </div>
    <!--end::Subheader-->
@endsection

@section('content')

<!--begin::Card-->
<div class="card card-custom gutter-b">
    <div class="flex-wrap py-3 card-header">
        <div class="card-title">
            <h3 class="card-label">
                {{$page_name}}
            </h3>
        </div>
    </div>
    <div class="m-5" id="tableForm">
        <table class="table mb-0 aiz-table"  data-show-toggle="true" data-toggle-column="first">
            <thead>
                <tr>
                    <th width="3%">#</th>
                    <th>{{translate('balance')}}</th>
                    <th>{{translate('name')}}</th>
                    <th>{{translate('email')}}</th>
                    <th>{{translate('responsible mobile')}}</th>
                    <th>{{translate('status')}}</th>


                    <th data-breakpoints="all" data-title="-">{{translate('Description')}}</th>
                </tr>
            </thead>
            <tbody>

                @foreach($dues as $key=>$due)
                    <tr @if($loop->first) data-expanded="true" @endif>
                        <td width="3%">{{ ($key+1)  }}</td>

                        <td>
                            {{ $due->value }}
                        </td>
                        <td>
                            {{ $due->captain->name }}
                        </td>

                        <td>
                            {{ $due->captain->email }}
                        </td>
                               <td>
                            {{ $due->captain->responsible_mobile }}
                        </td>
                               <td>

                            @if($due->status == 'pending' || $due->status=='none')
                             <form action="{{ route('client.supply.store',$due) }}" method="POST">
                              @csrf
                                <button type="submit" class="btn btn-primary">
                                    ?????????? ?????????? ????????????????
                                </button>
                            </form>
                            @else
                              <button disabled class="btn btn-primary">
                                    ???? ?????????? ????????????????
                                </button>
                        @endif
                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>
    </div>

    <div class="aiz-pagination">
        {{ $dues->appends(request()->input())->links() }}
    </div>
</div>

@endsection

@section('modal')
{{-- @include('modals.delete_modal') --}}
@endsection

@section('script')
    <script type="text/javascript">
    </script>
@endsection
