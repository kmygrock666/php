<?php 
	// 開檔 寫檔
	function Wlog($dir,$msg,$BN)
	{
		$dateString =  date_format(new DateTime(), 'Y-m-d');
		$file = dirname(dirname(__FILE__)) . '/'.$dir."/".$BN.'-'.$dateString.".txt";
	
		$dateString =  date_format(new DateTime(), 'Y-m-d H:i:s');
		$myfile = file_put_contents($file, $dateString." | ".$msg.PHP_EOL , FILE_APPEND);
		//$myfile = file_put_contents($file, $dateString." | ".$msg.PHP_EOL , FILE_APPEND|LOCK_EX); //锁定文件
		// echo __FILE__."<br>" ; // 取得当前文件的绝对地址，结果：D:\www\test.php 
		// echo dirname(__FILE__)."<br>"; // 取得当前文件所在的绝对目录，结果：D:\www\ 
		// echo dirname(dirname(__FILE__)); //取得当前文件的上一层目录名，结果：D:\ 
	}
	//二維排除不重複值
	function array_unique_2d($array2D)
	{
		 $temp = $res = array();
		 foreach ($array2D as $v)
		 {
			  $v = json_encode($v);
			  $temp[] = $v;
		 }
		 $temp = array_unique($temp);
		 foreach ($temp as $item)
		 {
		  	$res[] = json_decode($item,true);
		 }
		 return $res;
	}
	//二維轉一維
	function transfer($twoDimensional)
	{
		//$twoDimensional = array(array("A"), array("B"), array("c"));
		$oneDimensional = call_user_func_array('array_merge', $twoDimensional);
		echo "<pre>";
		print_r($oneDimensional);
		echo "</pre>";
		return $oneDimensional;
	}
	/* 傳送Request (POST)至另一個網頁， api用，請不要修改增加屬性 */
	function curlhtmlForApi($url , $arr)
	{ 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, true); // 啟用POST
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query( $arr ));  
		 
		$output = curl_exec($ch); 
		curl_close($ch);

		return $output; 
	}

	//自訂義排序
	function SortArray()
	{
		$userData = array();
		uasort($userData, function($a,$b){
	            return $a["level"]>$b["level"];
	    });
	}


	//隨機碼反轉
	function CodeStringToInt($CodeString)
	{
		$arrstr = explode("g",$CodeString);
		if(count($arrstr)>1){
			$CodeString = $arrstr[1];
			//$CodeString = str_pad($CodeString,strlen($arrstr[0]),"N",STR_PAD_LEFT);
		}
		else{
			$CodeString = $arrstr[0];
		}
		$CodeString = str_split($CodeString);
		$map = GetCodeMap();
		$unit = count($map);
		$arr = array();
		foreach ($CodeString as $value) {
			$arr[] = array_search($value, $map);
		}		
		$arr = array_reverse($arr);
		$i = 0;
		$out = 0;
		foreach ($arr as $value) {
			$out +=  $value * pow($unit,$i) ;
			$i = $i+ 1; 
		}
		return $out;
	}
	
	//產生隨機碼
	function IntToCodeString($int)
	{
		$arr = array();
		$bit = 10;
		$map = GetCodeMap();
		$unit = count($map);
		$c = ($int - ( $int % $unit)) / $unit;
		$arr[] = ( $int % $unit);
		while($c){
			$b = $c % $unit;
			$c = ($c - $b) / $unit;
			$arr[] = $b;
		}
		//'4',
		if(count($arr) < $bit)
			$arr[] = -1;
		while(count($arr) < $bit)
			$arr[] = -2;
		$arr = array_reverse($arr);
		$out = '';
		foreach ($arr as &$value)
		{
			if($value==-1){
				$out .= 'g';
			}
			else if($value==-2){
				$out .= $map[rand(0,count($map)-1)];
			}
			else{
				$out .= $map[$value];
			}
		}
		return $out;
	}
	
	

	
 //    <!-- $("#sdate").datetimepicker({
 //    	dateFormat:"yy-mm-dd",
	//     onSelect:function(dateText,inst){
	//        $("#edate").datetimepicker("option","minDate",dateText);限制日期區間
	//        $("#edate").datetimepicker("option","minDateTime",new Date(dateText)); //限制時間區間
	//     }
	// });

	// $("#edate").datetimepicker({
	// 	dateFormat:"yy-mm-dd",
	//     onSelect:function(dateText,inst){
	//         $("#sdate").datetimepicker("option","maxDate",dateText);
	//         $("#sdate").datetimepicker("option","maxDateTime",new Date(dateText));
	//     }
	// });