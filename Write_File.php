<?php
class WriteFile {

	private $filename;
	private $customerList;
	private $salesmanList;
	private $salesList;
	private $salesmanSalesList;

	function __construct($filename, $customerList, $salesmanList, $salesList, $salesmanSalesList) {

		$this->filename 			= $filename;
		$this->customerList 		= $customerList;
		$this->salesmanList 		= $salesmanList;
		$this->salesList 			= $salesList;
		$this->salesmanSalesList 	= $salesmanSalesList;

	}

	function write()
	{
		
		$body  = "Amount of clients in the input file: ".count($this->customerList)."\n";
		$body .= "Amount of salesman in the input file: ".count($this->salesmanList)."\n";
		arsort($this->salesList);
		$body .= "ID of the most expensive sale: ".key($this->salesList)."\n";
		asort($this->salesmanSalesList);
		$body .= "Worst salesman ever: ".key($this->salesmanSalesList)."\n";
		
		file_put_contents('./data/out/'.$this->filename.'.dat', $body);
		
	}

}

?>

