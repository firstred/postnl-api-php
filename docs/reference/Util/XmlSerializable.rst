.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


XmlSerializable
===============


.. php:namespace:: Firstred\PostNL\Util

.. php:interface:: XmlSerializable


	.. rst-class:: phpdoc-description
	
		| Objects implementing XmlSerializable can control how they are represented in
		| Xml\.
		
	


Summary
-------

Methods
~~~~~~~

* :php:meth:`public xmlSerialize\($writer\)<Firstred\\PostNL\\Util\\XmlSerializable::xmlSerialize\(\)>`


Methods
-------

.. rst-class:: public

	.. php:method:: public xmlSerialize( $writer)
	
		.. rst-class:: phpdoc-description
		
			| The xmlSerialize method is called during xml writing\.
			
			| Use the $writer argument to write its own xml serialization\.
			| 
			| An important note: do \_not\_ create a parent element\. Any element
			| implementing XmlSerializable should only ever write what\'s considered
			| its \'inner xml\'\.
			| 
			| The parent of the current element is responsible for writing a
			| containing element\.
			| 
			| This allows serializers to be re\-used for different element names\.
			| 
			| If you are opening new elements, you must also close them again\.
			
		
		
		:Parameters:
			* **$writer** (:any:`Sabre\\Xml\\Writer <Sabre\\Xml\\Writer>`)  

		
		:Returns: void 
	
	

