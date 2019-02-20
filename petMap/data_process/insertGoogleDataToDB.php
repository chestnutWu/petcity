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
            $googleDataRate = $_POST['rate'];
            $id = $_POST['id'];
            $place_id = $_POST['place_id'];
            $opening_hours;
            $website;
            $photo;
        
            // '':給SQL知道是字串, "":PHP將引號內的變數值轉成字串
            $sql = "UPDATE veterinary_hospital_data SET 評價='$googleDataRate',
                                                        place_id='$place_id'";
            if(isset($_POST['photo'])){
                $photo = $_POST['photo'];
                $sql .= ",醫院照片='$photo'";
            }
        
            if(isset($_POST['opening_hours'])){
                $opening_hours = $_POST['opening_hours'];
                $sql .= ",營業時間='$opening_hours'";
            }
        
            if(isset($_POST['website'])){
                $website = $_POST['website'];
                $sql .= ",店家網址='$website'";
            }
            
            $sql .= " WHERE id='$id'"; 
            
                     
            if (mysqli_query($conn, $sql))
            {
                 echo "Google Data插入成功";
            } else {
                 echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            mysqli_close($conn);
        ?>
    </body>
</html>