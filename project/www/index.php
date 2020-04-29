<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <style>
        body {
            font: 90%/1.45em "Helvetica Neue", HelveticaNeue, Verdana, Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #fff;
        }
    </style>

</head>

<body>

    <div class="card">
        <div class="card-body">
                <div class="row">
                    <div class="col-md-2 pl-1">
                        <!-- <div class="form-group" id="filter_col1" data-column="1">
                            <select name="JobID" class="form-control column_filter" id="col1_filter">
                                <option value="">All</option>
                                <option value="student">student</option>
                                <option value="teacher">teacher</option>
                                <option value="drive">drive</option>
                            </select>
                        </div> -->
                    </div>
                </div>
        </div>
    </div>
    <div class="card row">
        <div class="col-lg-12">
            <br>

            <header>
                <div class="table-responsive">
                    <table id="ex" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Job</th>
                                <th>Age</th>
                                <th>date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>A1</th>
                                <th>student</th>
                                <th>25</th>
                                <th>10/31/2018</th>
                            </tr>
                            <tr>
                                <th>A2</th>
                                <th>teacher</th>
                                <th>33</th>
                                <th>05/22/2018</th>
                            </tr>
                            <tr>
                                <th>A3</th>
                                <th>drive</th>
                                <th>25</th>
                                <th>07/13/2018</th>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </header>
        </div>
    </div>
  
</body>

<script>
    function filterColumn(i) {
        $('#ex').DataTable().column(i).search(
            $('#col' + i + '_filter').val()
        ).draw();
    }
    $('select.column_filter').on('change', function() {
        filterColumn($(this).parents('div').attr('data-column'));
    });
    $(document).ready(function() {
        $('#ex').DataTable({
            "dom": '<"toolbar">frtip'
        });

        $("div.toolbar").html('<div class="form-group" id="filter_col1" data-column="1"> <select name="JobID" class="form-control column_filter" id="col1_filter"> <option value="">All</option> <option value="student">student</option> <option value="teacher">teacher</option> <option value="drive">drive</option> </select> </div>');
    
    });
    
</script>
</html>