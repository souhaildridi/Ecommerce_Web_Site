<?php
@include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if (!isset($admin_id)) {
   header('location:login.php');
}

if (isset($_GET['update'])) {
   $user_id = $_GET['update'];
   $select_user = $conn->prepare("SELECT * FROM `users` WHERE id = ?");
   $select_user->execute([$user_id]);
   $fetch_user = $select_user->fetch(PDO::FETCH_ASSOC);

   if (!$fetch_user) {
      header('location:admin_users.php'); 
   }
} else {
   header('location:admin_users.php'); 
}

if (isset($_POST['update_user'])) {
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $user_type = $_POST['user_type'];
   $user_type = filter_var($user_type, FILTER_SANITIZE_STRING);

   $update_user = $conn->prepare("UPDATE `users` SET name = ?, email = ?, user_type = ? WHERE id = ?");
   $update_user->execute([$name, $email, $user_type, $user_id]);

   header('location:admin_users.php');
}

?>
<?php include 'head.phtml'; ?>

<?php include 'admin_header.php'; ?>
<section class="update-user">
   <h1 class="title">update user</h1>
   <form action="" method="POST">
      <div class="inputBox">
         <span>username :</span>
         <input type="text" name="name" value="<?= $fetch_user['name']; ?>" placeholder="update username" required class="box">
         <span>email :</span>
         <input type="email" name="email" value="<?= $fetch_user['email']; ?>" placeholder="update email" required class="box">
         <span>user type :</span>
         <select name="user_type" class="box" required>
            <option value="user" <?= ($fetch_user['user_type'] == 'user') ? 'selected' : ''; ?>>User</option>
            <option value="admin" <?= ($fetch_user['user_type'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
         </select>
      </div>
      <div class="flex-btn">
         <input type="submit" class="btn" value="update user" name="update_user">
         <a href="admin_users.php" class="option-btn">go back</a>
      </div>
   </form>
</section>

<?php include 'footer.phtml'; ?>

<script src="js/script.js"></script>

</body>
</html>
