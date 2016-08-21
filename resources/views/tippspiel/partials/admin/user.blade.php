<div class="box box-success">
    <div class="box-header">
        <h3 class="box-title">Benutzerverwaltung</h3>

        <div class="box-tools">
            <ul class="pagination pagination-sm no-margin pull-right">
                @include('layouts.partials.paginator', ['paginator' => $users])
            </ul>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body no-padding">
        <table class="table">
            <tr>
                <th >Name</th>
                <th>Anmeldung</th>
                <th>Inaktiv?</th>
                <th>Admin?</th>
            </tr>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->user->name}}</td>
                    <td>{{$user->created_at}}</td>
                    <td>{{ Form::checkbox('pending_user['.$user->id.']', true, $user->pending) }}</td>
                    <td>{{ Form::checkbox('isAdmin_user['.$user->id.']', true, $user->isAdmin) }}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <!-- /.box-body -->
</div>
<!-- /.box -->