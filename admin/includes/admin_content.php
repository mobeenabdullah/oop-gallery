<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
                Admin
                <small>Subheading</small>
            </h1>
            <ol class="breadcrumb">
                <li>
                    <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                </li>
                <li class="active">
                    <i class="fa fa-file"></i> Blank Page
                </li>
            </ol>
            <?php

            $user = User::find_user_by_id(3);

            $user->last_name = "Victor";

            $user->update();

            ?>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /.container-fluid -->