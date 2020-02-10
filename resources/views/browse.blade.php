@extends('voyager::bread.browse')

@section('content')
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel ">
                    <div class="panel-body">
                        <div class="form-group pull-right">
                            <a href="{{ route('voyager_excel.export.post') }}" class=" btn btn-primary" >{{__('voyager_excel::excel.export_excel')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @parent
@endsection