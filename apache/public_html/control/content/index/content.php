<div class="container-fluid GLOBALdesign">
<div class="row">
    <nav class="col-sm-2">
      <ul class="nav nav-pills nav-stacked">
        <li><h3>Services</h3></li>
        <li><a href="/control/index">General info</a></li>
        <li><a href="/control/index?select=alarm">Alarm management</a></li>
        <li><a href="/control/index?select=log">Log management</a></li>
        <li><a href="/control/index?select=code">Code management</a></li>
        <li><a href="/control/index?select=subscription">Subscription</a></li>
        <li><a href="/control/index?select=agents">Agents monitoring</a></li>
      </ul>
    </nav>
    <div class="col-sm-10">
    <?php echo menu_line($web_page_name);
          echo $_SESSION["uploade_feedback"];
          unset($_SESSION["uploade_feedback"]);
          //echo "<h2>Dashboard</h2>";
          echo $dashboard_content;
    ?>

    </div>
  </div>
</div>