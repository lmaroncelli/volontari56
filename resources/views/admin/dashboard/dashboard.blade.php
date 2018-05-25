@extends('layouts.grafica.app')

@section('titolo')
    Dashboard
@endsection


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                    <div class="row">
                        <div class="col-xs-12">
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table class="table table-bordered table-hover" id="tbl_preventivi">
                                    <thead>
                                        <tr>
                                            @foreach ($columns as $field => $name)
                                                <th>
                                                  {!!$name!!}
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($preventivi_arr as $title => $preventivi)
                                                @include('admin.dashboard.inc_display_preventivi_rows', ['preventivi' => $preventivi, 'title' => $title])
                                            @endforeach
                                    </tbody>
                                </table>
                                </div>
                            </div>
                            <!-- /.box-body -->
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
