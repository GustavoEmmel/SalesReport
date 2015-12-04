<?php

include_once('./Sales_Report.php');

class Application {


	function __construct() {

		$this->searchFolder();

	}

	function searchFolder()
	{
		$inPath 	= "data/in/";
		$outPath 	= "data/out/";
		
		$inFiles 	= $this->readFolder($inPath);
		$outFiles	= $this->readFolder($outPath);
		
		if($inFiles > $outFiles){
			$SalesReport = new SalesReport();
		}
		
		$this->searchFolder();

	}

	function readFolder($path)
	{

		$dir = dir($path);

		$count = 0;
		
		while($file = $dir -> read()){

			$ext = @pathinfo($path.$file, PATHINFO_EXTENSION);

			if($ext === 'dat'){
				$count++;
			}

		}
		$dir -> close();
		
		return $count;
	}






}

$App = new Application($_REQUEST);
?>

