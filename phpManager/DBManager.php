<?php
	class DBManager{
		//attribute
		//private $dbhost = '140.112.30.226:13003';
		//private $dbuser = 'test';
		//private $dbpass = 'lab303';
		private $dbhost = '127.0.0.1:3306';
		private $dbuser = 'root';
		private $dbpass = '';
		private $dbname = 'chunqiusys2';
		private $bookID_Name = array(1=>"chunqiu", 2=>"zuozhuan", 3=>"gongyang", 4=>"guliang", 5=>"chunqiujingjie");
		private $bookcase_ID = array(1=>"春秋", 2=>"左傳", 3=>"公羊傳", 4=>"穀梁傳", 5=>"春秋經解");
		private $kingName = array(0=>"魯隱公", 1=>"魯桓公", 2=>"魯莊公", 3=>"魯閔公", 4=>"魯僖公", 5=>"魯文公", 
								6=>"魯宣公", 7=>"魯成公", 8=>"魯襄公", 9=>"魯昭公", 10=>"魯定公", 11=>"魯哀公");
		private $seasonName = array(0=>"春", 1=>"夏", 2=>"秋", 3=>"冬");
		private $monthToSeason = array("01"=>"春", "02"=>"春", "03"=>"春", "04"=>"夏", "05"=>"夏", "06"=>"夏"
									, "07"=>"秋", "08"=>"秋", "09"=>"秋", "10"=>"冬", "11"=>"冬", "12"=>"冬");
		private $connection;
		
		//constructor
		function __construct() {
			$this->connection = new PDO('mysql:host='.$this->dbhost.';dbname='.$this->dbname.';charset=utf8', $this->dbuser, $this->dbpass);
		}
		function __destruct() {
			$this->connection;
		}
		//--	取得文本的所有資料
		function query_book($bookID){
			$result = $this->connection->query('select * FROM '.$this->bookID_Name[$bookID].' ORDER BY ID');
			return $result;
		}
		//--	取得文本的資料後，格式的設定
		function queryAndSet($bookID) {
			$result = $this->query_book( $bookID );
			
			$title = "";
			$content = "";
			foreach ($result as $data) {
				$item = $data;
				$start = $item['YEAR_START'];
				$end = $item['YEAR_END'];
				$classYear = "";
				for($j = -1; $j < substr($end, 5,2) - substr($start, 5,2); $j++){
					$temp = substr($start, 5, 2) + $j + 1;
					if ((substr($start, 5, 2) + $j + 1) < 10) {
						$temp = "0".$temp;
					}
					$classYear.=" ".substr($start, 0,5).$temp;
				}
				if($item['TITLE'] == $title) {
					$content.="<li><a href=\"#$classYear\" class=\"text".$classYear."\" id=\"".$start."\" onclick='moveAnchor()'>".$data['CONTEXT']."</a></li>";		
				} else {
					if( $title != "") {
						echo "<div class='panel panel-default block $title' name='$title'>";
						//echo "<div class='title panel-heading'><button type='button' class='btn btn-default'><span class='glyphicon glyphicon-align-justify' /></button>";
						echo "<div class='title panel-heading' style='font-size: 16pt;'>";
						echo "$title</div>";
						echo "<div class='panel-body'>$content</div>";
						echo "</div>";
					}
					$title = "";
					$content = "";
					
					$title = $data['TITLE'];
					$content.="<li><a href=\"#$classYear\" class=\"text".$classYear."\" id=\"".$start."\" onclick='moveAnchor()' >".$data['CONTEXT']."</a></li>";
				}
			}
		}
		//--	插入文本
		function insertTion($filePath, $bookcaseId) {
			$target = $this->bookID_Name[$bookcaseId];
			$stmt = $this->connection->prepare("INSERT INTO $target ( TITLE, SEASON, MONTH, DAY, CONTEXT, YEAR_START, YEAR_END) 
						VALUES(:title, :season, :month, :day, :context, :yearStart, :yearEnd)");
			
			if( file_exists($filePath) ){
				$file = fopen($filePath, "r");
				if($file != NULL){
					while (!feof($file)) {
						$data = fgets($file);
						$stringArray = explode("_", $data);
						
						$title = $stringArray[0];
						$season = ($stringArray[1] == "null") ? NULL: $stringArray[1];
						$month = ($stringArray[2] == "null") ? NULL: $stringArray[2];
						$day = ($stringArray[3] == "null") ? NULL: $stringArray[3];
						$context = $stringArray[4];
						$yearStart = trim($stringArray[5])."-00";
						$yearEnd = trim($stringArray[6])."-00";
						
						$stmt->bindParam(':title', $title);
						$stmt->bindParam(':season', $season);
						$stmt->bindParam(':month', $month);
						$stmt->bindParam(':day', $day);
						$stmt->bindParam(':context', $context);
						$stmt->bindParam(':yearStart', $yearStart);
						$stmt->bindParam(':yearEnd', $yearEnd);
						
						$stmt->execute();
					}
					fclose($file);
				}
			} else {
				echo "nope";
			}
		}
		//--	檢索所有文本
		function queryIndex($query) {
			$query = "%".$query."%";
			$result = $this->connection->query("SELECT * FROM chunqiu WHERE CONTEXT LIKE '$query' UNION
			SELECT * FROM zuozhuan WHERE CONTEXT LIKE '$query' UNION 
			SELECT * FROM gongyang WHERE CONTEXT LIKE '$query' UNION 
			SELECT * FROM guliang WHERE CONTEXT LIKE '$query' ORDER BY `YEAR_START` DESC, BOOKCASE_ID");
			return $result;
		}
		//--	插入檢索文本
		function queryIndexAndSet($query) {
			$result = $this->queryIndex( $query );
			$bookArray = array("", "", "", "", "");
			//--	TODO將來要改
			foreach ($result as $data) {
				$title = $data['TITLE'];
				$bookId = $data['BOOKCASE_ID'];
				$bookArray[$bookId] .= "<li>".$data['CONTEXT']."</li>";
				break;
			}
			
			foreach ($result as $data) {
				if($title == $data['TITLE']) {
					if($bookId == $data['BOOKCASE_ID']) {
						$bookArray[$bookId] .= "<li>".$data['CONTEXT']."</li>";
					} else {
						$bookId = $data['BOOKCASE_ID'];
						$bookArray[$bookId] .= "<li>".$data['CONTEXT']."</li>";
					}
				} else {
					echo "<div class='panel panel-default block $title' name='$title'>";
					echo "<div class='title panel-heading'>";
					echo "$title</div>";
					echo "<div class='panel-body'>";
					for($i = 0; $i < count($bookArray); $i ++) {
						if($bookArray[$i] != "") {
							$bookArray[$i] = str_replace($query, "<kbd style='background-color: #5F5F3F' >".$query."</kbd>", $bookArray[$i]);
							echo "<h4>".$this->bookcase_ID[$i]."<h4>";
							echo "<ul>".$bookArray[$i]."</ul>";
						}
					}
					echo "</div>";
					echo "</div>";
					
					$title = $data['TITLE']	;
					for($i = 0; $i < count($bookArray); $i ++) {
						$bookArray[$i] = "";
					}
					$bookId = $data['BOOKCASE_ID'];
					$bookArray[$bookId] .= "<li>".$data['CONTEXT']."</li>";
					
				}
			}
			
			echo "<div class='panel panel-default block $title' name='$title'>";
			echo "<div class='title panel-heading'>";
			echo "$title</div>";
			echo "<div class='panel-body'>";
			for($i = 0; $i < count($bookArray); $i ++) {
				if($bookArray[$i] != "") {
					$bookArray[$i] = str_replace($query, "<kbd>".$query."</kbd>", $bookArray[$i]);
					echo "<h4>".$this->bookcase_ID[$i]."<h4>";
					echo "<ul>".$bookArray[$i]."</ul>";
				}
			}
			echo "</div>";
			echo "</div>";
			
		}
		//--	檢索文本TITLE目錄
		function queryIndexDirectory($query) {
			$query = "%".$query."%";
			$result = $this->connection->query("SELECT DISTINCT(TITLE), `YEAR_START`, `SEASON` FROM chunqiu WHERE CONTEXT LIKE '$query' UNION
			SELECT DISTINCT(TITLE), `YEAR_START`, `SEASON` FROM zuozhuan WHERE CONTEXT LIKE '$query' UNION 
			SELECT DISTINCT(TITLE), `YEAR_START`, `SEASON` FROM gongyang WHERE CONTEXT LIKE '$query' UNION 
			SELECT DISTINCT(TITLE), `YEAR_START`, `SEASON` FROM guliang WHERE CONTEXT LIKE '$query' ORDER BY `YEAR_START` DESC");
			return $result;
		}
		
		//--	插入文本TITLE目錄
		function queryIndexDirectoryAndSet($query) {
			$result = $this->queryIndexDirectory( $query );
			$titleArray = array();
			//--	ini
			foreach ($result as $data) {
				$title = $data['TITLE'];
				array_push($titleArray, $title);
				break;
			}
			
			foreach ($result as $data) {
				if( $title != $data['TITLE']) {
					$title = $data['TITLE'];
					array_push($titleArray, $title);
				}
			} array_push($titleArray, $title);
			
			for($i = 0; $i < COUNT($titleArray); $i ++)
				echo "<li><a href=# >".$titleArray[$i]."</a></li>";
		}
		
		//*****************************  query page retrive  *****************************//
		//--	group by kingYear
		function groupByYear($query, $selector) {
			
			
			//--	kingYear
			if($selector == 1) {
				$arraySize = 12;
				$selectorArray = $this->kingName;
				//--	data import
				$titleArray = $this->importKingYear($query);
			} 
			//--	season
			else if($selector == 2) {
				$arraySize = 4;
				$selectorArray = $this->seasonName;
				//--	data import
				$titleArray = $this->importSeasonYear($query);
			}
			
			//--	data ini
			$resultCountArray = [];
			$resultData = [];
			for($i = 0; $i < $arraySize; $i ++) {
				$resultData[$i] = "";
				$resultCountArray[$i] = 0;
			}
			
			if($selector == 1) {
				$titleHash = [];
				foreach ($titleArray as $data) {
					if( !in_array($data, $titleHash) ) {
						
						array_push($titleHash, $data);
						$findValue = mb_substr($data, 0, 3);
						$key = array_search($findValue, $selectorArray);
						
						$resultData[$key] .= "<li class='list-group-item'> <a href = '#'>" . $data . "</a></li>";
						$resultCountArray[$key] ++;
					} 
				}
			} 
			else if($selector == 2) {
				
				foreach ($titleArray as $data) {
					$findValue = explode("_", $data)[1];
					
					$key = array_search($findValue, $selectorArray);
						
					$resultData[$key] .= "<li class='list-group-item'><a href = '#'>" . explode("_", $data)[0] . "</a></li>";
					$resultCountArray[$key] ++;
				}
			}
			

			//--	divFront ini
			$resultArray = [];
			for($i = 0; $i < $arraySize; $i ++) {
				$resultArray[$i] = $this->getQueryGroupFront($selector, $i, $selectorArray[$i], $resultCountArray[$i]);
			}
			
			//--	echo
			echo "<div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'>";
			for($i = 0; $i < $arraySize; $i ++) {
				//if( $resultData[$i] == "" ) $resultData[$i] = "<li class='list-group-item'>沒有資訊</li>";
				$resultArray[$i].= $resultData[$i];
				$resultArray[$i] .= "</ul></div></div>";
				echo $resultArray[$i];
			}
			echo "</div>";
		}
		
		//--	算文本數量 用於第一個統計
		function countBooksNum($bookID, $query) {
			$query = "%".$query."%";
			$result = $this->connection->query("SELECT COUNT(*) AS num FROM ".$this->bookID_Name[$bookID]." WHERE CONTEXT LIKE '$query'");
			return $result;
		}
		//--	回傳文本數量陣列
		function findBooksNumArray($query) {
			$numArray = array();
			for($i = 1; $i < 5; $i ++) {
				$result = $this->countBooksNum($i, $query);
				foreach ($result as $data)  {
					array_push($numArray, $data['num']);
				}
			}
			return json_encode($numArray);
		}
		//--	算君王年份數量 用於第二個統計
		function  countYearNum($query) {
			$query = "%".$query."%";
			$result = $this->connection->query("SELECT `TITLE`, `CONTEXT`, `YEAR_START` FROM chunqiu WHERE CONTEXT LIKE '$query' UNION
				SELECT `TITLE`, `CONTEXT`, `YEAR_START` FROM zuozhuan WHERE CONTEXT LIKE '$query' UNION 
				SELECT `TITLE`, `CONTEXT`, `YEAR_START` FROM gongyang WHERE CONTEXT LIKE '$query' UNION 
				SELECT `TITLE`, `CONTEXT`, `YEAR_START` FROM guliang WHERE CONTEXT LIKE '$query'  
				ORDER BY `YEAR_START`  DESC");
			return $result;
		}
		//--	回傳君王年份數量陣列
		function findYearNumsArray($query) {
			$numArray = array_fill(0, 13, 0);
			$result = $this->countYearNum($query);
			foreach ($result as $data)  {
				switch ($data['TITLE']) {
					case strpos($data['TITLE'], "魯隱公") :
						$numArray[0] ++;
						break;
					case strpos($data['TITLE'], "魯桓公") :
						$numArray[1] ++;
						break;
					case strpos($data['TITLE'], "魯莊公") :
						$numArray[2] ++;
						break;
					case strpos($data['TITLE'], "魯閔公") :
						$numArray[3] ++;
						break;
					case strpos($data['TITLE'], "魯僖公") :
						$numArray[4] ++;
						break;
					case strpos($data['TITLE'], "魯文公") :
						$numArray[5] ++;
						break;
					case strpos($data['TITLE'], "魯宣公") :
						$numArray[6] ++;
						break;
					case strpos($data['TITLE'], "魯成公") :
						$numArray[7] ++;
						break;
					case strpos($data['TITLE'], "魯襄公") :
						$numArray[8] ++;
						break;
					case strpos($data['TITLE'], "魯昭公") :
						$numArray[9] ++;
						break;
					case strpos($data['TITLE'], "魯定公") :
						$numArray[10] ++;
						break;
					case strpos($data['TITLE'], "魯哀公") :
						$numArray[11] ++;
						break;	
				}
			}
			return json_encode($numArray);
		}
		
		
		//*****************************  data-depandency function  *****************************//
		
		//--	use to wrap the css of queryGroup
		//--	int # of king, string kingName
		//--	output string result
		function getQueryGroupFront($selector, $num, $kingName, $count) {
			$result = "<div class='panel panel-default'>";
			$result .= "<div class='panel-heading' role='tab' id='collapseListGroupHeading". $selector.$num . "'>";
			$result .= "<h4 class='panel-title'>";
			$result .= "<a class='collapsed' data-toggle='collapse' href='#collapseListGroup" . $selector.$num . 
								"' aria-expanded='false' aria-controls='collapseListGroup" . $selector.$num . "'>";
			$result .= $kingName . "(" . $count . ")";
			$result .= "</a></h4></div>";
			$result.= "<div id='collapseListGroup" . $selector.$num . "' class='panel-collapse collapse' role='tabpanel' 
								aria-labelledby='collapseListGroupHeading" . $selector.$num . "' aria-expanded='false' style='height: 0px;'>";
			$result .= "<ul class='list-group'>";
			return $result;
		}
		
		//--	use to get # of kingYear data
		//--	input query
		//--	output array of kingYearData
		function importKingYear($query) {
			$result = $this->queryIndexDirectory( $query );
			$titleArray = [];
			foreach ($result as $data) {
				$title = $data['TITLE'];
				array_push($titleArray, $title);
			}
			return $titleArray;
		}
		
		//--	use to get # of seasonYear data
		//--	input query
		//--	output array of seasonYear
		function importSeasonYear($query) {
			
			$result = $this->queryIndexDirectory( $query );
			$titleArray = [];
			foreach ($result as $data) {
				if( $data['SEASON'] != "") {
					array_push($titleArray, $data['TITLE'] . "_" . $data['SEASON']);
				} else {
					$month = $this->monthToSeason[ explode( "-", $data['YEAR_START'])[1] ];
					array_push($titleArray, $data['TITLE'] . "_" . $month );
				}
			}
			return $titleArray;
		}
		
	}
?>