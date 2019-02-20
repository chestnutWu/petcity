<?php 

$receiveData = json_decode($_REQUEST["x"]);

$degree_01 = $receiveData[0];
$degree_02 = $receiveData[1];
$degree_03 = $receiveData[2];
$degree_04 = $receiveData[3];
$degree_05 = $receiveData[4];
$degree_06 = $receiveData[5];
$degree_07 = $receiveData[6];
$degree_08 = $receiveData[7];
$degree_09 = $receiveData[8];
$degree_10 = $receiveData[9];
$degree_11 = $receiveData[10];
$degree_12 = $receiveData[11];
$degree_13 = $receiveData[12];
$degree_14 = $receiveData[13];
$degree_15 = $receiveData[14];
$degree_16 = $receiveData[15];


$user_input = array($degree_01, $degree_02, $degree_03, $degree_04, 
                    $degree_05, $degree_06, $degree_07, $degree_08,
                    $degree_09, $degree_10, $degree_11, $degree_12, 
                    $degree_13, $degree_14, $degree_15, $degree_16);


            $servername = '140.115.80.221';
            $username = 'user';
            $password = 'ncumiscjt1';
            $dbname = 'pet_city_db';

            $conn = new mysqli($servername, $username, $password, $dbname);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            else{
                //echo "資料庫連結成功<br>";
            }
            
            // '':給SQL知道是字串, "":PHP將引號內的變數值轉成字串
            $sql = "SELECT * from dogs_data";
            $result = mysqli_query($conn, $sql);       
        
            if ($result)
            {
                $posts = array();
                while($row = mysqli_fetch_array($result))
                {
                    $name = $row['原名'];
                    $provenance = $row['原產地'];
                    $wieght = $row['體重'];
                    $height = $row['身高'];
                    $fur = $row['皮毛'];
                    $furColor = $row['皮色'];
                    $degree_01 = $row['粘人程度'];
                    $degree_02 = $row['初養適應度'];
                    $degree_03 = $row['掉毛程度'];
                    $degree_04 = $row['體味程度'];
                    $degree_05 = $row['犬叫程度'];
                    $degree_06 = $row['美容程度'];
                    $degree_07 = $row['關愛需求度'];
                    $degree_08 = $row['對小孩友善度'];
                    $degree_09 = $row['對生人友善'];
                    $degree_10 = $row['對動物友善度'];
                    $degree_11 = $row['運動量'];
                    $degree_12 = $row['可訓練度'];
                    $degree_13 = $row['口水程度'];
                    $degree_14 = $row['城市適應度'];
                    $degree_15 = $row['耐熱程度'];
                    $degree_16 = $row['耐寒程度'];
                    
                    if($degree_01 != 0 ) {     //去除資料不齊全的品種
                        
                        $detail = '原產地 :'.$provenance.'\n'.
                                  '體重 : '.$wieght.'\n'.
                                  '身高 : '.$height.'\n'.
                                  '皮毛 : '.$fur.'\n'.
                                  '皮色 : '.$furColor;
                        
                        
                        
                        $posts[] = array('原名'=> $name, 
                                         '詳細資料' => $detail,
                                         '黏人程度'=> $degree_01,
                                         '初養適應度'=>$degree_02,
                                         '掉毛程度'=>$degree_03,
                                         '體味程度'=>$degree_04,
                                         '犬叫程度'=>$degree_05,
                                         '美容程度'=>$degree_06,
                                         '關愛需求度'=>$degree_07,
                                         '對小孩友善度'=>$degree_08,
                                         '對生人友善'=>$degree_09,
                                         '對動物友善度'=>$degree_10,
                                         '運動量'=>$degree_11,
                                         '可訓練度'=>$degree_12,
                                         '口水程度'=>$degree_13,
                                         '城市適應度'=>$degree_14,
                                         '耐熱程度'=>$degree_15,
                                         '耐寒程度'=>$degree_16,
                                         '距離'=>2147483647,
                                         '適合度'=>0);
                    }
                }

            } else {
                echo "Error happened";
            }    
            mysqli_close($conn);
            

            $response = array();
            $mindist = 2147483647;
                
            foreach($posts as $key=>&$value)  //將代表值的變數($value)，指定為 reference(&$value)
            {
                $dog_Type_degree = array();
                foreach($value as $k => $v)
                {
                    if($k != '原名' && $k != '距離' && $k != '適合度' && $k != '詳細資料')
                        array_push($dog_Type_degree, $v);
                };
                
                $d = getDistance($dog_Type_degree,$user_input);
                $f = getFitDegree($dog_Type_degree,$user_input);                
                $value['距離'] = $d;
                $value['適合度'] = $f;
                if($d < $mindist)  //找離user_input最近的距離
                {
                    $mindist = $d;
                }
                
                unset($value);   // unset(&$value)，可避免非預期的最後一個元素值一直改變 
            };
            

            $winners = array();


            /*將所有品種依推薦順序放入winners*/
            while(!empty($posts))
            {
                foreach($posts as $key=>$value)     //把目前posts中最推薦品種存入winners，並從posts移除
                {
                    if($value['距離'] == $mindist)
                    {
                        array_push($winners , $value);  
                        unset($posts[$key]); 
                    }
                }
                
                $mindist = 2147483647;              //計算當下posts之中最短的距離
                foreach($posts as $key=>$value)
                {
                    if($value['距離'] < $mindist) 
                    {
                            $mindist = $value['距離'];
                    }
                }
                
            }


