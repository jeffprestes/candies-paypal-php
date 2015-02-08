<!DOCTYPE html>
<html>
    <head>
        <title>Candies</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
        <style type="text/css">
            #splash   {
                position:  absolute;
                top: 50%;
                left: 50%;
                margin-left: -100px;
                margin-top: -190px;
                text-align: center;
                font-family: 'Lobster', cursive;
                font-size: x-large;
                font-color: brown;
            }
            
            .animated { 
                -webkit-animation-duration: 1s; 
                animation-duration: 1s; 
                -webkit-animation-fill-mode: both; 
                animation-fill-mode: both; 
                animation-iteration-count:infinite; 
                -webkit-animation-iteration-count:infinite; 
            } 

            @-webkit-keyframes fadeInLeft { 
                0% { 
                    opacity: 0; 
                    //-webkit-transform: translateX(-20px); 
                } 
                100% { 
                    opacity: 1; 
                    //-webkit-transform: translateX(0); 
                } 
            } 
            @keyframes fadeInLeft { 
                0% { 
                    opacity: 0; 
                    //transform: translateX(-20px); 
                } 
                100% { 
                    opacity: 1; 
                    //transform: translateX(0); 
                } 
            } 
            
            .fadeInLeft { 
                -webkit-animation-name: fadeInLeft; 
                animation-name: fadeInLeft; 
            }
            
            
            @-webkit-keyframes pulse { 
                0% { -webkit-transform: scale(1); } 
                50% { -webkit-transform: scale(1.4); } 
                100% { -webkit-transform: scale(1); } 
            } 
            
            @keyframes pulse { 
                0% { transform: scale(1); } 
                50% { transform: scale(1.4); } 
                100% { transform: scale(1); } 
            } 
            .pulse { 
                -webkit-animation-name: pulse; 
                animation-name: pulse; 
            }
            
        </style>
    </head>
    <body>
        <div id="splash">
            <img src="images/gumball-machine.gif" id="imgcandy" />
            <br />
            <br />
            <span id="message" class="animated pulse">Loading</span>
        </div>
        <script>
            window.location = '/candies-paypal-php/paypalpresale.php';
        </script>
    </body>
</html>
