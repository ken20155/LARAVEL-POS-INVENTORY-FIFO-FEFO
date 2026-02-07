<div class="login-header box-shadow">

</div>
<div
  class="login-wrap d-flex align-items-center flex-wrap justify-content-center"
>
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 col-lg-7">
        <img src="<?= env('APP_URL') ?>public/plugins/vendors/images/login-page-img.png" alt="" />
      </div>
      <div class="col-md-6 col-lg-5">
        <div class="login-box bg-white box-shadow border-radius-10">
          <div class="login-title">
            <h2 class="text-center text-primary">Login</h2>
          </div>
            <form method="POST" class="login-form" id="login-form">
            <div class="input-group custom">
              <input
                type="text"
                name="username"
                class="form-control form-control-lg"
                placeholder="Username"
              />
              <div class="input-group-append custom">
                <span class="input-group-text"
                  ><i class="icon-copy dw dw-user1"></i
                ></span>
              </div>
            </div>
            <div class="input-group custom">
              <input
                type="password"
                name="password"
                class="form-control form-control-lg"
                placeholder="**********"
              />
              <div class="input-group-append custom">
                <span class="input-group-text"
                  ><i class="dw dw-padlock1"></i
                ></span>
              </div>
            </div>
            <div class="row pb-30">
              {{-- <div class="col-6">
                <div class="custom-control custom-checkbox">
                  <input
                    type="checkbox"
                    class="custom-control-input"
                    id="customCheck1"
                  />
                  <label class="custom-control-label" for="customCheck1"
                    >Remember</label
                  >
                </div>
              </div> --}}
              {{-- <div class="col-6">
                <div class="forgot-password">
                  <a href="forgot-password">Forgot Password</a>
                </div>
              </div> --}}
            </div>
            <div class="row">
              <div class="col-sm-12">
                <div class="input-group mb-0">
                  <button
                    class="btn btn-primary btn-lg btn-block"
                    type="submit"
                    >Sign In
                  </button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
