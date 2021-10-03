<?php

require '../helpers/functions.php';
require '../helpers/dbConnection.php';

# Form Logic ... 

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // CODE .... 

    $app_from = CleanInputs($_POST['app_from']);
    $app_to = CleanInputs($_POST['app_to']);
    $doctor_id = Sanitize($_POST['doctor_id'], 1);

    $erros = [];
    # Validate Input ... 
    if (!validate($app_from, 1)) {
        $erros['app_from'] = "app_from Field Required";
    }



    if (!validate($app_to, 1)) {
        $erros['app_to'] = "app_to Field Required";
    }
    

    if (!validate($doctor_id, 1)) {
        $erros['doctor_id'] = "doctor_id Field Required";
    } elseif (!validate($doctor_id, 2)) {
        $erros['doctor_id'] = "doctor_id Field Required1";
    }






    if (count($erros) > 0) {

        $_SESSION['messages'] = $erros;
    } else {
        // $password = sha1($password);

        # db Logic 

        $sql = "insert into appointments (app_from,app_to,doctor_id) values ('$app_from','$app_to','$doctor_id')";


        $op = mysqli_query($con, $sql);

        if ($op) {
            header("location: index.php");
        } else {
            $_SESSION['messages'] = ['error try again'];
        }
    }
}

//fetch data on select
$sql = "select * from users where type_id =2";
$op1 = mysqli_query($con, $sql);








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
                        foreach ($_SESSION['messages'] as  $value) {
                            # code...
                            echo '<li class="breadcrumb-item active">' . $value . '</li>';
                        }

                        unset($_SESSION['messages']);
                    } else {
                        echo '<li class="breadcrumb-item active">Dashboard</li>';
                    }

                    ?>


                </ol>



                <div class="container">

                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">



                        <div class="form-group">
                            <label for="exampleInputEmail1">app_from</label>
                            <input type="time" name="app_from" class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter app_from">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">app_to</label>
                            <input type="time" name="app_to" class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter name">
                        </div>
                      
                        <div class="form-group">
                            <label for="exampleInputPassword1">doctor_id</label>
                            <select name="doctor_id" class="form-control">
                                <?php

                                while ($rows = mysqli_fetch_assoc($op1)) {
                                ?>

                                    <option> <?php echo $rows['id'] . " / " . "Dr." . $rows['name'] ?> </option>

                                <?php } ?>

                            </select>
                        </div>


                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>



            </div>
        </main>




        <?php

        require '../footer.php';
        ?>