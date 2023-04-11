.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Group
=====


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Group


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($GroupCount, $GroupSequence, $GroupType, $MainBarcode\)<Firstred\\PostNL\\Entity\\Group::\_\_construct\(\)>`
* :php:meth:`public getGroupCount\(\)<Firstred\\PostNL\\Entity\\Group::getGroupCount\(\)>`
* :php:meth:`public setGroupCount\($GroupCount\)<Firstred\\PostNL\\Entity\\Group::setGroupCount\(\)>`
* :php:meth:`public getGroupSequence\(\)<Firstred\\PostNL\\Entity\\Group::getGroupSequence\(\)>`
* :php:meth:`public setGroupSequence\($GroupSequence\)<Firstred\\PostNL\\Entity\\Group::setGroupSequence\(\)>`
* :php:meth:`public getGroupType\(\)<Firstred\\PostNL\\Entity\\Group::getGroupType\(\)>`
* :php:meth:`public setGroupType\($GroupType\)<Firstred\\PostNL\\Entity\\Group::setGroupType\(\)>`
* :php:meth:`public getMainBarcode\(\)<Firstred\\PostNL\\Entity\\Group::getMainBarcode\(\)>`
* :php:meth:`public setMainBarcode\($MainBarcode\)<Firstred\\PostNL\\Entity\\Group::setMainBarcode\(\)>`


Properties
----------

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
	
		
		:Parameters:
			* **$GroupCount** (string | null)  
			* **$GroupSequence** (string | null)  
			* **$GroupType** (string | null)  
			* **$MainBarcode** (string | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getGroupCount()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setGroupCount( $GroupCount)
	
		
		:Parameters:
			* **$GroupCount** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getGroupSequence()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setGroupSequence( $GroupSequence)
	
		
		:Parameters:
			* **$GroupSequence** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getGroupType()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setGroupType( $GroupType)
	
		
		:Parameters:
			* **$GroupType** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getMainBarcode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setMainBarcode( $MainBarcode)
	
		
		:Parameters:
			* **$MainBarcode** (string | null)  

		
		:Returns: static 
	
	

