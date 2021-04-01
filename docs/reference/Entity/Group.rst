.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Group
=====


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Group


	.. rst-class:: phpdoc-description
	
		| Class Group\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($GroupCount, $GroupSequence, $GroupType, $MainBarcode\)<Firstred\\PostNL\\Entity\\Group::\_\_construct\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: string[][] 


.. php:attr:: protected static GroupCount

	.. rst-class:: phpdoc-description
	
		| Amount of shipments in the group\.
		
	
	:Type: string | null 


.. php:attr:: protected static GroupSequence

	.. rst-class:: phpdoc-description
	
		| Sequence number\.
		
	
	:Type: string | null 


.. php:attr:: protected static GroupType

	.. rst-class:: phpdoc-description
	
		| The type of group\.
		
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

	.. php:method:: public __construct( $GroupCount=null, $GroupSequence=null, $GroupType=null, $MainBarcode=null)
	
		.. rst-class:: phpdoc-description
		
			| Group Constructor\.
			
		
		
		:Parameters:
			* **$GroupCount** (string | null)  
			* **$GroupSequence** (string | null)  
			* **$GroupType** (string | null)  
			* **$MainBarcode** (string | null)  

		
	
	

