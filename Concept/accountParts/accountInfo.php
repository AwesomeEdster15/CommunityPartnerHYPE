


<div class="main">
  <!--Section 1-->
  <div class="section1">
    <div>
      <h1 class="title">Hello, <?php echo (isset($_SESSION["username"]) ? $_SESSION["username"] : "User") ?></h1>
      <p>
        This is where you can view or edit your account information!
      </p>
      <div style="width: 350px; display: inline-block;">
        <h3>Name</h3>
        <h4> <?php echo $_SESSION["firstName"] . " " . $_SESSION["lastInitial"] ?> </h4>
      </div>
      <div style="width: 350px; display: inline-block;">
        <h3>Username</h3>
        <h4> <?php echo $_SESSION["username"] ?></h4>
      </div>
      <br>
      <div style="width: 350px; display: inline-block;">
        <h3>Email</h3>
        <h4> <?php echo $_SESSION["email"] ?> </h4>
      </div>
      <div style="width: 350px; display: inline-block;">
        <h3>Phone Number</h3>
        <h4> <?php echo $_SESSION["phoneNumber"] ?></h4>
      </div>
    </div>
  </div>
  <!--Section 2-->
  <section>
  </section>
  <!--Section 3-->
  <section>
  </section>
</div>
