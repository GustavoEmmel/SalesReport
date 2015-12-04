<?php

include_once('./Write_File.php');

class SalesReport {

	function __construct() {

		$folder = "data/out/";

		$this->clearFiles($folder);

		$this->readFiles();

	}

	function readFiles()
	{

		$path = "data/in/";

		$dir = dir($path);

		while($file = $dir -> read()){

			$ext = @pathinfo($path.$file, PATHINFO_EXTENSION);

			if($ext === 'dat'){

				$fd = fopen($path.$file, "r");

				$salesmanList = array();
				$s = 0;

				$customerList = array();
				$c = 0;

				$totalSale = 0;
				$salesList = array();
				$salesmanSalesList = array();

				while (!feof($fd)) {
					$linha = utf8_decode(fgets($fd, 750));

					if (substr($linha, 0, 3) == '001') {
						$salesmanList[$s] = $linha;
						$s++;
					}

					if (substr($linha, 0, 3) == '002') {
						$customerList[$c] = $linha;
						$c++;
					}

					if (substr($linha, 0, 3) == '003') {
						$sale = explode("ç", $linha);

						$totalSale = $this->calculateSales($linha);

						$salesList[$sale[1]] = $totalSale;

						if (isset($salesmanSalesList[$sale[3]])) {
							$salesmanSalesList[$sale[3]] += $totalSale;
						} else {
							$salesmanSalesList[$sale[3]] = $totalSale;
						}

					}

				}

				$Writer = new WriteFile($file, $customerList, $salesmanList, $salesList, $salesmanSalesList);
				$Writer->write();

			}

		}
		$dir -> close();
	}

	function calculateSales($itemList)
	{

		$sales = str_replace('[', '', $itemList);
		$sales = str_replace(']', '', $sales);

		$sale = explode(', ', $sales);
		$totalSale = 0;

		foreach ($sale as $value) {

			$item = explode('-', $value);

			$qtd = trim($item[1]);

			$itemValue = trim($item[2]);
			$itemValue = preg_replace("#(\s)+#", "", $itemValue);

			$totalItemValue = $qtd * $itemValue;
			$totalSale += $totalItemValue;

		}

		return $totalSale;

	}

	function clearFiles($folder)
	{

		if(is_dir($folder)){

			$dir = dir($folder);

			while($file = $dir->read()){

				if(($file != '.') && ($file != '..')){
					unlink($folder.$file);
				}

			}

		}

	}

}

$Report = new SalesReport($_REQUEST);

?>

