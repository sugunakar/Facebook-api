<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('dbArray'))
{
	function dbArray($dbarray,$selectedarray){
		foreach($dbarray as $items)
		{
			$isSelected=selectedArray($selectedarray,$items->deptId);
			$getdbArray[]=(object)array(
				"deptId" => $items->deptId,
				"deptName" => $items->deptName,
				"isSelected" => $isSelected
			);
		}
		return $getdbArray;
	}
}

if ( ! function_exists('selectedArray'))
{
	function selectedArray($selectedarray,$selectedItem){
		$isSelected=0;
		if($selectedarray){
			foreach($selectedarray as $items)
			{
				if($selectedItem==$items->deptId){$isSelected=1;}
			}
		}
		return $isSelected;
	}
}

if ( ! function_exists('dbTeamArray'))
{
	function dbTeamArray($dbarray,$selectedarray){
		foreach($dbarray as $items)
		{
			$isSelected=teamselectedArray($selectedarray,$items->memberId);
			$getdbArray[]=(object)array(
				"memberId" => $items->memberId,
				"fullName" => $items->fullName,
				"roleName" => $items->roleName,
				"isSelected" => $isSelected
			);
		}
		return $getdbArray;
	}
}

if ( ! function_exists('teamselectedArray'))
{
	function teamselectedArray($selectedarray,$selectedItem){
		$isSelected=0;
		if($selectedarray){
			foreach($selectedarray as $items)
			{
				if($selectedItem==$items->teamId){$isSelected=1;}
			}
		}
		return $isSelected;
	}
}

if ( ! function_exists('dbTechArray'))
{
	function dbTechArray($dbarray,$selectedarray){
		foreach($dbarray as $items)
		{
			$isSelected=techselectedArray($selectedarray,$items->categoryId);
			$getdbArray[]=(object)array(
				"categoryId" => $items->categoryId,
				"categoryName" => $items->categoryName,
				"isSelected" => $isSelected
			);
		}
		return $getdbArray;
	}
}

if ( ! function_exists('techselectedArray'))
{
	function techselectedArray($selectedarray,$selectedItem){
		$isSelected=0;
		if($selectedarray){
			foreach($selectedarray as $items)
			{
				if($selectedItem==$items->technologyId){$isSelected=1;}
			}
		}
		return $isSelected;
	}
}

if ( ! function_exists('dbRoleArray'))
{
	function dbRoleArray($dbarray,$selectedarray){
		foreach($dbarray as $items)
		{
			$isSelected=roleselectedArray($selectedarray,$items->roleId);
			$getdbArray[]=(object)array(
				"roleId" => $items->roleId,
				"roleName" => $items->roleName,
				"isSelected" => $isSelected
			);
		}
		return $getdbArray;
	}
}

if ( ! function_exists('roleselectedArray'))
{
	function roleselectedArray($selectedarray,$selectedItem){
		$isSelected=0;
		if($selectedarray){
			foreach($selectedarray as $items)
			{
				if($selectedItem==$items->roleId){$isSelected=1;}
			}
		}
		return $isSelected;
	}
}

if ( ! function_exists('getIndianCurrency'))
{
	function getIndianCurrency($number)
	{
			$no = round($number);
			$decimal = round($number - ($no = floor($number)), 2) * 100;    
			$digits_length = strlen($no);    
			$i = 0;
			$str = array();
			$words = array(
				0 => '',
				1 => 'One',
				2 => 'Two',
				3 => 'Three',
				4 => 'Four',
				5 => 'Five',
				6 => 'Six',
				7 => 'Seven',
				8 => 'Eight',
				9 => 'Nine',
				10 => 'Ten',
				11 => 'Eleven',
				12 => 'Twelve',
				13 => 'Thirteen',
				14 => 'Fourteen',
				15 => 'Fifteen',
				16 => 'Sixteen',
				17 => 'Seventeen',
				18 => 'Eighteen',
				19 => 'Nineteen',
				20 => 'Twenty',
				30 => 'Thirty',
				40 => 'Forty',
				50 => 'Fifty',
				60 => 'Sixty',
				70 => 'Seventy',
				80 => 'Eighty',
				90 => 'Ninety');
			$digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
			while ($i < $digits_length) {
				$divider = ($i == 2) ? 10 : 100;
				$number = floor($no % $divider);
				$no = floor($no / $divider);
				$i += $divider == 10 ? 1 : 2;
				if ($number) {
					$plural = (($counter = count($str)) && $number > 9) ? '' : null;            
					$str [] = ($number < 21) ? $words[$number] . ' ' . $digits[$counter] . $plural : $words[floor($number / 10) * 10] . ' ' . $words[$number % 10] . ' ' . $digits[$counter] . $plural;
				} else {
					$str [] = null;
				}  
			}
			
			$Rupees = implode(' ', array_reverse($str));
			$paise = ($decimal) ? "And Paise " . ($words[$decimal - $decimal%10]) ." " .($words[$decimal%10])  : '';
			return ($Rupees ? $Rupees : '') . $paise;
	}
}	

