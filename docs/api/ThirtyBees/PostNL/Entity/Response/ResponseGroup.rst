.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


ResponseGroup
=============


.. php:namespace:: ThirtyBees\PostNL\Entity\Response

.. php:class:: ResponseGroup


	.. rst-class:: phpdoc-description
	
		| Class ResponseGroup
		
	
	:Parent:
		:php:class:`ThirtyBees\\PostNL\\Entity\\AbstractEntity`
	

Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static GroupCount

	.. rst-class:: phpdoc-description
	
		| Amount of shipments in the ResponseGroup\.
		
	
	:Type: string | null 


.. php:attr:: protected static GroupSequence

	.. rst-class:: phpdoc-description
	
		| Sequence number\.
		
	
	:Type: string | null 


.. php:attr:: protected static GroupType

	.. rst-class:: phpdoc-description
	
		| The type of Group\.
		
		| Possible values:
		| 
		| \- \`01\`: Collection request
		| \- \`03\`: Multiple parcels in one shipment \(multi\-colli\)
		| \- \`04\`: Single parcel in one shipment
		
	
	:Type: string | null 


.. php:attr:: protected static MainBarcode

	.. rst-class:: phpdoc-description
	
		| Main barcode for the shipment\.
		
	
	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $groupCount=null, $groupSequence=null, $groupType=null, $mainBarcode=null)
	
		.. rst-class:: phpdoc-description
		
			| ResponseGroup Constructor\.
			
		
		
		:Parameters:
			* **$groupCount** (string | null)  
			* **$groupSequence** (string | null)  
			* **$groupType** (string | null)  
			* **$mainBarcode** (string | null)  

		
	
	

