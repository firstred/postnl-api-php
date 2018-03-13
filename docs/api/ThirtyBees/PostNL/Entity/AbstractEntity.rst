.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


AbstractEntity
==============


.. php:namespace:: ThirtyBees\PostNL\Entity

.. rst-class::  abstract

.. php:class:: AbstractEntity


	.. rst-class:: phpdoc-description
	
		| Class Entity
		
	
	:Implements:
		:php:interface:`JsonSerializable` :php:interface:`Sabre\\Xml\\XmlSerializable` 
	

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
		
			| Create an instance of this class without touching the constructor
			
		
		
		:Parameters:
			* **$properties** (array)  

		
		:Returns: static | null | object 
	
	

.. rst-class:: public

	.. php:method:: public __call( $name, $value)
	
		
		:Parameters:
			* **$name** (string)  
			* **$value** (mixed)  

		
		:Returns: object | null 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidArgumentException <ThirtyBees\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public jsonSerialize()
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for \`json\_encode\`
			
		
		
		:Returns: array 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidArgumentException <ThirtyBees\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| Return a serializable array for the XMLWriter
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidArgumentException <ThirtyBees\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public static

	.. php:method:: public static jsonDeserialize( $json)
	
		.. rst-class:: phpdoc-description
		
			| Deserialize JSON
			
		
		
		:Parameters:
			* **$json** (array)  JSON as associative array

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\AbstractEntity <ThirtyBees\\PostNL\\Entity\\AbstractEntity>` 
	
	

.. rst-class:: public static

	.. php:method:: public static xmlDeserialize( $xml)
	
		.. rst-class:: phpdoc-description
		
			| Deserialize XML
			
		
		
		:Parameters:
			* **$xml** (array)  Associative array representation of XML response, using Clark notation for namespaces

		
		:Returns: :any:`\\ThirtyBees\\PostNL\\Entity\\AbstractEntity <ThirtyBees\\PostNL\\Entity\\AbstractEntity>` 
	
	

.. rst-class:: public static

	.. php:method:: public static getFullEntityClassName( $shortName)
	
		.. rst-class:: phpdoc-description
		
			| Get the full class \(incl\. namespace\) for the given short class name
			
		
		
		:Parameters:
			* **$shortName** (string)  

		
		:Returns: bool | string The full name if found, else \`false\`
	
	

.. rst-class:: protected static

	.. php:method:: protected static isAssociativeArray( $array)
	
		.. rst-class:: phpdoc-description
		
			| Determine if the array is associative
			
		
		
		:Parameters:
			* **$array** (array)  

		
		:Returns: bool 
	
	

