<?php 
            $servername = '140.115.80.221';
            $username = 'user';
            $password = 'ncumiscjt1';
            $dbname = 'place_data';

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            else{/*echo "資料庫連結成功<br>";*/}

            // '':給SQL知道是字串, "":PHP將引號內的變數值轉成字串
            $sql = "SELECT * FROM veterinary_hospital_data";
            $result = mysqli_query($conn, $sql);       
        
            if ($result)
            {
                $response = array();
                $tempArray = array();
                while($row = mysqli_fetch_array($result))
                {
                    $id = $row['id'];
                    $city = $row['縣市'];
                    $hospitalID = $row['字號'];
                    $licenseCategory = $row['執照類別'];
                    $status = $row['狀態'];
                    $hospitalName = $row['機構名稱'];
                    $principal = $row['負責獸醫'];
                    $telephone = $row['機構電話'];
                    $dateOfPublication = $row['發照日期'];
                    $address = $row['機構地址'];
                    $longitude = $row['經度'];
                    $latitude = $row['緯度'];
                    
                    $tempArray = array('id' => urlencode($id),
                                     'city'=> urlencode($city), 
                                     'hospitalID'=> urlencode($hospitalID),
                                     'licenseCategory'=>urlencode($licenseCategory),
                                     'status'=>urlencode($status),
                                     'hospitalName'=>urlencode($hospitalName),
                                     'principal'=>urlencode($principal),
                                     'telephone'=>urlencode($telephone),
                                     'dateOfPublication'=>urlencode($dateOfPublication),
                                     'address'=>urlencode($address),
                                     'longitude'=>urlencode($longitude),
                                     'latitude'=>urlencode($latitude));
                    
                    if(!empty($row['營業時間'])){$tempArray['opening_hours'] = urlencode($row['營業時間']);}
                    if(!empty($row['店家網址'])){$tempArray['website'] = urlencode($row['店家網址']);}
                    if(!empty($row['評價'])){$tempArray['evaluation'] = urlencode($row['評價']);}
                    if(!empty($row['place_id'])){$tempArray['place_id'] = urlencode($row['place_id']);}
                    if(!empty($row['醫院照片'])){$tempArray['photo'] = urlencode($row['醫院照片']);}
                    $posts[] = $tempArray;
                }
                $data_json_url = json_encode($posts,JSON_FORCE_OBJECT);
                $data_json = urldecode($data_json_url);
                echo $data_json;
            } else {
                echo "Error happened";
            }    
            mysqli_close($conn);
?>