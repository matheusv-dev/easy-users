<?php
require "../define_dbs.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <meta name="google" content="notranslate" />
  <title>Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body class="bg-primary" style="height: 100vh">
  <div class="container h-100">
    <div class="align-items-center justify-content-center row h-100">
      <div class="col-lg-5 flex">
        <div class="card shadow-lg border-0 rounded-lg">
          <div class="card-header">
            <h3 class="text-center font-weight-light my-2">
              Easy Users
            </h3>
            <div id="retorno"></div>
          </div>
          <div class="card-body">
            <form method="post" onsubmit="return false;">
              <div class="form-group">
                <input class="form-control py-2" id="nome_usuario" name="nome_usuario" type="text" placeholder="Digite seu usuário" />
              </div>
              <div class="form-group">
                <input class="form-control py-2" id="senha" name="senha" type="password" placeholder="Digite sua senha" />
              </div>
              <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                <a class="small" href="">&nbsp;</a>
                <input class="btn btn-primary" value="Login" onclick="login()" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script>
    function login() {
      $.ajax({
        url: "https://localhost/easy-users/backend/api/login/",
        method: "POST",
        data: {
          nome_usuario: $("#nome_usuario").val(),
          senha: $("#senha").val()
        },
        success: e => {
          const response = JSON.parse(e)

          if (response.code == 200) {
            window.location.href = "https://localhost/easy-users/frontend/autenticate/?auth=" + btoa(JSON.stringify(response.data))
          } else {
            alert(response.message)
          }

        }
      })
    }
  </script>

</body>

</html>