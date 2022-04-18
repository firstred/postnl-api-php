.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


AbstractEntity
==============


.. php:namespace:: Firstred\PostNL\Entity

.. rst-class::  abstract

.. php:class:: AbstractEntity


	.. rst-class:: phpdoc-description
	
		| Class Entity\.
		
	
	:Implements:
		:php:interface:`JsonSerializable` :php:interface:`Firstred\\PostNL\\Util\\XmlSerializable` 
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\(\)<Firstred\\PostNL\\Entity\\AbstractEntity::\_\_construct\(\)>`
* :php:meth:`public static create\($properties\)<Firstred\\PostNL\\Entity\\AbstractEntity::create\(\)>`
* :php:meth:`public \_\_call\($name, $value\)<Firstred\\PostNL\\Entity\\AbstractEntity::\_\_call\(\)>`
* :php:meth:`public jsonSerialize\(\)<Firstred\\PostNL\\Entity\\AbstractEntity::jsonSerialize\(\)>`
* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Entity\\AbstractEntity::xmlSerialize\(\)>`
* :php:meth:`public static jsonDeserialize\($json\)<Firstred\\PostNL\\Entity\\AbstractEntity::jsonDeserialize\(\)>`
* :php:meth:`public static xmlDeserialize\($xml\)<Firstred\\PostNL\\Entity\\AbstractEntity::xmlDeserialize\(\)>`
* :php:meth:`public static shouldBeAnArray\($fqcn, $propertyName\)<Firstred\\PostNL\\Entity\\AbstractEntity::shouldBeAnArray\(\)>`
* :php:meth:`public static getFullyQualifiedEntityClassName\($shortName\)<Firstred\\PostNL\\Entity\\AbstractEntity::getFullyQualifiedEntityClassName\(\)>`


Properties
----------

.. php:attr:: public defaultProperties

	:Type: array 


.. php:attr:: protected static id

	:Type: string 


.. php:attr:: protected static currentService

	:Type: string 


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct()
	
		.. rst-class:: phpdoc-description
		
			| AbstractEntity constructor\.
			
		
		
	
	

.. rst-class:: public static

	.. php:method:: public static create( $properties=\[\])
	
		.. rst-class:: phpdoc-description
		
			| Create an instance of this class without touching the constructor\.
			
		
		
		:Parameters:
			* **$properties** (array)  

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.0.0 
	
	

.. rst-class:: public

	.. php:method:: public __call( $name, $value)
	
		
		:Parameters:
			* **$name** (string)  
			* **$value** (mixed)  

		
		:Returns: object | null 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public jsonSerialize()
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for \`json\_encode\`\.
			
		
		
		:Returns: array 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter\.
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public static

	.. php:method:: public static jsonDeserialize( $json)
	
		.. rst-class:: phpdoc-description
		
			| Deserialize JSON\.
			
		
		
		:Parameters:
			* **$json** (:any:`stdClass <stdClass>`)  JSON object `{"EntityName": object}`

		
		:Returns: static 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\NotSupportedException <Firstred\\PostNL\\Exception\\NotSupportedException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public static

	.. php:method:: public static xmlDeserialize( $xml)
	
		.. rst-class:: phpdoc-description
		
			| Deserialize XML\.
			
		
		
		:Parameters:
			* **$xml** (array)  Associative array representation of XML response, using Clark notation for namespaces

		
		:Returns: :any:`\\Firstred\\PostNL\\Entity\\AbstractEntity <Firstred\\PostNL\\Entity\\AbstractEntity>` 
	
	

.. rst-class:: public static

	.. php:method:: public static shouldBeAnArray( $fqcn, $propertyName)
	
		.. rst-class:: phpdoc-description
		
			| Whether the given property should bbe an array
			
		
		
		:Parameters:
			* **$fqcn** (string)  
			* **$propertyName** (string)  

		
		:Returns: false | string If found, singular name of property
		:Since: 1.2.0 
	
	

.. rst-class:: public static

	.. php:method:: public static getFullyQualifiedEntityClassName( $shortName)
	
		.. rst-class:: phpdoc-description
		
			| Get the fully qualified class name for the given entity name\.
			
		
		
		:Parameters:
			* **$shortName** (string)  

		
		:Returns: string The FQCN
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Since: 1.2.0 
	
	

