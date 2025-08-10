<?php
    session_name('user');
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Georgia', serif;
            background-color: #f6f8ff; /* Match index page theme */
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: 40px auto;
            background-color: #fffbe6; /* Light yellow like showcase */
            padding: 32px 28px;
            box-shadow: 0 4px 12px rgba(44,62,80,0.07);
            border-radius: 14px;
        }

        .topnav {
            background-color: #3498db;
            padding: 12px 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 8px;
            margin-bottom: 28px;
            box-shadow: 0 2px 8px rgba(52,152,219,0.08);
        }

        .topnav a {
            color: #fff;
            padding: 10px 18px;
            text-decoration: none;
            font-size: 18px;
            font-weight: 600;
            border-radius: 5px;
            transition: background 0.2s, color 0.2s;
        }

        .topnav a:hover, .topnav a.active {
            background-color: #2980b9;
            color: #ffe082;
        }

        h1 {
            text-align: center;
            font-family: 'Georgia', serif;
            color: #3498db;
            font-size: 34px;
            margin-top: 10px;
            margin-bottom: 18px;
            text-shadow: 0 2px 8px rgba(52,152,219,0.08);
        }

        h3 {
            text-align: center;
            color: #34495e;
            font-weight: bold;
            font-size: 35px;
            margin-bottom: 18px;
        }

        h4{
            color: #555;
            line-height: 1.8;
            margin: 20px 0;
            font-size: 18px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 15px;
            font-size: 1.15rem;
            color: #666;
            padding-left: 24px;
            position: relative;
        }

        ul li:before {
            content: '\2022';
            color: #28a745;
            font-weight: bold;
            position: absolute;
            left: 0;
            font-size: 22px;
        }

        h6 {
            text-align: center;
            margin-top: 40px;
            color: #999;
            font-size: 16px;
        }

        .back-home {
            text-decoration: none;
            font-size: 18px;
            color: #3498db;
            display: flex;
            align-items: center;
            margin-bottom: 24px;
            font-weight: 600;
            transition: color 0.3s;
        }

        .back-home:hover {
            color: #218838;
        }

        .back-home svg {
            margin-right: 8px;
            fill: currentColor;
            transition: transform 0.3s;
        }

        .back-home:hover svg {
            transform: translateX(-3px);
        }

        .btn-success {
            background-color: #28a745;
            border: none;
            padding: 12px 28px;
            font-size: 18px;
            font-weight: 600;
            border-radius: 7px;
            color: #fff;
            letter-spacing: 1px;
            box-shadow: 0 2px 8px rgba(40,167,69,0.08);
            transition: background 0.2s, box-shadow 0.2s;
        }

        .btn-success:hover {
            background-color: #218838;
            box-shadow: 0 4px 12px rgba(40,167,69,0.15);
        }
    </style>
</head>

<body>
    <div class="container">
        <a href="index1.php" class="back-home">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M15 8a.5.5 0 0 1-.5.5H2.707l3.147 3.146a.5.5 0 0 1-.708.708l-4-4a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 7.5H14.5A.5.5 0 0 1 15 8z"/>
            </svg>
            Back to home 
        </a>
        <div class="topnav">
            <a class="active">ABOUT US</a>
            <div>
                <a href="./contact.php">Contact Us</a>
            </div>
        </div>

        <div>
            <h1>LET'S EXPLORE TOGETHER</h1>
            <h3><u>ABOUT US</u></h3>
            <h4>
                <ul>
                    <li>Every business has an origin story worth telling, and usually one that justifies why you do business and have clients.</li>
                    <li>H M Event Planning specializes in planning weddings and events in tents, private homes, and raw spaces.</li>
                    <li>By providing a short description of the effortless elegance of their weddings, Brilliant Event Planning gives their potential clients a clear vision of what to expect.</li>
                    <li>Highlighting your team establishes trust with your audience and creates a connection that can help in the sales process.</li>
                </ul>
            </h4>
            <h6>hm decoration@2004</h6>
            <a href="./learn.php" class="btn btn-success">Learn more</a>
        </div>
    </div>
</body>

</html>
