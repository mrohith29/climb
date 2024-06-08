<?php
namespace ClimbUI\Imprint\Body;
use Approach\Render;

/**
	* This class was generated by Approach\Imprint::Mint()
	* It can be used to create a new Render tree based on the original Pattern
	*/
	class IssueBody extends Render\Node
	{
	public static array $tokens = [
		'Body','Metadata'
	];
	public array $token_nodes = [];
	
	public function __construct(array $tokens = [])
	{
		$Node_0 = new Render\Node( );
	// Instantiating HTML_0__classes for upcoming classes assignment
		$HTML_0__classes = new Render\Node( );
			$HTML_0__classes[] = $Attribute_0 = new Render\Attribute( );


	// Instantiating HTML_0__attributes for upcoming attributes assignment
		$HTML_0__attributes = new Render\Attribute( );

	$Node_0[] = $HTML_0 = new Render\HTML( tag : 'div', classes: $HTML_0__classes, attributes: $HTML_0__attributes, content : '(-)Body
            
            (-)Metadata' );
		// Instantiating HTML_1__classes for upcoming classes assignment
			$HTML_1__classes = new Render\Node( );
				$HTML_1__classes[] = $Attribute_2 = new Render\Attribute( );


		// Instantiating HTML_1__attributes for upcoming attributes assignment
			$HTML_1__attributes = new Render\Attribute( );

		// Instantiating HTML_1__content for upcoming content assignment
			$HTML_1__content = $this->token_nodes['Body'] = new Render\Token( name : 'Body' );

		$HTML_0[] = $HTML_1 = new Render\HTML( tag : 'div', classes: $HTML_1__classes, attributes: $HTML_1__attributes, content: $HTML_1__content );
		// Instantiating HTML_2__classes for upcoming classes assignment
			$HTML_2__classes = new Render\Node( );
				$HTML_2__classes[] = $Attribute_4 = new Render\Attribute( );


		// Instantiating HTML_2__attributes for upcoming attributes assignment
			$HTML_2__attributes = new Render\Attribute( );

		$HTML_0[] = $HTML_2 = new Render\HTML( tag : 'details', classes: $HTML_2__classes, attributes: $HTML_2__attributes );
			// Instantiating HTML_3__classes for upcoming classes assignment
				$HTML_3__classes = new Render\Node( );
					$HTML_3__classes[] = $Attribute_6 = new Render\Attribute( );


			// Instantiating HTML_3__attributes for upcoming attributes assignment
				$HTML_3__attributes = new Render\Attribute( );

			// Instantiating HTML_3__content for upcoming content assignment
				$HTML_3__content = $this->token_nodes['Metadata'] = new Render\Token( name : 'Metadata' );

			$HTML_2[] = $HTML_3 = new Render\HTML( tag : 'pre', classes: $HTML_3__classes, attributes: $HTML_3__attributes, content: $HTML_3__content );




		foreach($tokens as $key => $value){
			$this->token_nodes[$key]->content = $tokens[$key];
		}
		$this->nodes[] = $Node_0;

        parent::__construct();
	}
}