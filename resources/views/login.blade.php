<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>共信平台</title>
    <style media="screen">
      body {
        margin: 0;
        width: 100vw;
        height: 100vh;
      	background-image: radial-gradient(circle at 50% 50%, #5697e1, #2f6db3);
        /*background-color: rgb(59, 106, 174);*/
      }
      .background--bg {
        position: absolute;;
        bottom: 0;
        left: 0;
        width: 100vw;
      }
      .modal--container {
        width: 30vw;
        height: 400px;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 16px;
      }
      .modal--container header {
        text-align: center;
        padding: 14px;
        font-size: 24px;
        color: #5697e1;
        font-weight: bold;
        background-color: rgb(254, 208, 35);
        border-top-left-radius: 14px;
        border-top-right-radius: 14px;
      }
      .modal--container .modal--body {
        background-color: #fff;
        text-align: center;
      }
      input {
        border: 0;
        display: inline-block;
        border-bottom: 1px solid #aaa;
        width: 20vw;
        height: 40px;
        margin: 10px auto;
        box-sizing: border-box;
        padding-left: 20px;
        font-size: 22px;
      }
      input:first-child {
        margin-top: 40px;
      }
      input:last-child {
        margin-bottom: 40px;
      }
      footer {
        display: block;
        text-align: center;
        padding: 20px;
        padding-bottom: 40px;
        background-color: #fff;
        border-bottom-left-radius: 14px;
        border-bottom-right-radius: 14px;
      }
      .login--btn {
        display: inline-block;
        width: 15vw;
        background-color: rgb(254, 208, 35);
        padding: 10px 0;
        border-radius: 40px;
        color: #5697e1;
        font-weight: bold;
        cursor: pointer;
      }
    </style>
  </head>
  <body>
    <div class="modal--container">
      <header class="modal--header">
        共信平台<br>
        后台管理系统
      </header>
      <div class="modal--body">
        <input id="account" type="text" name="" value="" placeholder="用户">
        <input id="password" type="password" name="" value="" placeholder="密码">
      </div>
      <footer>
        <div class="login--btn">
          登录
        </div>
      </footer>
    </div>
  </body>
  <script src="https://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $('.login--btn').click(function() {
        console.log($('#account').val())
        console.log($('#password').val())
        $.ajax({
          url: 'http://localhost/admin/admin/login',
//          url: 'http://www.gzfinance.top/admin/admin/login',
          type: 'post',
          data: {
              'account':$('#account').val(),
              'password':$('#password').val()
          },
          headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
          success: function(res) {
            if (JSON.parse(res).code == '1') {
              alert(JSON.parse(res).msg)
              window.location.href = 'http://localhost/admin';
//              window.location.href = 'http://www.gzfinance.top/admin';
            } else {
              alert(JSON.parse(res).msg)
            }
          },
          fail: function(err) {
            alert('登录失败，请刷新后重试')
            alert(err)
          }
        })
      })
    })
  </script>
</html>

