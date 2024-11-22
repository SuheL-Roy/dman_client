<!DOCTYPE html>
<!-- Created By CodingNepal - www.codingnepalweb.com -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Amvines logistic</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,300&family=Poppins&family=Roboto:wght@400;500&display=swap');

    body {
        line-height: 1.3em;
        min-width: 920px;
        text-align: center;
    }

    .history-tl-container {
        font-family: "Roboto", sans-serif;
        width: 50%;
        margin: auto;
        display: block;
        position: relative;
    }

    .history-tl-container ul.tl {
        margin: 20px 0;
        padding: 0;
        display: inline-block;

    }

    .history-tl-container ul.tl li {
        list-style: none;
        margin: auto;
        margin-left: 200px;
        min-height: 50px;
        /*background: rgba(255,255,0,0.1);*/
        border-left: 1px dashed #86D6FF;
        padding: 0 0 50px 30px;
        position: relative;
    }

    .history-tl-container ul.tl li:last-child {
        border-left: 0;
    }

    .history-tl-container ul.tl li::before {
        position: absolute;
        left: -18px;
        top: -5px;
        content: " ";
        border: 8px solid rgba(255, 255, 255, 0.74);
        border-radius: 500%;
        background: #258CC7;
        height: 20px;
        width: 20px;
        transition: all 500ms ease-in-out;

    }

    .history-tl-container ul.tl li:hover::before {
        border-color: #258CC7;
        transition: all 1000ms ease-in-out;
    }

    ul.tl li .item-title {
        width: 300px;
    }

    ul.tl li .item-detail {
        color: rgba(0, 0, 0, 0.5);
        font-size: 12px;
    }

    ul.tl li .timestamp {
        color: #8D8D8D;
        position: absolute;
        width: 100px;
        left: -50%;
        text-align: right;
        font-size: 12px;
    }


    .container h1 {
        text-align: center;
        color: purple;
    }

    .container-2 {
        background: rgb(231, 208, 208);
        /* border-top: 2px solid #120800; */
        border-left: 2px solid #120800;
        border-right: 2px solid #120800;
        height: 80px;
        margin-right: 35%;
        margin-left: 35%;
        padding: 5px;

    }

    .container-3 {
        border-bottom: 2px solid #120800;
        border-left: 2px solid #120800;
        border-right: 2px solid #120800;
        height: 80px;
        margin-right: 35%;
        margin-left: 35%;
        padding: 5px;

    }

    .container-2 p {
        text-align: left;
        margin-top: 5%;
        color: black;
    }

    .container-2 .p1 {
        text-align: right;
        margin-top: 1%;
        color: #8D8D8D;
    }

    .container-3 {
        margin-top: -3%;
    }

    .left {
        float: left;
    }

    .right {
        float: right;
    }
</style>

<body>
    <img src="https://t4.ftcdn.net/jpg/04/72/65/73/360_F_472657366_6kV9ztFQ3OkIuBCkjjL8qPmqnuagktXU.jpg" alt="">

</body>

</html>