if ( ! function_exists('getMonthsDropdown'))
{
	function getMonthsDropdown($selectedMonth){
	
		$MonthArray = array(
			"1" => "January", 
			"2" => "February", 
			"3" => "March", 
			"4" => "April",
			"5" => "May", 
			"6" => "June", 
			"7" => "July", 
			"8" => "August",
			"9" => "September", 
			"10" => "October", 
			"11" => "November", 
			"12" => "December"
		);
	
		$getMonth="";
		 foreach ($MonthArray as $monthNum=>$month) {
		 	$selected = ($selectedMonth == $monthNum) ? 'selected' : '';
			$getMonth .='<option ' . $selected . ' value="' . $monthNum . '">' . $month . '</option>';
		 }
		 return $getMonth;
	}

}

if ( ! function_exists('INRFormat'))
{
	function INRFormat($number){
		return "Rs. ".preg_replace("/(\d+?)(?=(\d\d)+(\d)(?!\d))(\.\d+)?/i", "$1,", $number)."/-";
	}
}

if ( ! function_exists('datetoAddfromDate'))
{
	function datetoAddfromDate($currentDate,$datetoadd){
			return date("Y-m-d H:i:s", strtotime($datetoadd, strtotime($currentDate)));
	}
}	

if ( ! function_exists('arraykeyExists'))
{
	function arraykeyExists($selectedarray,$selectedItem){
		if($selectedarray){
			foreach($selectedarray as $key=>$val)
			{
				if($selectedItem==$key){return $val;}
			}
		}
	}
}

if ( ! function_exists('arraykeyValuesExists'))
{
	function arraykeyValuesExists($selectedarray,$selectedItem){
		if($selectedarray){
			foreach($selectedarray as $key=>$val)
			{
				if($selectedItem==$key){return array("keyName" => $val[0],"colorName" => $val[1]);}
			}
		}
	}
}

if ( ! function_exists('moneyFormatIndia'))
{
	function moneyFormatIndia($num){
		$explrestunits = "" ;
		if(strlen($num)>3){
			$lastthree = substr($num, strlen($num)-3, strlen($num));
			$restunits = substr($num, 0, strlen($num)-3); // extracts the last three digits
			$restunits = (strlen($restunits)%2 == 1)?"0".$restunits:$restunits; // explodes the remaining digits in 2's formats, adds a zero in the beginning to maintain the 2's grouping.
			$expunit = str_split($restunits, 2);
			for($i=0; $i < sizeof($expunit);  $i++){
				// creates each of the 2's group and adds a comma to the end
				if($i==0)
				{
					$explrestunits .= (int)$expunit[$i].","; // if is first value , convert into integer
				}else{
					$explrestunits .= $expunit[$i].",";
				}
			}
			$thecash = $explrestunits.$lastthree;
		} else {
			$thecash = $num;
		}
		return $thecash; // writes the final format where $currency is the currency symbol.
	}
}

if(!function_exists('timeago'))
{
	function timeago($datetime, $full = false) {
		 $today = time();    
		 $createdday= strtotime($datetime); 
		 $datediff = abs($today - $createdday);  
		 $difftext="";  
		 $dateFormat='h:i A';
		 $years = floor($datediff / (365*60*60*24));  
		 $months = floor(($datediff - $years * 365*60*60*24) / (30*60*60*24));  
		 $days = floor(($datediff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));  
		 $hours= floor($datediff/3600);  
		 $minutes= floor($datediff/60);  
		 $seconds= floor($datediff);  
		 //year checker  
		 if($difftext=="")  
		 {  
			   if($years>1){
					$difftext=date('j-n-Y',strtotime($datetime));
					$dateFormat='j-n-Y';  
			   }elseif($years==1){
					$difftext=date('j-n-Y',strtotime($datetime));  
					$dateFormat='j-n-Y';  
			   }
		 }  
		 //month checker  
		 if($difftext==""){  
			if($months>1){
				$difftext=date('j-n-Y',strtotime($datetime));  
				$dateFormat='j-n-Y';  
			}elseif($months==1){
				$difftext=date('j-n-Y',strtotime($datetime)); 
				$dateFormat='j-n-Y';   
			}
		 }  
		 //month checker  
		 if($difftext=="") {  
			if($days>1){
				$difftext=date('M j',strtotime($datetime));  
				$dateFormat='M j';  
			}elseif($days==1){
				$difftext=date('M j',strtotime($datetime));  
				$dateFormat='M j';  
			}
		 }  
		 //hour checker  
		 if($difftext==""){  
			if($hours>1){  
				$difftext=date('h:i A',strtotime($datetime));  
				$dateFormat='h:i A';  
			}elseif($hours==1)  {
				$difftext=date('h:i A',strtotime($datetime)); 
				$dateFormat='h:i A';   
			}
		 }  
		 //minutes checker  
		 if($difftext==""){  
			if($minutes>1){
				$difftext=date('h:i A',strtotime($datetime));  
				$dateFormat='h:i A';  
			}elseif($minutes==1){
				$difftext=date('h:i A',strtotime($datetime));  
				$dateFormat='h:i A';  
			}
		 }  
		 //seconds checker  
		 if($difftext==""){  
			if($seconds>1){
				$difftext=date('h:i A',strtotime($datetime)); 
				$dateFormat='h:i A';   
			}elseif($seconds==1){
				$difftext=date('h:i A',strtotime($datetime));  
				$dateFormat='h:i A';  
			}
		 }  
	 return array(0 => $difftext,1 => $dateFormat);
	}
}