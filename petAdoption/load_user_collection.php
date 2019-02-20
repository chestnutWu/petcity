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
                //echo "資料庫連結成功";
            }
               
            // '':給SQL知道是字串, "":PHP將引號內的變數值轉成字串
            $sql = "SELECT * FROM user_collection_table WHERE user_id = ".$_POST['user_id'];
                     
            if ($result = mysqli_query($conn, $sql))
            {
                //echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
            
            $all_collection_id = "[";

            while($row = mysqli_fetch_array($result))
            {
                $all_collection_id= $all_collection_id.$row['animal_id'].',';
            }
            
            if(strlen($all_collection_id)>1)
                $all_collection_id = substr($all_collection_id,0,strlen($all_collection_id)-1);
            $all_collection_id = $all_collection_id."]";
                    
            echo $all_collection_id;
                
            mysqli_close($conn);
?>