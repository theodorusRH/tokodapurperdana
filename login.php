<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
   <head>
      <meta charset="utf-8">
      <title>Dapur Perdana</title>
      <link rel="stylesheet" href="loginstyle.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
   </head>
   <body>
      <div class="bg-img">
         <div class="content">
            <header>LOGIN</header>

            <form method="POST" action="#">
               <div class="field">
                  <span class="fa fa-user"></span>
                  <input type="text" name="user"required placeholder="Username">
               </div>
               <div class="field space">
                  <span class="fa fa-lock"></span>
                  <input type="password" name="pass"class="pass-key" required placeholder="Password">
                  <span class="show">SHOW</span>
               </div>
               <div class="field">
                  <input type="submit" name="submit" value="LOGIN">
               </div>
               <?php
                  if(isset($_GET['redirect'])){
                        $url = $_GET['redirect'];
                        echo "<input type='hidden' name='redirect'>
                        value ='$url'>";
                  }
               ?>
            </form>
            <?php
            if (isset($_POST['submit']))
            {
               $user = $_POST['user'];
               $pass = $_POST['pass'];

               $con = new mysqli("localhost","root","mysql","dbdapurperdana");

               $sql = "SELECT * FROM user WHERE username=? and password=?";
               $stmt = $con->prepare($sql);
               $stmt->bind_param("ss", $user,$pass);
               $stmt->execute();
               $result = $stmt->get_result();

               if ($row = $result->fetch_assoc())
               {
                  if ($pass === $row['password'])
                  {
                     echo "Password Benar.";

                     $_SESSION['nama'] = $row['username'];
                     $_SESSION['pwd'] = $row['password'];

                     if (isset($_POST['redirect']))
                        header("location: ".$_POST['redirect']);
                     else
                        header("location: index.php");

                  }
                  else
                     echo "Password Salah.";
               }
               else{
                  echo "User Tidak Ditemukan.";	
               }
               $con->close();

            }
            ?>
         </div>
      </div>

      <script>
         const pass_field = document.querySelector('.pass-key');
         const showBtn = document.querySelector('.show');
         showBtn.addEventListener('click', function(){
          if(pass_field.type === "password"){
            pass_field.type = "text";
            showBtn.textContent = "HIDE";
            showBtn.style.color = "#3498db";
          }else{
            pass_field.type = "password";
            showBtn.textContent = "SHOW";
            showBtn.style.color = "#222";
          }
         });
      </script>
   </body>
</html>