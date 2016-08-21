<div class="box box-success">
    <div class="box-header">
        <h3 class="box-title">Tippeinstellungen</h3>

    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
        {{ Form::label('kt_points', 'Kopftreffer (Punkte):') }}
        {{Form::text('kt_points', $settings->kt_points, ["class"=>"form-control"])}}

        {{ Form::label('tt_points', 'Tendenztreffer (Punkte):') }}
        {{Form::text('tt_points', $settings->tt_points, ["class"=>"form-control"])}}

        {{ Form::label('st_points', 'Siegtreffer (Punkte):') }}
        {{Form::text('st_points', $settings->st_points, ["class"=>"form-control"])}}

        {{ Form::label('m_points', 'Fehltipp (Punkte):') }}
        {{Form::text('m_points', $settings->m_points, ["class"=>"form-control"])}}
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->