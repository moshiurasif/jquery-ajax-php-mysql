<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/milligram/1.4.1/milligram.css">
    <style>
        #error-message {
            position: absolute;
            background-color: #eeeeee;
            color: red;
            display: none;
            padding: 15px;
            margin: 15px;
            right: 15px;
            top: 15px;
        }

        #success-message {
            position: absolute;
            background-color: #eeeeee;
            color: green;
            display: none;
            padding: 15px;
            margin: 15px;
            right: 15px;
            top: 15px;
        }

        #modal {
            background-color: rgba(0, 0, 0, 0.7);
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 100;
            display: none;
        }

        #modal-form {
            position: relative;
            background-color: #fff;
            padding: 20px;
            width: 40%;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 5px;

        }

        #close-btn {
            background-color: red;
            color: #fff;
            width: 30px;
            height: 30px;
            text-align: center;
            line-height: 30px;
            border-radius: 50%;
            position: absolute;
            top: -15px;
            right: -15px;
            cursor: pointer;
        }

        #pagination {
            text-align: center;
        }

        a {
            display: inline-block;
            background-color: purple;
            color: #fff;
            text-align: center;
            margin: 3px;
            width: 30px;
            height: 30px;
            line-height: 30px;
            border-radius: 5px;
        }

        .active {
            background-color: green;
        }
    </style>
</head>

<body>
    <div class="container">

        <div class="row">
            <div id="modal">
                <div id="modal-form">
                    <h2>Edit Data</h2>
                    <form action=""></form>

                    <div id="close-btn">X</div>
                </div>
            </div>
            <div class="column column-40 column-offset-20">
                <form id="form-data">
                    <fieldset>
                        <label for="fname">First Name</label>
                        <input type="text" placeholder="First Name" id="fname">
                        <label for="lname">Last Name</label>
                        <input type="text" placeholder="Last Name" id="lname">
                        <input class="button-primary" type="submit" value="Submit" id="btn-submit">
                    </fieldset>
                </form>
            </div>
        </div>
        <!-- search -->
        <div class="row">
            <div class="column column-20 column-offset-80">
                <label for="search">Search:</label>
                <input type="text" placeholder="Live Search" id="search">
            </div>
        </div>
        <!-- search -->
        <div class="row">
            <div class="column">
                <div id="load-table"></div>
                <div id="error-message"></div>
                <div id="success-message"></div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            function loadData(page) {
                $.ajax({
                    url: "ajax-load.php",
                    type: "POST",
                    data: {
                        page_no: page
                    },
                    success: function(data) {
                        $("#load-table").html(data)
                    }
                })
            }
            loadData();

            // pagination
            $(document).on("click", "#pagination a", function(e) {
                e.preventDefault();
                let page_id = $(this).attr("id");
                loadData(page_id);
            })

            // insert data
            $("#btn-submit").on("click", function(e) {
                e.preventDefault();
                let fname = $("#fname").val();
                let lname = $("#lname").val();
                if (fname == "" || lname == "") {
                    $("#error-message").html("All fields required").slideDown();
                    $("#success-message").slideUp();
                } else {
                    $.ajax({
                        url: "ajax-insert.php",
                        type: "POST",
                        data: {
                            first_name: fname,
                            last_name: lname
                        },
                        success: function(data) {
                            if (data == 1) {
                                loadData();
                                $("#form-data").trigger('reset');
                                $("#success-message").html("data inserted successfully").slideDown();
                                $("#error-message").slideUp();
                            } else {
                                $("#error-message").html("data not saved").slideDown();
                                $("#success-message").slideUp();
                            }
                        }
                    })

                }

            })
            // delete data
            $(document).on("click", ".delete-btn", function() {
                if (confirm("Are you sure delete data?")) {
                    let studentId = $(this).data("id");
                    let element = this;
                    $.ajax({
                        url: "delete-ajax.php",
                        type: "POST",
                        data: {
                            id: studentId
                        },
                        success: function(data) {
                            if (data == 1) {
                                $(element).closest("tr").fadeOut();
                            } else {
                                $("#error-message").html("Data not deleted").slideDown();
                                $("#success-message").slideUp();
                            }
                        }
                    })
                }

            })
            // edit data
            $(document).on("click", ".edit-btn", function() {
                $("#modal").show();
                let studentId = $(this).data("eid");
                $.ajax({
                    url: "edit-form.php",
                    type: "POST",
                    data: {
                        id: studentId
                    },
                    success: function(data) {
                        $("#modal-form form").html(data);
                    }
                })


            })
            // modal hide
            $("#close-btn").on("click", function() {
                $("#modal").hide();
            })
            $(document).on("click", "#btn-submit-edit", function() {
                let sId = $("#edit-id").val();
                let fname = $("#fname-edit").val();
                let lname = $("#lname-edit").val();
                $.ajax({
                    url: "ajax-edit.php",
                    type: "POST",
                    data: {
                        id: sId,
                        first_name: fname,
                        last_name: lname
                    },
                    success: function(data) {
                        if (data == 1) {
                            $("#modal").hide();
                        } else {
                            $("#error-message").html("data not updated").slideDown();
                            $("#success-message").slideUp();
                        }
                    }
                })
            })

            // search data
            $("#search").on("keyup", function() {
                let searchText = $(this).val();
                $.ajax({
                    url: "ajax-search.php",
                    type: "POST",
                    data: {
                        search: searchText
                    },
                    success: function(data) {
                        $("#load-table").html(data);
                    }
                })
            })

            // pagination

        })
    </script>
</body>

</html>