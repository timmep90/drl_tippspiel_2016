<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

@section('htmlheader')
    @include('layouts.partials.htmlheader')
@show

<body class="skin-green sidebar-mini">
<div>


    <!-- Content Wrapper. Contains page content -->
    <div>


        <div class="error-page">
            <h2 class="headline text-red">503</h2>
            <div class="error-content">
                <h3><i class="fa fa-warning text-red"></i> We are sorry. This page is currently under maintenance.</h3>
                <p>
                    Please try again later.
                </p>
            </div>
        </div><!-- /.error-page -->


    </div><!-- ./wrapper -->
</div>
</body>
</html>