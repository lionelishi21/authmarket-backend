<?php 
namespace App\Repositories;
use Goutte;



class Scraper {

	public function FetchJaCars( $attributes = array()) {

		$myarray = array();
        
        $crawler = Goutte::request('GET', 'https://www.jacars.net/cars/audi');
	    $response = $crawler->filter('.announcement-container ')->each(function ($node) use (&$myarray, $crawler) {
	      	$image = $node->filter('.list-announcement-block-img img')->getNode(0)->getAttribute('src');
	      	$title =  trim(preg_replace('/\s\s+/', ' ', $node->filter('.announcement-block-text .announcement-block__title')->getNode(0)->textContent));
	      	$prices = trim(preg_replace('/\s\s+/', ' ', $node->filter('.announcement-block-link .announcement-block__price')->getNode(0)->textContent));
	      	$myarray[] = array(
		  		'title' => $title,
		  		'prices' => $prices,
		  		'image' => $image
	      	);
	    });

	    return $myarray;
	}

	/**
	 * THIS FUNCTION TEST JA CARS COMPARISON
	 * @param  [type] $attributes [description]
	 * @return [type]             [description]
	 */
	public function testJaCarsComparison($attributes) {

		$response = array();
		$myarray = array();

		$crawler = Goutte::request('GET', 'https://www.jacars.net/cars/'.$attributes['make'].'/'.$attributes['model']);
		$response = $crawler->filter('.announcement-container ')->each(function ($node) use (&$myarray, $crawler) {
	      
	        $image = $node->filter('.list-announcement-block-img img')->getNode(0)->getAttribute('src');
	      	
	      	$title =  trim(preg_replace('/\s\s+/', ' ', 
	      		      $node->filter('.announcement-block-text .announcement-block__title')
			      		->getNode(0)
			      		->textContent));

	      	$prices = trim(preg_replace('/\s\s+/', ' ', 
			      		$node->filter('.announcement-block-link .announcement-block__price')
			      		->getNode(0)
			      		->textContent));

	      	$myarray[] = array( 'title' => $title,'prices' => $prices,'image' => $image);
	    });

	    return $myarray;
	}

}



 ?>