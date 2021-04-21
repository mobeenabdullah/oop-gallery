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

            $user = new User();

            $user->username = "jsmith";
            $user->password = "jsmith123";
            $user->first_name = "John";
            $user->last_name = "Smith";

            $user->create();

            ?>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /.container-fluid -->