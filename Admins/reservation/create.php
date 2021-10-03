<?php

require '../helpers/functions.php';
require '../helpers/dbConnection.php';

# Form Logic ... 

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // CODE .... 
    $patient_id = Sanitize($_POST['patient_id'],1);
    $appointments_id = Sanitize($_POST['appointments_id'],1);


    $erros = [];
    # Validate Input ... 
    if (!validate($patient_id, 1)) {
        $erros['names'] = "names Field Required";
    }


    if (!validate ( $appointments_id,1))  {
        $erros['email'] = "email Field Required";
    } 
    


   


    



    if (count($erros) > 0) {

        $_SESSION['messages'] = $erros;
    } else {

        # db Logic 

        $sql = "insert into reservation (patient_id,appointment_id ) values ($patient_id, $appointments_id)";


        $op = mysqli_query($con, $sql);
      

        if ($op) {
            header("location: index.php");
        } else {
            $_SESSION['messages'] = ['error try again'];
        }
    }
}

//fetch data on select
$sql1 = "select * from users where type_id=3";
$op1 = mysqli_query($con , $sql1);



$sql2 = "select * from appointments";
$op2 = mysqli_query($con , $sql2);








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
                            <label for="exampleInputPassword1">patient_id</label>
                            <select name="patient_id" class="form-control">
                                <?php 
   
                                   while($rows = mysqli_fetch_assoc($op1)){
                                ?>

                                <option value="<?php echo $rows['id'];?>"> <?php echo $rows['id'];?> </option>

                                <?php } ?>

                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">appointments_id</label>
                            <select name="appointments_id" class="form-control">
                                <?php 
   
                                   while($rows1 = mysqli_fetch_assoc($op2)){
                                ?>

                                <option value="<?php echo $rows1['id'];?>"> <?php echo $rows1['doctor_id'];?> </option>

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