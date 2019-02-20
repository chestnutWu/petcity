<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>PHP Script Execution</title>
    </head>
    <body>
        <?php

            $servername = 'localhost';
            $username = 'root';
            $password = 'jason0524';
            $dbname = 'place_data';

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            else{
                echo "資料庫連結成功";
            }
             
            // '':給SQL知道是字串, "":PHP將引號內的變數值轉成字串
            $sql = "UPDATE veterinary_hospital_data SET 
                                        經度='$_POST[longitude]',
                                        緯度='$_POST[latitude]' WHERE id='$_POST[id]'";
                     
            if (mysqli_query($conn, $sql))
            {
                 echo "經緯度插入成功";
            } else {
                 echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        ?>
    </body>
</html>