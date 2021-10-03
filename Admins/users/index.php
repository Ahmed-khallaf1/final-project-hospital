<?php

require '../helpers/functions.php';
require '../helpers/dbConnection.php';
require '../helpers/checkLogin.php';
require '../helpers/checkPremAdmin.php';




# fetch all admins Role ... 

$sql = "select users.*,userstype.name as name1 from users join userstype on users.type_id = userstype.id";
$op  =  mysqli_query($con, $sql);

//    echo  mysqli_error($con); 
//    exit();

require '../header.php';
require "../nav.php";
?>

<div id="layoutSidenav">

    <?php
    require '../sidNav.php';
    ?>



    <div id="layoutSidenav_content">
        <main>



            <div class="container-fluid">
                <h1 class="mt-4">Dashboard</h1>
                <ol class="breadcrumb mb-4">


                    <?php
                    # Dispaly error messages .... 

                    if (isset($_SESSION['messages'])) {

                        # code...
                        echo '<li class="breadcrumb-item active">' . $_SESSION['messages'] . '</li>';

                        unset($_SESSION['messages']);
                    } else {
                        echo '<li class="breadcrumb-item active">Display Roles</li>';
                    }

                    ?>

                </ol>




                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-table mr-1"></i>
                        DataTable Example
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    // $i = 1;
                                    while ($rows = mysqli_fetch_assoc($op)) {

                                    ?>
                                        <tr>
                                            <td><?php echo $rows['id']; ?></td>
                                            <td><?php echo $rows['name']; ?></td>
                                            <td><?php echo $rows['email']; ?></td>
                                            <td><?php echo $rows['name1']; ?></td>

                                            <td>
                                                <a href='delete.php?id=<?php echo $rows['id']; ?>' class='btn btn-danger m-r-1em'>Delete</a>
                                                <a href='edit.php?id=<?php echo $rows['id']; ?>' class='btn btn-primary m-r-1em'>Edit</a>
                                            </td>

                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>




        <?php

        require '../footer.php';
        ?>