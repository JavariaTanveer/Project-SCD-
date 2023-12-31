<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};
if(isset($_POST['send'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg'];
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_message = $conn->prepare("SELECT * FROM `messages` WHERE name = ? AND email = ? AND number = ? AND message = ?");
   $select_message->execute([$name, $email, $number, $msg]);

   if($select_message->rowCount() > 0){
      $message[] = 'already sent message!';
   }else{

      $insert_message = $conn->prepare("INSERT INTO `messages`(user_id, name, email, number, message) VALUES(?,?,?,?,?)");
      $insert_message->execute([$user_id, $name, $email, $number, $msg]);

      $message[] = 'sent message successfully!';

   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>
   
<!-- header section starts  -->
<?php include 'components/user_header.php'; ?>
<!-- header section ends -->

<div class="heading">
   <h3>contact us</h3>
   <p><a href="home.php">home</a> <span> / contact</span></p>
</div>

<!-- contact section starts  -->
<style>

h3 {
  text-align: center;
  margin-bottom: 20px;
}


label {
  font-weight: bold;
  display: block;
  margin-bottom: 5px;
  font-size: 15px;
}

.required::after {
  content: '*';
  color: red;
  margin-left: 5px;
}
</style>
<section class="contact">

   <div class="row">

      <div class="image">
         <img src="images/contact-img.svg" alt="">
      </div>

      <form action="" method="post">
   <h3>Tell Us Something!</h3>

   <label for="name" align="Left">Enter Your Name:<span class="required"></span></label>
   <input type="text" id="name" name="name" maxlength="50" class="box" placeholder="Enter your name" required>

   <label for="number" align="Left">Enter Your Number:<span class="required"></span></label>
   <input type="number" id="number" name="number" min="0" max="9999999999" class="box" placeholder="Enter your number" required maxlength="10">

   <label for="email" align="Left">Enter Your Email:<span class="required"></span></label>
   <input type="email" id="email" name="email" maxlength="50" class="box" placeholder="Enter your email" required>

   <label for="msg" align="Left">Enter Your Message:<span class="required"></span></label>
   <textarea id="msg" name="msg" class="box" required placeholder="Enter your message" maxlength="500" cols="30" rows="10"></textarea>

   <input type="submit" value="Send Message" name="send" class="btn">
</form>


   </div>

</section>

<!-- contact section ends -->










<!-- footer section starts  -->
<?php include 'components/footer.php'; ?>
<!-- footer section ends -->








<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>