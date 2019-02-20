<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>PHP Script Execution</title>
    </head>
    <body>
        <?php

            $servername = '140.115.80.224';
            $username = 'user';
            $password = 'ncumiscjt1';
            $dbname = 'vet_store';

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }else
            {
                echo "資料庫連結成功";
            }
            
            $data = file_get_contents("vet.json");
            $content = json_decode($data);
            //echo $content;
            if(is_array($content) && !empty($content))
            {    
                 foreach ($content as $value)
                 { 
                     // '':給SQL知道是字串, "":PHP將引號內的變數值 轉成字串
                    $sql = "INSERT INTO vet_hospital_data (縣市, 字號, 執照類別, 狀態, 機構名稱,負責獸醫,機構電話,發照日期,機構地址) VALUES ('"
                        .$value->縣市."','" .$value->字號."','".$value->執照類別."','".$value->狀態."','".$value->機構名稱."','". $value->負責獸醫."','".$value->機構電話."','".$value->發照日期."','".$value->機構地址."')";
                     
                    if (mysqli_query($conn, $sql))
                    {
                        echo "New record created successfully";
                    } else {
                       echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                    }
                    echo $value->ParkName;
                }
                
                mysqli_close($conn);
            }
            else
            {
                echo 'error happened';
            }

        ?>
    </body>
</html>