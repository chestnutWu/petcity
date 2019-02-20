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
            $sql = "INSERT INTO user_collection_table (user_id,animal_id) VALUES ('".$_POST['user_id']."','" .$_POST['animal_id']."')";
                     
            if (mysqli_query($conn, $sql))
            {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
                
            mysqli_close($conn);
?>