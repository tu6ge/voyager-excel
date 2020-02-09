@extends('voyager::bread.browse')

@section('content')
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel ">
                    <div class="panel-body">
                        <div class="form-group pull-right">
                            <button class=" btn btn-primary" >导出 Excel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @parent
@endsection