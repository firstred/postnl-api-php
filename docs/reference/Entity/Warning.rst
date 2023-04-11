.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Warning
=======


.. php:namespace:: Firstred\PostNL\Entity

.. php:class:: Warning


	:Parent:
		:php:class:`Firstred\\PostNL\\Entity\\AbstractEntity`
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($Code, $Description\)<Firstred\\PostNL\\Entity\\Warning::\_\_construct\(\)>`
* :php:meth:`public getCode\(\)<Firstred\\PostNL\\Entity\\Warning::getCode\(\)>`
* :php:meth:`public setCode\($Code\)<Firstred\\PostNL\\Entity\\Warning::setCode\(\)>`
* :php:meth:`public getDescription\(\)<Firstred\\PostNL\\Entity\\Warning::getDescription\(\)>`
* :php:meth:`public setDescription\($Description\)<Firstred\\PostNL\\Entity\\Warning::setDescription\(\)>`
* :php:meth:`public static jsonDeserialize\($json\)<Firstred\\PostNL\\Entity\\Warning::jsonDeserialize\(\)>`


Properties
----------

.. php:attr:: protected static Code

	:Type: string | null 


.. php:attr:: protected static Description

	:Type: string | null 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $Code=null, $Description=null)
	
		
		:Parameters:
			* **$Code** (string | null)  
			* **$Description** (string | null)  

		
	
	

.. rst-class:: public

	.. php:method:: public getCode()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setCode( $Code)
	
		
		:Parameters:
			* **$Code** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public getDescription()
	
		
		:Returns: string | null 
	
	

.. rst-class:: public

	.. php:method:: public setDescription( $Description)
	
		
		:Parameters:
			* **$Description** (string | null)  

		
		:Returns: static 
	
	

.. rst-class:: public static

	.. php:method:: public static jsonDeserialize( $json)
	
		
		:Parameters:
			* **$json** (:any:`stdClass <stdClass>`)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\Warning <Firstred\\PostNL\\Entity\\Warning>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
	
	

