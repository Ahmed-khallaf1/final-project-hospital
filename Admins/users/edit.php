<?php

require '../helpers/functions.php';
require '../helpers/dbConnection.php';
require '../helpers/checkLogin.php';
require '../helpers/checkPremAdmin.php';




# Validate & Sanitize id 

$id = Sanitize($_GET['id'], 1);


if (!validate($id, 2)) {

    $_SESSION['messages'] = "invalid id ";
    header("Location: index.php");
}





# Form Logic ... 

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // CODE .... 

    $name = CleanInputs($_POST['name']);
    $email = CleanInputs($_POST['email']);
    // $password = ($_POST['password']);
    $type_id = Sanitize($_POST['type_id'],1);

    $erros = [];
    # Validate Input ... 
    if (!validate($name, 1)) {
        $erros['name'] = "name Field Required";
    }

    if (count($erros) > 0) {

        $_SESSION['errormessages'] = $erros;
    } else {

        # db Logic 
        $sql = "update users set name = '$name',email='$email',type_id ='$type_id' where id = $id";
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
$sql  = "select * from users where id=$id";
$op   = mysqli_query($con, $sql);
$data = mysqli_fetch_assoc($op);

$sql1 = "select * from userstype";
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
                            <label for="exampleInputEmail1">name</label>
                            <input type="text" name="name" value="<?php echo $data['name']; ?>" class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter Title">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">email</label>
                            <input type="text" name="email" value="<?php echo $data['email']; ?>" class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter Title">
                        </div>
                       
                        <div class="form-group">
                            <label for="exampleInputPassword1">type</label>
                            <select name="type_id" class="form-control">
                                <?php 
   
                                   while($rows = mysqli_fetch_assoc($op1)){
                                ?>

                                <option value="<?php echo $rows['id'];?>" <?php  if($data['type_id']== $rows['id']){echo 'selected';}?>> <?php echo $rows['name'];?> </option>

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