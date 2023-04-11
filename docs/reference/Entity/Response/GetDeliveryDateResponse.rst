.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


GetDeliveryDateResponse
=======================


.. php:namespace:: Firstred\PostNL\Entity\Response

.. php:class:: GetDeliveryDateResponse


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($DeliveryDate, $Options\)<Firstred\\PostNL\\Entity\\Response\\GetDeliveryDateResponse::\_\_construct\(\)>`
* :php:meth:`public getOptions\(\)<Firstred\\PostNL\\Entity\\Response\\GetDeliveryDateResponse::getOptions\(\)>`
* :php:meth:`public setOptions\($Options\)<Firstred\\PostNL\\Entity\\Response\\GetDeliveryDateResponse::setOptions\(\)>`
* :php:meth:`public getDeliveryDate\(\)<Firstred\\PostNL\\Entity\\Response\\GetDeliveryDateResponse::getDeliveryDate\(\)>`
* :php:meth:`public setDeliveryDate\($DeliveryDate\)<Firstred\\PostNL\\Entity\\Response\\GetDeliveryDateResponse::setDeliveryDate\(\)>`
* :php:meth:`public static jsonDeserialize\($json\)<Firstred\\PostNL\\Entity\\Response\\GetDeliveryDateResponse::jsonDeserialize\(\)>`


Properties
----------

.. php:attr:: protected static DeliveryDate

	:Type: :any:`\\DateTimeInterface <DateTimeInterface>` | null 


.. php:attr:: protected static Options

	:Type: string[] | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct(string|\\DateTimeInterface|null $DeliveryDate=null, $Options=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public getOptions()
	
		
		:Returns: string[] | null 
	
	

.. rst-class:: public

	.. php:method:: public setOptions( $Options)
	
		
		:Parameters:
			* **$Options** (string[] | null)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Response\\GetDeliveryDateResponse <Firstred\\PostNL\\Entity\\Response\\GetDeliveryDateResponse>` 
	
	

.. rst-class:: public

	.. php:method:: public getDeliveryDate()
	
		
		:Returns: :any:`\\DateTimeInterface <DateTimeInterface>` | null 
	
	

.. rst-class:: public

	.. php:method:: public setDeliveryDate(\\DateTimeInterface|string|null $DeliveryDate=null)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

.. rst-class:: public static

	.. php:method:: public static jsonDeserialize( $json)
	
		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
	
	

