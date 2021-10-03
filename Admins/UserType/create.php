<?php

require '../helpers/functions.php';
require '../helpers/dbConnection.php';
require '../helpers/checkPremAdmin.php';


# Form Logic ... 

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // CODE .... 

    $name = CleanInputs($_POST['name']);

    $erros = [];
    # Validate Input ... 
    if (!validate($name, 1)) {
        $erros['names'] = "names Field Required";
    }

    if (count($erros) > 0) {

        $_SESSION['messages'] = $erros;
    } else {

        # db Logic 

        $sql = "insert into userstype (name) values ('$name')";

        $op = mysqli_query($con, $sql);

        if ($op) {
            header("location: index.php");
        } else {
            $_SESSION['messages'] = ['error try again'];
        }
    }
}








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


                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>



            </div>
        </main>




        <?php

        require '../footer.php';
        ?>