<div class="container-fluid text-center">
    <h1 style="padding-top: 5%; color: white;">LogOps™</h1>
    <h2 style="padding-bottom: 5%; color: white;">A Cloud and Security hybrid system</h2>
</div>

<div class="container-fluid GLOBALdesign">
  <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-5">
      <?php echo $_SESSION["uploade_feedback"]; ?>
      <h1>Not customer yet?</h1>
      Don't worry, contact us, and we will help you.<br>
      When we have created your company in the systenm, you will get the <br>
      company key, you will need for the creatation of a new user<br>
    </div>
    <div class="col-md-5">
      <div class='well'>
      <h1>Login </h1>
        <form role="form">
          <div class="form-group">
          <label for="brugernavn">Username:</label>
          <input type="text" class="form-control" id="brugernavn">
          </div>
          <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" class="form-control" id="password">
          </div>
          <button type="submit" id="loginbutton" class="btn btn-default">Login</button>
          <span class="text-danger" id="loginfeedback"></span>
        </form>
        <a href="/user-recovery">Glemt password?</a>
      </div>
    </div>
    <div class="col-md-1"></div>
  </div>
  <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-5">
      <h1>Create new user</h1>
      <form role="form"  action="/content/login/create_user" method="post">
          <div class="form-group">  
          <label for="username">Username:</label>
          <input type="text" class="form-control" name="username" id="username">
          </div>
          
          <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" class="form-control" name="password" id="password">
          </div>

          <div class="form-group">
          <label for="repeat_password">Repeat password:</label>
          <input type="password" class="form-control" name="repeat_password" id="repeat_password">
          </div>

          <div class="form-group">
          <label for="company_key">Company key: (You have to require this from us)</label>
          <input type="text" class="form-control" name="company_key" id="company_key">
          </div>

          <button type="submit" class="btn btn-default">Create user</button>
      </form>
    </div>
    <div class="col-md-5">
    </div>
    <div class="col-md-1"></div>
  </div>
</div>
