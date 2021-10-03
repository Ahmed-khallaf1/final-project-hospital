   <?php 

     require './helpers/functions.php';
     require './helpers/dbConnection.php';

     if($_SERVER['REQUEST_METHOD'] == "POST"){
    
         $email = CleanInputs($_POST['email']) ;
         $password = $_POST['password'];

         $errors = [];
         if(!validate($email,1)){

            $errors['email'] = "Email Field Required";

         }elseif(!validate($email,3)){
           $errors['email']  = "Invalid Email";
         }


         if(!validate($password,4)){

            $errors['password'] = "Password Length Must > 5 ch";
         }


         if(count($errors) > 0){


          foreach ($errors as $key => $value) {
              # code...
              echo '*'.$value.'<br>';
          }

         }else{

            // code .... 

            $password = md5($password);

            $sql = "select * from users where email = '$email' and password = '$password'";

            $op = mysqli_query($con,$sql);

            $num = mysqli_num_rows($op);

            if($num == 1){
              // code 

              $data = mysqli_fetch_assoc($op);

              $_SESSION['user'] = $data;

              header("Location: ".url(''));

            }else{

                echo 'error try again';
            }




         }




     }








      require 'header.php';
   
   ?>

    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                                <input class="form-control py-4"  name ="email"   id="inputEmailAddress" type="email" placeholder="Enter email address" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" name="password" for="inputPassword">Password</label>
                                                <input class="form-control py-4" id="inputPassword"  name= "password" type="password" placeholder="Enter password" />
                                            </div>
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" />
                                                    <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                                                </div>
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="password.html">Forgot Password?</a>
                                                <input type="submit" class="btn btn-primary" value="Login">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="small"><a href="http://localhost/group5/blog/admins/users/create.php">Need an account? Sign up!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2020</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?php echo url('Mainassets/js/scripts.js')?>"></script>
    </body>
</html>
