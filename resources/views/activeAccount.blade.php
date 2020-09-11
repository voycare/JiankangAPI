<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Hera</title>
</head>
<body>
  <div class="content">
      <div class="header">
          <div class="logo">
              <img src="assets/images/title.png">
          </div>
          <span class="title">Hera</span>
      </div>
      <div class="line">

      </div>
      <b>Thank you for confirming</b><br/>
      <b>your email address</b>
      <p>You can now sign in your Hera account</p>
      <a class="primary-btn" href="http://client.hera.health/login"><button>Go to sign in</button></a>
  </div>
</body>
</html>
<style lang="scss">
    .header{
        margin-bottom: 30px;
        display: flex;

    }
    b{
        font-size: 20px;
        font-family: Poppins;
        color: black;
    }
    .logo{
        width: 50%;
        text-align: right;
        margin-right: 10px;
    }
    .title{
        font-size: 30px;
        font-family: Poppins;
        font-weight: bold;
        margin-top: 9px;
        color: black;
    }
    .line{
        width: 100%;
        height: 1px;
        opacity: 0.8;
        margin-bottom: 50px;
        background-color: lightgrey;
    }
    body{
        background-color: aliceblue;
        text-align: center;

    }
    .content{
        width: 400px;
        height: 400px;
        background-color: white;
        -webkit-transform: translate(-50%,-50%);
        padding: 30px 40px;
        text-align: center;
        position: absolute;
        top: 50%;
        left: 50%;
    }
    img{
        width: 50px;
        height: 50px;
    }

    p{
        font-size: 16px;
        color: black;
        margin-top: 30px;
    }
    a{
        color: black;
        font-family: Poppins;
        text-decoration: none;
    }
    button{
        width: 300px;
        height: 40px;
        border-radius: 20px;
        font-size: 16px;
        border: none;
        background: #FFAFAE;
        margin-top: 50px;
        cursor: pointer;
    }
</style>
