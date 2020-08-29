<div class="container">
    <div class="row">
        <div class="col-md-12 mt-20 text-center">
            <h2>User Management</h2>
        </div>
        <div class="col-md-12 mt-20">
            <div class="mb-15 pull-right">
                <a href="#" class=""><i class="fa fa-user" aria-hidden="true"></i> <?php echo $this->session->userdata('user_name') ?></a> |
                <a href="<?php echo base_url('user/logout') ?>" class=""><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
                <a href="<?php echo base_url('register') ?>" class="btn btn-info"><i class="fa fa-plus" aria-hidden="true"></i> Add User</a>
            </div>
            <div class="pull-left">
                <!--                <div>
                                    <input type="text" name="search_term" placeholder="Search" class="dataSearch">
                                </div>-->
                <div class="d-flex">
                    <select name="search_on" class="searchon form-control mr-3">
                        <option value="user_name">User Name</option>
                        <option value="email">Email</option>
                        <option value="mobile">Mobile</option>
                        <option value="created_at">Created Date</option>
                        <option value="dob">DOB</option>
                    </select>
                    <input type="text" name="search_term" class="form-control dataSearch" placeholder="Search">
                </div>
                <div></div>
            </div>
        </div> 
        <div class="col-md-12">

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">DOB</th>
                        <th scope="col">Created Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody id="dataContainer"> 

                </tbody>
            </table>
            <div class="cp-pagination-row">
                <ul class="notification pagination justify-content-end pull-right">
                    <!--<li class="page-item"><a href="#"></a></li>-->
                </ul>
            </div>
        </div> 
    </div>

</div>

<script>
//    $(function () {
        var searchon = $('body').find(".searchon").children("option:selected").val();
        $('body').on("change", ".searchon", function (e) {
            console.log("$(this).val()")

            searchon = $(this).children("option:selected").val();
        });
        $(".dataSearch").on("keyup", function (e) {
            console.log($(this).val())
            //console.log(searchon)

            var searchTerm = $(this).val();
            //if (searchTerm.trim().length <= 2 || searchon.length <= 1)
            if (searchTerm.trim().length <= 0)
            {
                pagination(1);
                $(".cp-pagination-row").show();
                return;
            }

            $.ajax({
                type: 'POST',
                url: 'user/search',
                data: {searchterm: searchTerm, searchon: searchon},
                dataType: 'json',
                timeout: 3000,
                success: function (data) {
                    console.log(data)
                    $('#dataContainer').html(data.notifications);
                    $(".no-data-found").hide();
                    $(".cp-pagination-row").hide();


                },
                error: function () {
                }
            });
        })
        pagination(1);
        $('.pagination').on('click', 'li a', function (e) {
            e.preventDefault();
            pagination(this.id);
        });

        function pagination(page) {
            var pagination = '';
            if (page == "")
            {
                return;
            }
            $.ajax({
                type: 'POST',
                url: 'user/pagination',
                data: {page: page, per_page: 10},
                dataType: 'json',
                timeout: 3000,
                success: function (data) {
                    console.log(data)
                    if (data.totalrecords > 0)
                    {
                        $('#dataContainer').html(data.notifications);
                        $(".no-data-found").hide();
                    } else {
                        $(".cp-pagination-row").hide();
                        $(".no-data-found").show();
                    }
                    if (page == 1) {
                        pagination += '<li class="page-item">\n\
                                        <a class="page-link" style="cursor:not-allowed" >\n\
                                            <span aria-hidden="true">First</span>\n\
                                        </a>\n\
                                    </li>\n\
                                    <li class="page-item">\n\
                                        <a class="page-link" style="cursor:not-allowed" >\n\
                                            <span aria-hidden="true">Previous</span>\n\
                                        </a>\n\
                                    </li>';
                    } else {
                        pagination += '<li class="page-item"><a class="page-link" href="#" id="1" > <span aria-hidden="true">First</span> </a> </li> <li class="page-item"><a class="page-link" href="#" id="' + (page - 1) + '" > <span aria-hidden="true">Previous</span> </a> </li>';
                    }
                    for (var i = parseInt(page) - 3; i <= parseInt(page) + 3; i++) {
                        if (i >= 1 && i <= data.numPage) {
                            pagination += '<li';
                            if (i == page)
                                pagination += ' class="page-item"> <span class="page-link">' + i + '</span>';
                            else
                                pagination += ' ><a href="#" class="page-link" id="' + i + '">' + i + '</a>';
                            pagination += '</li>';
                        }
                    }
                    if (page == data.numPage) {
                        pagination += '<li class="page-item"><a class="page-link" style="cursor:not-allowed"> <span  aria-hidden="true">Next</span> </a> </li> <li><a class="page-link" style="cursor:not-allowed" > <span aria-hidden="true">Last</span> </a> </li>';
                    } else {
                        pagination += '<li class="page-item"><a  href="#" class="page-link" id="' + (parseInt(page) + 1) + '"> <span aria-hidden="true">Next</span> </a> </li> <li class="page-item"><a class="page-link" href="#"  id="' + data.numPage + '" > <span aria-hidden="true">Last</span> </a> </li>';
                    }
                    $('.pagination').html(pagination);
                },
                error: function () {
                }
            });
            return false;
        }

//    });
    function recordStatus(userId, status)
    {
        $.ajax({
            url: Site.url + "user/changeStatus",
            method: "POST",
            data: {userid: userId, status: status},
//            contentType: false,
//            cache: false,
//            processData: false,
            success: function (result)
            {
                console.log(result)
                if (result.error)
                {
                    $.notify(result.msg, "error");
                    $body.removeClass("loading");

                } else
                {
                    $.notify(result.msg, "success");
//                    pagination(1);
//                    location.href = Site.url;
                }
            },
            error: function (request, status, error)
            {
                $.notify(request.responseText, 'error');

            }
        });
    }

    function deleteRecord(userId)
    {
        if(confirm("Do you want to delete the record")){
            
             $("#user_" + userId).remove();
            $.ajax({
                url: Site.url + "user/deleteUser",
                method: "POST",
                data: {userid: userId},
    //            contentType: false,
    //            cache: false,
    //            processData: false,
                success: function (result)
                {
                    console.log(result)
                    if (result.error)
                    {
                        $.notify(result.msg, "error");
                        $body.removeClass("loading");

                    } else
                    {
                        $.notify(result.msg, "success");
                        pagination(1);
    //                    location.reload();
                    }
                },
                error: function (request, status, error)
                {
                    $.notify(request.responseText, 'error');

                }
            });
        }
        
    }
</script>
