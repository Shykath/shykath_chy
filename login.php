<?php 
include 'header.php';
?>
<div class="py-5">
    <div class="container">
        <div class="row">
           <div class="col-md-12">
             <h4>Login & Registration</h4>
           </div>
        </div>
        <div class="row">
           <div class="col-md-6">
               <form method="post" action="<?php $_SERVER['PHP_SELF']?>">
                   <div class="mb-3">
                       <label for="email" class="form-label">Email address</label>
                       <input type="email" class="form-control" id="email" name="email" required>
                   </div>
                   <div class="mb-3">
                       <label for="password" class="form-label">Password</label>
                       <input type="password" class="form-control" id="password" name="password" required>
                   </div>
                   <button type="submit" name="login" class="btn btn-primary">Login</button>
                   <a href="register.php" class="btn btn-success">Register</a>
               </form>
               <?php
                if(isset($_POST['login'])) 
                {
                    include "connect.php";
                    $email = $_POST['email'];
                    $password = $_POST['password'];
                    $sql = "SELECT * FROM students WHERE email= '$email' AND password= '$password'"; 
                    $result = mysqli_query($con, $sql) or die("query faild");
                    $match = mysqli_num_rows($result);
                    if( $match == 1) {
                        //echo "Login successful";
                        header('Location: list.php');
                        }
                    else {
                        echo "Invalid email or password";
                    }
                    mysqli_close($con);
                }
               ?>
           </div>
        </div>
    </div>
</div>
<?php include 'footer.php';?>