.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


SerializableProperty
====================


.. php:namespace:: Firstred\PostNL\Attribute

.. php:class:: SerializableProperty




Summary
-------

Methods
~~~~~~~

* :php:meth:`public \_\_construct\($type, $isArray, $aliases, $supportedServices\)<Firstred\\PostNL\\Attribute\\SerializableProperty::\_\_construct\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public __construct( $type, $isArray=false, $aliases=\[\], $supportedServices=\[\])
	
		.. rst-class:: phpdoc-description
		
			| This indicates that the given property is serializable\. All serialization details should
			| be passed to the attribute, making it completely serializable without relying on reflection
			| of the property itself\.
			
		
		
		:Parameters:
			* **$type** (:any:`class\-string <class\-string>` | :any:`"bool" <"bool">` | :any:`"int" <"int">` | :any:`"float" <"float">` | :any:`"string" <"string">`)  Property type
			* **$isArray** (bool)  Should the property be an array
			* **$aliases** (string[])  Property shortname aliases such as `Address`
			* **$supportedServices** (:any:`class\-string\[\] <class\-string>`)  Supported services, empty array = all

		
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidArgumentException <Firstred\\PostNL\\Exception\\InvalidArgumentException>` 
		:Throws: :any:`\\Firstred\\PostNL\\Exception\\InvalidConfigurationException <Firstred\\PostNL\\Exception\\InvalidConfigurationException>` 
		:Since: 2.0.0 
	
	

