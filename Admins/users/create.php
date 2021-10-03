<?php

require '../helpers/functions.php';
require '../helpers/checkLogin.php';
require '../helpers/dbConnection.php';
require '../helpers/checkPremAdmin.php';


# Form Logic ... 

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // CODE .... 

    $name = CleanInputs($_POST['name']);
    $email = CleanInputs($_POST['email']);
    $password = ($_POST['password']);
    $type_id = Sanitize($_POST['type_id'],1);

    $erros = [];
    # Validate Input ... 
    if (!validate($name, 1)) {
        $erros['names'] = "names Field Required";
    }


    if (!validate ($email,1))  {
        $erros['email'] = "email Field Required";
    } 
    elseif ((!validate($email,3))){
        $erros['email'] = "email Field Required1";
    }


    if (!validate ($password,1))  {
        $erros['password'] = "password Field Required";
    } 
    elseif (!validate ($password,4))  {
        $erros['password'] = "password Field Required1";
    } 


    if(!validate($type_id ,1)){
        $erros['type_id'] = "type_id Field Required";
    } 
    elseif(!validate($type_id ,2)){
        $erros['type_id'] = "type_id must be int";
    }



    if (count($erros) > 0) {

        $_SESSION['messages'] = $erros;
    } else {
        $password = md5($password);

        # db Logic 

        $sql = "insert into users (name,email,password,type_id) values ('$name','$email','$password',$type_id)";


        $op = mysqli_query($con, $sql);

        if ($op) {
            header("location: index.php");
        } else {
            $_SESSION['messages'] = ['error try again'];
        }
    }
}

//fetch data on select
$sql = "select * from userstype";
$op1 = mysqli_query($con , $sql);








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
                            <label for="exampleInputEmail1">name</label>
                            <input type="text" name="name" class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">email</label>
                            <input type="text" name="email" class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputName" aria-describedby="" placeholder="Enter password">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">type</label>
                            <select name="type_id" class="form-control">
                                <?php 
   
                                   while($rows = mysqli_fetch_assoc($op1)){
                                ?>

                                <option value="<?php echo $rows['id'];?>"> <?php echo $rows['name'];?> </option>

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