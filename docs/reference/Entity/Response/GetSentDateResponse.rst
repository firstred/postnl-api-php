.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetSentDateResponse
===================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: GetSentDateResponse


	.. rst-class:: phpdoc-description
	
		| Class GetSentDateResponse\.
		
	
	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($GetSentDate, $Options\)<Firstred\\PostNL\\Entity\\Response\\GetSentDateResponse::\_\_construct\(\)>`
* :php:meth:`public setSentDate\($SentDate\)<Firstred\\PostNL\\Entity\\Response\\GetSentDateResponse::setSentDate\(\)>`
* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Entity\\Response\\GetSentDateResponse::xmlSerialize\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	.. rst-class:: phpdoc-description
	
		| Default properties and namespaces for the SOAP API\.
		
	
	:Type: array 


.. php:attr:: protected static SentDate

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static Options

	:Type: string[] | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $GetSentDate=null, $Options=null)
	
		.. rst-class:: phpdoc-description
		
			| GetSentDateResponse constructor\.
			
		
		
		:Parameters:
			* **$GetSentDate** (:any:`DateTimeInterface <DateTimeInterface>` | string | null)  
			* **$Options** (string[] | null)  

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public setSentDate( $SentDate=null)
	
		
		:Parameters:
			* **$SentDate** (string | :any:`\\DateTimeInterface <DateTimeInterface>` | null)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter\.
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

