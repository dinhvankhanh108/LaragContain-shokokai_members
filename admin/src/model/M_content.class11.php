<?php
    class M_content extends Database {
		protected $table = 'SoriContents_List';

        public function getDB($query, $arr = null)
        {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getList(): array
        {
            $stmt = $this->conn->prepare("SELECT * FROM {$this->table}");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

		public function getById( int $id ) : array {
            $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE `画像1` = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT, 11);
            $stmt->execute();
            $result['content'] = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result;
		}

        public function getImg1($cateContent)
        {
            $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE `カテゴリーNo.` = :cateContent ORDER BY  `画像2`");
            $stmt->bindParam(':cateContent', $cateContent, PDO::PARAM_INT, 11);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getImg2($img2)
        {
            $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE `画像2` = :img2 ORDER BY  `画像2`");
            $stmt->bindParam(':img2', $img2, PDO::PARAM_INT, 11);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getImgforCate($cateContent)
        {
            $query = "SELECT DISTINCT `画像2` FROM SoriContents_List WHERE `カテゴリーNo.` = :cateContent ORDER BY  `画像2`";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':cateContent', $cateContent, PDO::PARAM_INT, 11);

            $stmt->execute();
            $resultTest = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $arr1 = [];
            // $arr1['resultTest'] = $resultTest;
            foreach ($resultTest as $key => $value) {
                foreach ($value as $key1 => $value1) {
                    $arr1[] = $value1;
                }
            }
            return $arr1;
        }


        public function gettest($cateContent)
        {
            $query = "SELECT DISTINCT `画像2`,`画像1` FROM SoriContents_List WHERE `カテゴリーNo.` = :cateContent ORDER BY  `画像2`";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':cateContent', $cateContent, PDO::PARAM_INT, 11);

            $stmt->execute();
            $resultTest = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $arr1 = [];
            // $arr1['resultTest'] = $resultTest;
            foreach ($resultTest as $key => $value) {
                // foreach ($value as $key1 => $value1) {
                // $arr1[] = $value;
                // $arr1['画像1'][] = $value['画像1'];
                    $arr1['画像2'][$key] = $value['画像2'];
                    $arr1['画像1'][$key] = $value['画像1'];
                    // $arr1['画像1'][$key1] = $value1['画像1'];
                // }
            }
            return $arr1;
        }
    public function getArrImg2test($cateContent, $image2Content)
    {
        $arr1 = $this->gettest($cateContent);
        // foreach ($arr1 as $key => $value) {
        //     $arr1['画像2'][$key] = $value['画像2'];
        //     $arr1['画像1'][$key] = $value['画像1'];
        // }
        $arrImg1 = $arr1['画像1'];
        $arrImg2 = $arr1['画像2'];

        if (empty($image2Content)) { // if don't input $image2Content
            $image2Content = $this->checkImgSerial($cateContent);
            return $image2Content;
        } else {
            if (in_array($image2Content, $arrImg2)) {  // if input $image2Content but same in db
                for ($i = 0; $i < count($arrImg2) - 1; $i++) {
                    if ($arrImg2[$i] >= $image2Content && $arrImg2[$i] == $arrImg2[$i + 1] - 1) {  // [1,3,5,6,7] insert 5 =>[1,3,5,6,7,8]
                        $arrImg2[$i] = $arrImg2[$i] + 1;

                        $query[$i] = "UPDATE {$this->table} 
                                        SET  `画像2` = :val
                                        WHERE `画像1` = :key";

                        $stmt = $this->conn->prepare($query[$i]);
                        $stmt->bindParam(":val", $arrImg2[$i], PDO::PARAM_INT, 11);
                        $stmt->bindParam(":key", $arrImg1[$i], PDO::PARAM_INT, 11);
                        $stmt->execute();
                        $rs['update'] = $this->conn->inTransaction(); // if false, excute is error
                        // $rs['query'] = $query; // show query

                        continue;
                    } elseif ($arrImg2[$i] >= $image2Content && $arrImg2[$i] < $arrImg2[$i + 1] - 1) { //[1,2,4] insert 2 => [1,2,3,4]
                        $arrImg2[$i] = (int)$arrImg2[$i] + 1;

                        $query[$i] = "UPDATE {$this->table} 
                                        SET  `画像2` = :val
                                        WHERE `画像1` = :key";

                        $stmt = $this->conn->prepare($query[$i]);
                        $stmt->bindParam(":val", $arrImg2[$i], PDO::PARAM_INT, 11);
                        $stmt->bindParam(":key", $arrImg1[$i], PDO::PARAM_INT, 11);
                        $stmt->execute();
                        // return $rs['update'] = $this->conn->inTransaction();
                        return $arrImg2;
                    }
                }
                $arrImg2[count($arrImg2) - 1] =  $arrImg2[count($arrImg2) - 1] + 1; // plus 1 for arr final of if

                $query = "UPDATE {$this->table} 
                                        SET  `画像2` = :val
                                        WHERE `画像1` = :key";
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(":val", $arrImg2[count($arrImg2) - 1], PDO::PARAM_INT, 11);
                $stmt->bindParam(":key", $arrImg1[count($arrImg2) - 1], PDO::PARAM_INT, 11);
                $stmt->execute();
                // return $rs['update'] = $this->conn->inTransaction();
                return $arrImg2;
            } else {
                return $image2Content;
            }
        }
        return $arr1; /* show arr */
        // return false;
    }


        public function getArrImg2($cateContent,$image2Content)
        {
            // $query = "SELECT DISTINCT `画像2`  FROM SoriContents_List WHERE `カテゴリーNo.` = :cateContent ORDER BY  `画像2`";
            // $stmt = $this->conn->prepare($query);
            // $stmt->bindParam(':cateContent', $cateContent, PDO::PARAM_INT, 11);

            // $stmt->execute();
            // $resultTest = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // $arr1 = [];
            // foreach ($resultTest as $key => $value) {
            //     foreach ($value as $key1 => $value1) {
            //         // print_r($value1 . "-");
            //         $arr1[] = $value1;
            //     }
            // }
            $arr1 = $this->getImgforCate($cateContent);

            if(empty( $image2Content )){ // if don't input $image2Content
                $image2Content = $this->checkImgSerial($cateContent);
                return $image2Content;
            }else{
                if(in_array($image2Content,$arr1)){  // if input $image2Content but same in db
                    for ($i = 0; $i < count($arr1) - 1; $i++) {
                        if ($arr1[$i] >= $image2Content && $arr1[$i] == $arr1[$i + 1] - 1) {  // [1,3,5,6,7] insert 5 =>[1,3,5,6,7,8]
                            $arr1[$i] = $arr1[$i] + 1;
                            
                            continue;
                        }elseif($arr1[$i] >= $image2Content && $arr1[$i] < $arr1[$i + 1] - 1){ //[1,2,4] insert 2 => [1,2,3,4]
                            $arr1[$i] = (Int)$arr1[$i] + 1;
                            return $arr1;
                        }
                    }
                    $arr1[count($arr1) - 1] =  $arr1[count($arr1) - 1] + 1; // plus 1 for arr final of if
                    return $arr1;
                }else{
                    return $image2Content;
                }
            }
            return $image2Content;
        }
        
        public function getImgSerial($cateContent)
        {
            $stmt = $this->conn->prepare("SELECT `カテゴリーNo.` FROM {$this->table} 
                                                                WHERE `カテゴリーNo.` = :cateContent");
            $stmt->bindParam(':cateContent', $cateContent, PDO::PARAM_INT, 11);
            $stmt->execute();
            $result = $stmt->rowCount();
            $row = $result + 1;
            $NumberOfcateContent = $cateContent . sprintf('%02d', $row);
            return $NumberOfcateContent;
        }

        public function checkImgSerial($cateContent)
        {
            $stmt = $this->conn->prepare("SELECT MAX(`画像2`) AS maxium FROM {$this->table} 
                                                                        WHERE `カテゴリーNo.` = :cateContent" );
            $stmt->bindParam(':cateContent', $cateContent, PDO::PARAM_INT, 11);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            // $ImgSerialfinally = !empty($result['maxium']) ? $result['maxium'] : 1;            
            // $ImgSerialfinally = sprintf('%02d', $ImgSerialfinally);
            // $ImgSerialfinally = !empty($result['maxium']) ? ((int)$ImgSerialfinally + 1) : ( $cateContent . $ImgSerialfinally );

            if(!empty($result['maxium'])){
                $ImgSerialfinally = $result['maxium'];
                $ImgSerialfinally = (int)$ImgSerialfinally + 1;
            } else{
                $ImgSerialfinally = 1;
                $ImgSerialfinally = sprintf('%02d', $ImgSerialfinally);
                $ImgSerialfinally = $cateContent . $ImgSerialfinally;
            }
            return $ImgSerialfinally;
        }
    public function image2Contentchanged(&$rs,$image2Contentchanged, $getImgforCate)
    {
        if (is_array($image2Contentchanged)) {
            $rs['diff'] = array_diff_assoc($getImgforCate, $image2Contentchanged); // đúng theo thứ tự biến để tìm diff arr đầu

            //set img1 for img2. ex: $key = img1, $value = img2
            foreach ($rs['getlist'] as $key => $value) {
                $rs['merger'][$value['画像1']] = $value['画像2'];
            }

            //find same data in 2 array
            $rs['same'] = array_intersect($rs['merger'], $rs['diff']);


            foreach ($rs['same'] as $key => $val) {
                $query[$key] = "UPDATE {$this->table} 
                                        SET  `画像2` = :val + 1
                                        WHERE `画像1` = :key";

                $stmt = $this->conn->prepare($query[$key]);
                $stmt->bindParam(":val", $val, PDO::PARAM_INT, 11);
                $stmt->bindParam(":key", $key, PDO::PARAM_INT, 11);
                $stmt->execute();
                $rs['update'] = $this->conn->inTransaction(); // if false, excute is error
                $rs['query'] = $query; // show query
            }
        }
        return $rs;
    }

    public function add(array $data)
    {
        try {
            extract($data);

            $image2Contentchanged = $this->getArrImg2($cateContent, $image2Content);
            $getImgforCate = $this->getImgforCate($cateContent);
            $rs['gettest'] = $this->gettest($cateContent);
            $rs['getArrImg2test'] = $this->getArrImg2test($cateContent, $image2Content);


            $rs['image2Contentchanged'] = $image2Contentchanged;
            $rs['getImgforCate'] = $getImgforCate;
            $rs['getlist'] = $this->getImg1($cateContent);
            $rs['update'] = true;
            $rs['insert'] = true;
            $this->conn->beginTransaction();
            // $this->image2Contentchanged($rs, $image2Contentchanged, $getImgforCate);

            $rs['data'] = $data; // show data

            $rs['insert'] = $this->insert($data, $rs['getArrImg2test']); // $image2Content is changed
        } catch (PDOException $e) {
            $rs['errMsg'] = '更新失敗';
            return;

        } catch (Exception $e) {
            $rs['errMsg'] = $e->getMessage();
            return;

        }finally{
            // if ($rs['update'] !== false || $rs['insert'] !== false)
                $this->conn->commit();

        }

        return $rs;
    }
    public function insert(array $data, $image2Contentchanged)
    {
        extract($data);
        if(!is_array($image2Contentchanged))
            $image2Content = $image2Contentchanged;

        $query = "INSERT INTO {$this->table}
                                    (`公開フラグ`, `カテゴリーNo.`,`短縮タイトル`,`正式タイトル`,`解説`
                                    ,`アラートメッセージ`,`コメント`,`リンク先URL`,`別ウィンドウ区分`,`画像2`
                                    ,`TOP非表示`,`FREE`,`簿記9`,`簿記10`,`簿記11`
                                    ,`JA9`,`JA10`,`JA11`,`JA接続キット`,`日誌6`,`日誌6P`)
                                VALUES ( :flagContent, :cateContent, :shortTittleContent, :longTittleContent,:notifyContent
                                        ,:alertContent,:commentContent,:linkContent,:seperateContent,:image2Content
                                        ,:topContent,:freeContent,:account9Content,:account10Content,:account11Content
                                        ,:JA9Content,:JA10Content,:JA11Content,:JAContent,:diary6Content,:diary6PContent)";



        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':flagContent', $flagContent, PDO::PARAM_INT, 11);
        $stmt->bindParam(':cateContent', $cateContent, PDO::PARAM_INT, 11);
        $stmt->bindParam(':shortTittleContent', $shortTittleContent, PDO::PARAM_STR);
        $stmt->bindParam(':longTittleContent', $longTittleContent, PDO::PARAM_STR);
        $stmt->bindParam(':notifyContent', $notifyContent, PDO::PARAM_STR);

        $stmt->bindParam(':alertContent', $alertContent, PDO::PARAM_STR);
        $stmt->bindParam(':commentContent', $commentContent, PDO::PARAM_STR);
        $stmt->bindParam(':linkContent', $linkContent, PDO::PARAM_STR);
        $stmt->bindParam(':seperateContent', $seperateContent, PDO::PARAM_INT, 1);
        $stmt->bindParam(':image2Content', $image2Content, PDO::PARAM_STR);

        $stmt->bindParam(':topContent', $topContent, PDO::PARAM_INT, 1);
        $stmt->bindParam(':freeContent', $freeContent, PDO::PARAM_STR);
        $stmt->bindParam(':account9Content', $account9Content, PDO::PARAM_STR);
        $stmt->bindParam(':account10Content', $account10Content, PDO::PARAM_STR);
        $stmt->bindParam(':account11Content', $account11Content, PDO::PARAM_STR);

        $stmt->bindParam(':JA9Content', $JA9Content, PDO::PARAM_STR);
        $stmt->bindParam(':JA10Content', $JA10Content, PDO::PARAM_STR);
        $stmt->bindParam(':JA11Content', $JA11Content, PDO::PARAM_STR);
        $stmt->bindParam(':JAContent', $JAContent, PDO::PARAM_STR);
        $stmt->bindParam(':diary6Content', $diary6Content, PDO::PARAM_STR);
        $stmt->bindParam(':diary6PContent', $diary6PContent, PDO::PARAM_STR);

        $stmt->execute();
        return $this->conn->inTransaction();
    }

		public function add1( Array $data ) : array  {
            try {
                $rs["success"] = false;

                // Check record exists
                // if ( $this->dataExists($data) ) {
                //     throw new Exception( "本スケジュールは既に存在しています。" );
                // }

                extract($data);

                //insert 画像2
                // $image2Content = $this->getImgSerial($cateContent);
                // $image2Content = getArrImg2($cateContent,$image2Content);
                $image2Content = $this->checkImgSerial($cateContent);
                // $rs["image2Content"] = $image2Content;
                // $rs["checkImgSerial"] = $checkImgSerial;
                // $image2Content = ($image2Content == $checkImgSerial) ? ($checkImgSerial + 1) : $image2Content;
                // $rs["image2Content"] = $image2Content;

                // $rs['success'] = true;
                $query = "INSERT INTO {$this->table}
                                    (`公開フラグ`, `カテゴリーNo.`,`短縮タイトル`,`正式タイトル`,`解説`
                                    ,`アラートメッセージ`,`コメント`,`リンク先URL`,`別ウィンドウ区分`,`画像2`
                                    ,`TOP非表示`,`FREE`,`簿記9`,`簿記10`,`簿記11`
                                    ,`JA9`,`JA10`,`JA11`,`JA接続キット`,`日誌6`,`日誌6P`)
                                VALUES ( :flagContent, :cateContent, :shortTittleContent, :longTittleContent,:notifyContent
                                        ,:alertContent,:commentContent,:linkContent,:seperateContent,:image2Content
                                        ,:topContent,:freeContent,:account9Content,:account10Content,:account11Content
                                        ,:JA9Content,:JA10Content,:JA11Content,:JAContent,:diary6Content,:diary6PContent)";

                

                $stmt = $this->conn->prepare( $query );
                $stmt->bindParam(':flagContent', $flagContent, PDO::PARAM_INT, 11);
                $stmt->bindParam(':cateContent', $cateContent, PDO::PARAM_INT, 11);
                $stmt->bindParam(':shortTittleContent', $shortTittleContent, PDO::PARAM_STR);
                $stmt->bindParam(':longTittleContent', $longTittleContent, PDO::PARAM_STR);
                $stmt->bindParam(':notifyContent', $notifyContent, PDO::PARAM_STR);

                $stmt->bindParam(':alertContent', $alertContent, PDO::PARAM_STR);
                $stmt->bindParam(':commentContent', $commentContent, PDO::PARAM_STR);
                $stmt->bindParam(':linkContent', $linkContent, PDO::PARAM_STR);
                $stmt->bindParam(':seperateContent', $seperateContent, PDO::PARAM_INT,1);
                $stmt->bindParam(':image2Content', $image2Content, PDO::PARAM_STR);

                $stmt->bindParam(':topContent', $topContent, PDO::PARAM_INT,1);
                $stmt->bindParam(':freeContent', $freeContent, PDO::PARAM_STR);
                $stmt->bindParam(':account9Content', $account9Content, PDO::PARAM_STR);
                $stmt->bindParam(':account10Content', $account10Content, PDO::PARAM_STR);
                $stmt->bindParam(':account11Content', $account11Content, PDO::PARAM_STR);

                $stmt->bindParam(':JA9Content', $JA9Content, PDO::PARAM_STR);
                $stmt->bindParam(':JA10Content', $JA10Content, PDO::PARAM_STR);
                $stmt->bindParam(':JA11Content', $JA11Content, PDO::PARAM_STR);
                $stmt->bindParam(':JAContent', $JAContent, PDO::PARAM_STR);
                $stmt->bindParam(':diary6Content', $diary6Content, PDO::PARAM_STR);
                $stmt->bindParam(':diary6PContent', $diary6PContent, PDO::PARAM_STR);

                // $stmt->execute();
                $rs['success'] = true;
                $rs['data'] = $data;
            }
            catch (PDOException $e) {
                $rs['errMsg'] = '更新失敗';
                goto Result;
            }
            catch (Exception $e) {
                $rs['errMsg'] = $e->getMessage();
                goto Result;
            }

  			Result:
  			return $rs;
		}

		public function edit( Array $data ) : array {
            try {
                $rs["success"] = false;

                // Check record exists
                // if ( $this->dataExists($data, self::FLAG_EDIT) ) {
                //     throw new Exception( "本スケジュールは既に存在しています。" );
                // }

                extract($data);

                $rs['update'] = true;
                $rs['edit'] = true;

                $rs['getArrImg2test'] = $this->getArrImg2test($cateContent, $image2Content);
                $image2Contentchanged = $this->getArrImg2($cateContent, $image2Content);
                $getImgforCate = $this->getImgforCate($cateContent);
                $rs['image2Contentchanged'] = $image2Contentchanged;
                $rs['getImgforCate'] = $getImgforCate;
                $rs['getlist'] = $this->getImg1($cateContent);
                $this->conn->beginTransaction();
                // $this->image2Contentchanged($rs, $image2Contentchanged, $getImgforCate);



                    

                $selectNo = $this->getById($id);
                // check  did 「カテゴリーNo.」 change ?
                if($selectNo['content']['カテゴリーNo.'] != $cateContent)
                    $image2Content = $this->checkImgSerial($cateContent);

                $query = "UPDATE {$this->table} SET 
                                `公開フラグ` = :flagContent 
                                ,`カテゴリーNo.` = :cateContent 
                                ,`短縮タイトル` = :shortTittleContent
                                ,`正式タイトル` = :longTittleContent
                                ,`解説` = :notifyContent

                                ,`アラートメッセージ` = :alertContent
                                ,`コメント` = :commentContent
                                ,`リンク先URL` = :linkContent
                                ,`別ウィンドウ区分` = :seperateContent
                                ,`画像2` = :image2Content

                                ,`TOP非表示` = :topContent
                                ,`FREE` = :freeContent
                                ,`簿記9` = :account9Content
                                ,`簿記10` = :account10Content
                                ,`簿記11` = :account11Content
                                
                                ,`JA9` =  :JA9Content
                                ,`JA10`=  :JA10Content
                                ,`JA11` = :JA11Content
                                ,`JA接続キット` = :JAContent
                                ,`日誌6` = :diary6Content
                                ,`日誌6P` = :diary6PContent
                            WHERE `画像1` = :id";


                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':flagContent', $flagContent, PDO::PARAM_INT, 11);
                $stmt->bindParam(':cateContent', $cateContent, PDO::PARAM_INT, 11);
                $stmt->bindParam(':shortTittleContent', $shortTittleContent, PDO::PARAM_STR);
                $stmt->bindParam(':longTittleContent', $longTittleContent, PDO::PARAM_STR);
                $stmt->bindParam(':notifyContent', $notifyContent, PDO::PARAM_STR);

                $stmt->bindParam(':alertContent', $alertContent, PDO::PARAM_STR);
                $stmt->bindParam(':commentContent', $commentContent, PDO::PARAM_STR);
                $stmt->bindParam(':linkContent', $linkContent, PDO::PARAM_STR);
                $stmt->bindParam(':seperateContent', $seperateContent, PDO::PARAM_INT, 1);
                $stmt->bindParam(':image2Content', $image2Content, PDO::PARAM_STR);

                $stmt->bindParam(':topContent', $topContent, PDO::PARAM_INT, 1);
                $stmt->bindParam(':freeContent', $freeContent, PDO::PARAM_STR);
                $stmt->bindParam(':account9Content', $account9Content, PDO::PARAM_STR);
                $stmt->bindParam(':account10Content', $account10Content, PDO::PARAM_STR);
                $stmt->bindParam(':account11Content', $account11Content, PDO::PARAM_STR);

                $stmt->bindParam(':JA9Content', $JA9Content, PDO::PARAM_STR);
                $stmt->bindParam(':JA10Content', $JA10Content, PDO::PARAM_STR);
                $stmt->bindParam(':JA11Content', $JA11Content, PDO::PARAM_STR);
                $stmt->bindParam(':JAContent', $JAContent, PDO::PARAM_STR);
                $stmt->bindParam(':diary6Content', $diary6Content, PDO::PARAM_STR);
                $stmt->bindParam(':diary6PContent', $diary6PContent, PDO::PARAM_STR);

                $stmt->bindParam(':id', $id, PDO::PARAM_INT,11);
                $stmt->execute();
                $rs['edit'] = $this->conn->inTransaction();
                $rs['success'] = true;
            }
            catch (PDOException $e) {
                $rs['errMsg'] = '更新失敗' . $e->getMessage();
                return $rs;
            }
            catch (Exception $e) {
                $rs['errMsg'] = $e->getMessage();
                return $rs;
            }finally{
                // if ($rs['update'] !== false || $rs['edit'] !== false)
                    $this->conn->commit();
            }

			return $rs;
		}

		public function delete( $id ){
            try {
                $query = "DELETE FROM {$this->table} WHERE 画像1 = :id";
                $stmt = $this->conn->prepare( $query );
                $stmt->bindParam(':id', $id, PDO::PARAM_STR, 11);
                $stmt->execute();
                return "削除しました";
            }
            catch (PDOException $e) {
              return "削除失敗";
            }
            catch (Exception $e) {
              return $e->getMessage();
            }
        }
        




        private function dataExists( Array $data, $flag = self::FLAG_ADD ) {
        }
    }
?>
