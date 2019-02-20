<?php
            $servername = '140.115.80.221';
            $username = 'user';
            $password = 'ncumiscjt1';
            $dbname = 'pet_city_db';

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            else{
                echo "資料庫連結成功";
            }
               
            // '':給SQL知道是字串, "":PHP將引號內的變數值轉成字串
            $sql = "DELETE FROM user_collection_table WHERE user_id = ".$_POST['user_id']." AND animal_id = ".$_POST['animal_id'];
                     
            if ($conn->query($sql) === TRUE) {
                echo "Record deleted successfully";
            } else {
                echo "Error deleting record: " . $conn->error;
            }

            mysqli_close($conn);
?>