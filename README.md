# Panel classes for Panic Statusboard

Statusboard gives you a collection of generic classes to display (custom) content using [Panic's Status Board app](http://www.panic.com/statusboard/).

## Quickstart

### Manual

Download and code and make sure you psr-0 autoloading is correctly setup.

### Composer

Todo: add to packagist

## Usage

### Line or Bar Graph


	$graph = new \Statusboard\Graph("Graph Title");
	//$graph->setTitle("Graph Title");
	
	$graph->setType("line");
	//$graph->setType("bar");
	
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

### Projects Table

   	$table = new \Statusboard\Table(
   		new \Statusboard\Table\Row\Projects()
   	);
	
	$table->hideHeaders();
	
	$table->addRow("project1")
	
	$table->addRow("project2")
	    ->setIcon("project.png")
	    ->setName("Statusboard")
	    ->setVersion("1.1")
	    ->addPerson("foo.jpg")
	    ->addPerson("bar.jpg")
	    ->setBars(10);

	$table->row("project1")
		->setName('Project 1')
		->setVersion("1.0")
		->addPerson("foo.jpg")
		->addPerson("bar.jpg");
	
	echo $table->getOutput();
	
