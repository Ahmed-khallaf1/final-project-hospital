<?php

require '../helpers/functions.php';
require '../helpers/dbConnection.php';


# Validate & Sanitize id 

$id = Sanitize($_GET['id'], 1);


if (!validate($id, 2)) {

    $_SESSION['messages'] = "invalid id ";
    header("Location: index.php");
}





# Form Logic ... 

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    

    // CODE .... 
    $patient_id = Sanitize($_POST['patient_id'], 1);
    $appointments_id = Sanitize($_POST['appointments_id'], 1);


    $erros = [];
    # Validate Input ... 
    if (!validate($patient_id, 1)) {
        $erros['names'] = "names Field Required";
    }


    if (!validate($appointments_id, 1)) {
        $erros['email'] = "email Field Required";
    }




    if (count($erros) > 0) {

        $_SESSION['messages'] = $erros;
    } else {
        // $password = sha1($password);

        # db Logic 
        $sql = "update reservation set  patient_id =  $patient_id,appointments_id=$appointments_id where id = $id";
        $op = mysqli_query($con, $sql);
        if ($op) {

            $_SESSION['messages'] = 'Record Updated';

            header("location: index.php");
      
        } else {
            $_SESSION['errormessages'] = ['error try again'];
        }
    }
}

# Fetch data ... 
$sql  = "select * from users where type_id=3";
$op   = mysqli_query($con, $sql);
$data = mysqli_fetch_assoc($op);

$sql1 = "select * from users where type_id=2";
$op1 = mysqli_query($con, $sql1);





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

                    if (isset($_SESSION['errormessages'])) {
                        foreach ($_SESSION['errormessages'] as  $value) {
                            # code...
                            echo '<li class="breadcrumb-item active">' . $value . '</li>';
                        }

                        unset($_SESSION['errormessages']);
                    } else {
                        echo '<li class="breadcrumb-item active">Dashboard</li>';
                    }

                    ?>


                </ol>



                <div class="container">

                    <form method="post" action="edit.php?id=<?php echo $data['id']; ?>" enctype="multipart/form-data">



                        <div class="form-group">
                            <label for="exampleInputPassword1">patient_id</label>
                            <select name="patient_id" class="form-control">
                                <?php

                                while ($rows = mysqli_fetch_assoc($op)) {
                                ?>

                                    <option value="<?php echo $rows['id']; ?>"> <?php echo $rows['name']; ?> </option>

                                <?php } ?>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">appointments_id</label>
                            <select name="appointments_id" class="form-control">
                                <?php

                                while ($rows1 = mysqli_fetch_assoc($op1)) {
                                ?>

                                    <option value="<?php echo $rows1['id']; ?>"> <?php echo $rows1['name']; ?> </option>

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