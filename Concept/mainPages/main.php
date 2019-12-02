<?php require "../sharedParts/header.php"; ?>

  <!---MAIN----->
  <div class="main">
    <!--Section 1-->
    <div class="section1">
      <div>
        <h1 class="title">Capable Kids and Families</h1>
        <p>
          This is a short description of what we want to tell the world.
        </p>
      </div>
    </div>
    <!--Section 2-->
    <section onload="myFunction()">
        <script src="bar.js">
            function myFunction() {
                var data = [
                  {label: 'Jan', value: 123},
                  {label: 'Feb', value: 11},
                  {label: 'March', value: 55},
                  {label: 'April', value: 893},
                  {label: 'May', value: 343}
                ];
                var barChart = new BarChart("chart", 500, 500, data);
            }
        </script>
        <div id="chart">Bar Chart Goes here...?</div>

    </section>
    <!--Section 3-->
    <section>
    </section>
  </div>

<!---FOOTER--->
<?php require "../sharedParts/footer.php"; ?>
