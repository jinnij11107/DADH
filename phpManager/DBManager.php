<?php
	class DBManager{
		//attribute
		private $dbhost = '140.112.30.226:13003';
		private $dbuser = 'test';
		private $dbpass = 'lab303';
		private $dbname = 'chunqiusys2';
		private $bookID_Name = array(1=>"chunqiu", 2=>"zuozhuan", 3=>"gongyang", 4=>"guliang", 5=>"chunqiujingjie");
		private $connection;
		
		//constructor
		function __construct() {
			$this->connection = new PDO('mysql:host='.$this->dbhost.';dbname='.$this->dbname.';charset=utf8', $this->dbuser, $this->dbpass);
		}
		function __destruct() {
			$this->connection;
		}
		function query_book($bookID){
			$result = $this->connection->query('select * FROM '.$this->bookID_Name[$bookID].' ORDER BY ID');
			return $result;
		}
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
						echo "<div class='title panel-heading'><button type='button' class='btn btn-default'><span class='glyphicon glyphicon-align-justify' /></button>";
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
						echo $stmt + "</br>";
					}
					fclose($file);
				}
			} else {
				echo "nope";
			}
		}
	}
?>