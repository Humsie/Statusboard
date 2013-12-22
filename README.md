# Panel classes for Panic Statusboard

Statusboard gives you a collection of generic classes to display (custom) content using [Panic's Status Board app](http://www.panic.com/statusboard/).

## Quickstart

### Manual

Download and code and make sure you psr-0 autoloading is correctly setup.

### Composer

Todo: add to packagist

## Usage

If your psr-0 autoloading is correctly setup, is as easy as:


	$graph = new \Statusboard\Graph();
	$graph->setTitle("Graph Title");
	$graph->setRefresh(15);
	$graph->addDatasequence("Datasequence Title 1")->setColor("red");
	$graph->addDatasequence("Datasequence Title 2", "ds2")->setColor("blue");

	$graph->x()->setShowEveryLabel(false);
	$graph->y()->setHide(true);
    //$graph->setError("No Data found", "Empty response from backend");

	for ($i = 0; $i < 3; $i++) {
		$graph->datasequence("Datasequence Title 1")->newDatapoint((2000 + $i), rand(10, 300));
		$graph->datasequence("ds2")->newDatapoint((string)(2000 + $i), rand(10, 300));
	}
	
	echo $graph->output();

this code generated 2 elements with 3 random values.