//            echo '<center><button><a href="心理測驗_0701.html">重新測驗</a></button></center>';

             

            /*將測驗結果整理成json格式字串*/

            $ResultData = "[";
            
            foreach ($winners as $value) 
            {
                
                $ResultData = $ResultData.'{"name":"'.$value['原名'].'",
                                            "fitDegree":"'.$value['適合度'].'",
                                            "detail":"'.$value['詳細資料'].'",
                                            "imgPath":"dogs_image/'.$value['原名'].'.jpg",'.
                                            '"values":';
                
                $ResultData = $ResultData.'[[';
                     foreach($value as $k => $v)
                     {
                         if($k != '原名' && $k != '詳細資料' && $k != '距離' && $k != '適合度' )
                            $ResultData = $ResultData.'{"area": "'.$k.'","value":'.$v.'},';
                     }
                $ResultData = substr($ResultData,0,strlen($ResultData)-1); //去除最後一個逗號
                $ResultData = $ResultData.']]},';
//                echo '<div>';
//                echo '<img height=200px width=200px src="dogs_image/'.$value['原名'].'.jpg"><br>';
//                foreach($value as $k => $v)
//                {
//                    echo $k.':'.$v.'<br>';
//                }   
//                echo '</div>';
                
            }
            $ResultData = substr($ResultData,0,strlen($ResultData)-1); //去除最後一個逗號
            $ResultData = $ResultData."]";
            echo $ResultData;     //回傳json格式字串

            function getDistance($dog_Type_degree,$user_input)
            {
                $distance = 0;
                for($i=0 ; $i<count($dog_Type_degree); $i++)
                {
                    if($user_input[$i] != '')
                    {
                        $diff = $dog_Type_degree[$i]-$user_input[$i];
                        $distance += pow($diff,2);
                    }
                }
                
                return $distance;
            }

            function getFitDegree($dog_Type_degree,$user_input)
            {
                $counter = 0;
                $diff = 0;
                
                for($i=0 ; $i<count($dog_Type_degree); $i++)
                {
                    if($user_input[$i] != '')
                    {
                        $counter++;            
                        $diff += pow(abs((int)$dog_Type_degree[$i]-(int)$user_input[$i]),2)/100;
                    }
                }
                $fitDegree = pow((100-($diff/$counter))/10,2);
         
                return (int)$fitDegree;
                
            }

?>