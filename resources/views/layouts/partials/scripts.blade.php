<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/js/app.min.js') }}" type="text/javascript"></script>
<!-- DataTables -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.js"></script>
<!-- Select2 Version 4.0.3 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script type="text/javascript">
    $('select').select2();
</script>
<script type="text/javascript">
    $(".single-tokenize").select2({
        tags: true,
        tokenSeparators: [',']
    })
</script>

<script>
  $( function () {
    $('.standard-table').DataTable({
      'aoColumnDefs': [
        {
          orderSequence: ["desc", "asc"],
          aTargets: ['_all']
        }
      ],
      'order': [[ 1, 'desc' ]],
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    });
  } );

  $( function () {
    $('.results-table').DataTable({
      'aoColumnDefs': [
        {
          orderSequence: ["desc", "asc"],
          aTargets: ['_all']
        }
      ],
      'paging'      : false,
      'order': [[ 10, 'desc' ]],
      'columns': [
        null,
        { "orderable": false },
        { "orderable": false },
        { "orderable": false },
        { "orderable": false },
        { "orderable": false },
        { "orderable": false },
        { "orderable": false },
        { "orderable": false },
        { "orderable": false },
        null,
        null
      ],
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    });
  } );
</script>



<script>


    $(document).ready(function() {
        setInterval(date, 1000);

        function date() {
            var dt = new Date($.now());

            var dt_text = ("0" + dt.getHours()).slice(-2) + ':' + ("0" + dt.getMinutes()).slice(-2) + ':' +
                    ("0" + dt.getSeconds()).slice(-2) +
                    '  ' + ("0" + dt.getDate()).slice(-2) + '.' + ("0" + (dt.getMonth()+1)).slice(-2) + '.' + dt.getFullYear();
            $('#date').html(dt_text);
        }
        return false;
    });

</script>

<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience. Slimscroll is required when using the
      fixed layout. -->