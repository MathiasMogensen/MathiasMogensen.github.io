<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title" id="loginModal">Login</h1>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="login">
            <form id="formLogin" class="login-form" method="post">
                <div class="form-group">
                    <input class="form-control" id="email" type="text" name="login_user_name" placeholder="Din email..">
                </div>
                <div class="form-group">
                    <input class="form-control" id="password" type="password" name="login_password" placeholder="Din kode..">
                </div>
                <div class="login-control">
                    <button type="submit">Login</button>
                    <p>Ikke medlem? <a href="/user/register.php">Opret Bruger</a></p>
                </div>
            </form>
            <span style="color:red"><?=$auth->errorMsg?></span>
        </div>
      </div>
    </div>
  </div>
</div>