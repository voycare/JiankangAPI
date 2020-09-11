<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Please confirm your email address</title>
    <style>
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
            width: 600px;
            height: 400px;
            background-color: aliceblue;
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

</head>
<body>
<div class="content">
    <div class="header">
        <div class="logo">
            <img src="http://api.hera.health/assets/images/title.png">
        </div>
        <span class="title">Hera</span>
    </div>
    <div class="line">
    </div>
    <p>Please confirm your email address</p>
    <span>Welcome <b>{{$first_name}} {{$last_name}}</b><span/><br/>
    <span>Thank you for signing up to use Hera.<br/>  Please take a second to make sure we have your correct email address.</span>
    <a class="primary-btn" href="{{$otp}}"><button>Confirm your email address</button></a>
</div>
</body>
</html>
