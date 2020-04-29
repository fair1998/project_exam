<?php include("check_session.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include("../link.php"); ?>
    <title>จัดการข้อมูลระบบ</title>
</head>

<body class="animsition">
    <?php include("header.php"); ?>
    <?php include("../alert.php"); ?>

    <!-- content -->
    <div class="row">

        <!-- term -->
        <div class="col-lg-6">
            <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
                <div class="au-card-title" style="background-image:url('../images/bg-title-01.jpg');">
                    <div class="bg-overlay bg-overlay--blue"></div>
                    <h3>ภาคเรียน/ปีการศึกษา</h3>
                    <button class="au-btn-plus term_view" term_form_insert="term_form_insert" data-toggle="modal" data-target="#term_view">
                        <i class="zmdi zmdi-plus"></i>
                    </button>
                </div>
                <div class="au-task js-list-load">
                    <div class="myau-task__title">
                        <div class="input-group">
                            <input type="text" id="term_search" name="term_search" class=" form-control">
                            <div class="input-group-addon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </div>
                    <div class="au-task-list js-scrollbar3" id="term">
                    </div>
                </div>
            </div>
        </div>

        <!-- year -->
        <div class="col-lg-6">
            <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
                <div class="au-card-title" style="background-image:url('../images/bg-title-01.jpg');">
                    <div class="bg-overlay bg-overlay--blue"></div>
                    <h3>ปีการศึกษา</h3>
                    <button class="au-btn-plus year_view" year_form_insert="year_form_insert" data-toggle="modal" data-target="#year_view">
                        <i class="zmdi zmdi-plus"></i>
                    </button>
                </div>
                <div class="au-task js-list-load">
                    <div class="myau-task__title">
                        <div class="input-group">
                            <input type="text" id="year_search" name="year_search" class=" form-control">
                            <div class="input-group-addon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </div>
                    <div class="au-task-list js-scrollbar3" id="year">
                    </div>
                </div>
            </div>
        </div>

        <!-- department -->
        <div class="col-lg-6">
            <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
                <div class="au-card-title" style="background-image:url('../images/bg-title-01.jpg');">
                    <div class="bg-overlay bg-overlay--blue"></div>
                    <h3>แผนกวิชา</h3>
                    <button class="au-btn-plus department_view" department_form_insert="department_form_insert" data-toggle="modal" data-target="#department_view">
                        <i class="zmdi zmdi-plus"></i>
                    </button>
                </div>
                <div class="au-task js-list-load">
                    <div class="myau-task__title">
                        <div class="input-group">
                            <input type="text" id="department_search" name="department_search" class=" form-control">
                            <div class="input-group-addon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </div>
                    <div class="au-task-list js-scrollbar3" id="department">
                    </div>
                </div>
            </div>
        </div>

        <!-- class -->
        <div class="col-lg-6">
            <div class="au-card au-card--no-shadow au-card--no-pad m-b-40">
                <div class="au-card-title" style="background-image:url('../images/bg-title-01.jpg');">
                    <div class="bg-overlay bg-overlay--blue"></div>
                    <h3>ระดับชั้น</h3>
                    <button class="au-btn-plus myclass_view" myclass_form_insert="myclass_form_insert" data-toggle="modal" data-target="#myclass_view">
                        <i class="zmdi zmdi-plus"></i>
                    </button>
                </div>
                <div class="au-task js-list-load">
                    <div class="myau-task__title">
                        <div class="input-group">
                            <input type="text" id="myclass_search" name="myclass_search" class=" form-control">
                            <div class="input-group-addon">
                                <i class="fa fa-search"></i>
                            </div>
                        </div>
                    </div>
                    <div class="au-task-list js-scrollbar3" id="myclass">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end content -->

    <?php include("footer.php"); ?>

    <!-- term modal -->
    <div class="modal fade" id="term_view" tabindex="-1" role="dialog" aria-labelledby="term_view" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" id="term_show">
            </div>
        </div>
    </div>

    <!-- year modal -->
    <div class="modal fade" id="year_view" tabindex="-1" role="dialog" aria-labelledby="year_view" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" id="year_show">
            </div>
        </div>
    </div>

    <!-- department modal -->
    <div class="modal fade" id="department_view" tabindex="-1" role="dialog" aria-labelledby="department_view" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" id="department_show">
            </div>
        </div>
    </div>

    <!-- class modal -->
    <div class="modal fade" id="myclass_view" tabindex="-1" role="dialog" aria-labelledby="myclass_view" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content" id="myclass_show">
            </div>
        </div>
    </div>

    <?php include("../script.php"); ?>

    <script>
        // term load
        $(document).ready(function() {
            var term = "term";
            term_load_data();

            function term_load_data(term_sql) {
                $.ajax({
                    url: "system_controller.php",
                    method: "POST",
                    data: {
                        term_sql: term_sql,
                        term: term
                    },
                    success: function(data) {
                        $('#term').html(data);
                    }
                });
            }
            $('#term_search').keyup(function() {
                var term_search = $(this).val();
				  console.log(term_search)
                if (term_search != '') {
                    term_load_data(term_search);
                } else {
                    term_load_data();
                }
            });
        });
        $(document).on('click', '.term_view', function() {
            var term_form_insert = $(this).attr("term_form_insert");
            var term_form_update = $(this).attr("term_form_update");
            var term_form_delete = $(this).attr("term_form_delete");
            $.ajax({
                url: "system_controller.php",
                method: "POST",
                data: {
                    term_form_insert: term_form_insert,
                    term_form_update: term_form_update,
                    term_form_delete: term_form_delete
                },
                success: function(data) {
                    $('#term_show').html(data);
                }
            });
        });

        // year load
        $(document).ready(function() {
            var year = "year";
            year_load_data();

            function year_load_data(year_sql) {
                $.ajax({
                    url: "system_controller.php",
                    method: "POST",
                    data: {
                        year_sql: year_sql,
                        year: year
                    },
                    success: function(data) {
                        $('#year').html(data);
                    }
                });
            }
            $('#year_search').keyup(function() {
                var year_search = $(this).val();
                if (year_search != '') {
                    year_load_data(year_search);
                } else {
                    year_load_data();
                }
            });
        });
        $(document).on('click', '.year_view', function() {
            var year_form_insert = $(this).attr("year_form_insert");
            var year_form_update = $(this).attr("year_form_update");
            var year_form_delete = $(this).attr("year_form_delete");
            $.ajax({
                url: "system_controller.php",
                method: "POST",
                data: {
                    year_form_insert: year_form_insert,
                    year_form_update: year_form_update,
                    year_form_delete: year_form_delete
                },
                success: function(data) {
                    $('#year_show').html(data);
                }
            });
        });

        // department load
        $(document).ready(function() {
            var department = "department";
            department_load_data();

            function department_load_data(department_sql) {
                $.ajax({
                    url: "system_controller.php",
                    method: "POST",
                    data: {
                        department_sql: department_sql,
                        department: department
                    },
                    success: function(data) {
                        $('#department').html(data);
                    }
                });
            }
            $('#department_search').keyup(function() {
                var department_search = $(this).val();
                if (department_search != '') {
                    department_load_data(department_search);
                } else {
                    department_load_data();
                }
            });
        });
        $(document).on('click', '.department_view', function() {
            var department_form_insert = $(this).attr("department_form_insert");
            var department_form_update = $(this).attr("department_form_update");
            var department_form_delete = $(this).attr("department_form_delete");
            $.ajax({
                url: "system_controller.php",
                method: "POST",
                data: {
                    department_form_insert: department_form_insert,
                    department_form_update: department_form_update,
                    department_form_delete: department_form_delete
                },
                success: function(data) {
                    $('#department_show').html(data);
                }
            });
        });

        // class load
        $(document).ready(function() {
            var myclass = "myclass";
            myclass_load_data();

            function myclass_load_data(myclass_sql) {
                $.ajax({
                    url: "system_controller.php",
                    method: "POST",
                    data: {
                        myclass_sql: myclass_sql,
                        myclass: myclass
                    },
                    success: function(data) {
                        $('#myclass').html(data);
                    }
                });
            }
            $('#myclass_search').keyup(function() {
                var myclass_search = $(this).val();
                if (myclass_search != '') {
                    myclass_load_data(myclass_search);
                } else {
                    myclass_load_data();
                }
            });
        });
        $(document).on('click', '.myclass_view', function() {
            var myclass_form_insert = $(this).attr("myclass_form_insert");
            var myclass_form_update = $(this).attr("myclass_form_update");
            var myclass_form_delete = $(this).attr("myclass_form_delete");
            $.ajax({
                url: "system_controller.php",
                method: "POST",
                data: {
                    myclass_form_insert: myclass_form_insert,
                    myclass_form_update: myclass_form_update,
                    myclass_form_delete: myclass_form_delete
                },
                success: function(data) {
                    $('#myclass_show').html(data);
                }
            });
        });
    </script>
    <script src="../css_script/swal.js"></script>
</body>

</html>