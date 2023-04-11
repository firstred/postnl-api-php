.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


AbstractEntity
==============


.. php:namespace:: Firstred\PostNL\Entity

.. rst-class::  abstract

.. php:class:: AbstractEntity


	:Implements:
		:php:interface:`JsonSerializable` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\(\)<Firstred\\PostNL\\Entity\\AbstractEntity::\_\_construct\(\)>`
* :php:meth:`public static create\($properties\)<Firstred\\PostNL\\Entity\\AbstractEntity::create\(\)>`
* :php:meth:`public getId\(\)<Firstred\\PostNL\\Entity\\AbstractEntity::getId\(\)>`
* :php:meth:`public setId\($id\)<Firstred\\PostNL\\Entity\\AbstractEntity::setId\(\)>`
* :php:meth:`public setCurrentService\($currentService\)<Firstred\\PostNL\\Entity\\AbstractEntity::setCurrentService\(\)>`
* :php:meth:`public getCurrentService\(\)<Firstred\\PostNL\\Entity\\AbstractEntity::getCurrentService\(\)>`
* :php:meth:`public getSerializableProperties\($withAliases\)<Firstred\\PostNL\\Entity\\AbstractEntity::getSerializableProperties\(\)>`
* :php:meth:`public jsonSerialize\(\)<Firstred\\PostNL\\Entity\\AbstractEntity::jsonSerialize\(\)>`
* :php:meth:`public static jsonDeserialize\($json\)<Firstred\\PostNL\\Entity\\AbstractEntity::jsonDeserialize\(\)>`


Properties
----------

.. php:attr:: protected static id

	:Type: string 


.. php:attr:: protected static currentService

	:Type: :any:`class\-string <class\-string>` 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct()
	
		
	
	

.. rst-class:: public static deprecated

	.. php:method:: public static create( $properties=\[\])
	
		.. rst-class:: phpdoc-description
		
			| Create an instance of this class without touching the constructor\.
			
		
		
		:Parameters:
			* **$properties** (array)  

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\AbstractEntity <Firstred\\PostNL\\Entity\\AbstractEntity>` 
		:Since: 1.0.0 
		:Deprecated: 2.0.0 Use the constructor instead with named arguments
	
	

.. rst-class:: public

	.. php:method:: public getId()
	
		
		:Returns: string 
	
	

.. rst-class:: public

	.. php:method:: public setId(string|int $id)
	
		
		:Parameters:
			* **$id** (string | int)  

		
		:Returns: static 
	
	

.. rst-class:: public

	.. php:method:: public setCurrentService( $currentService)
	
		
		:Parameters:
			* **$currentService** (:any:`class\-string <class\-string>`)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
	
	

.. rst-class:: public

	.. php:method:: public getCurrentService()
	
		
		:Returns: :any:`class\-string <class\-string>` 
	
	

.. rst-class:: public

	.. php:method:: public getSerializableProperties( $withAliases=false)
	
		
		:Returns: :any:`array<string,string\> <array<string,string\>>` 
		:Since: 2.0.0 
	
	

.. rst-class:: public

	.. php:method:: public jsonSerialize()
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for \`json\_encode\`\.
			
		
		
		:Returns: array 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\ServiceNotSetException <Firstred\\PostNL\\Exception\\ServiceNotSetException>` 
	
	

.. rst-class:: public static

	.. php:method:: public static jsonDeserialize( $json)
	
		
		:Parameters:
			* **$json** (:any:`stdClass <stdClass>`)  {"EntityName": object}

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\DeserializationException <Firstred\\PostNL\\Exception\\DeserializationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 1.0.0 
	
	

