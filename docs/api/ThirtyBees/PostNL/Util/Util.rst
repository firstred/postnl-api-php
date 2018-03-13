.. rst-class:: phpdoctorst

.. role:: php(code)
	:language: php


Util
====


.. php:namespace:: ThirtyBees\PostNL\Util

.. php:class:: Util


	.. rst-class:: phpdoc-description
	
		| Class Util
		
	

Constants
---------

.. php:const:: ERROR_MARGIN = 2



Methods
-------

.. rst-class:: public static

	.. php:method:: public static urlEncode( $arr, $prefix=null)
	
		
		:Parameters:
			* **$arr** (array)  A map of param keys to values.
			* **$prefix** (string | null)  

		
		:Returns: string A querystring, essentially\.
	
	

.. rst-class:: public static

	.. php:method:: public static getPdfSizeAndOrientation( $pdf)
	
		
		:Parameters:
			* **$pdf** (string)  Raw PDF string

		
		:Returns: array | bool | string Returns an array with the dimensions or ISO size and orientation
			The orientation is in FPDF format, so L for Landscape and P for Portrait
			Sizes are in mm
		
	
	

.. rst-class:: public static

	.. php:method:: public static getDeliveryDate( $deliveryDate, $mondayDelivery=false, $sundayDelivery=false)
	
		.. rst-class:: phpdoc-description
		
			| Offline delivery date calculation
			
		
		
		:Parameters:
			* **$deliveryDate** (string)  Delivery date in any format accepted by DateTime
			* **$mondayDelivery** (bool)  Sunday sorting/Monday delivery enabled
			* **$sundayDelivery** (bool)  Sunday delivery enabled

		
		:Returns: string \(format: \`Y\-m\-d H:i:s\`\)
		:Throws: :any:`\\Exception <Exception>` 
	
	

.. rst-class:: public static

	.. php:method:: public static getShippingDate( $deliveryDate, $days=\[0 =\> false, 1 =\> true, 2 =\> true, 3 =\> true, 4 =\> true, 5 =\> true, 6 =\> true\])
	
		.. rst-class:: phpdoc-description
		
			| Offline shipping date calculation
			
		
		
		:Parameters:
			* **$deliveryDate** (string)  
			* **$days** (array)  

		
		:Returns: string 
		:Throws: :any:`\\ThirtyBees\\PostNL\\Exception\\InvalidArgumentException <ThirtyBees\\PostNL\\Exception\\InvalidArgumentException>` 
	
	

.. rst-class:: public static

	.. php:method:: public static getShippingDaysRemaining( $shippingDate, $preferredDeliveryDate)
	
		.. rst-class:: phpdoc-description
		
			| Calculates amount of days remaining
			| i\.e\. preferred delivery date the day tomorrow =\> today = 0
			| i\.e\. preferred delivery date the day after tomorrow =\> today \+ tomorrow = 1
			| i\.e\. preferred delivery date the day after tomorrow, but one holiday =\> today \+ holiday = 0
			
			| 0 means: should ship today
			| < 0 means: should\'ve shipped in the past
			| anything higher means: you\'ve got some more time
			
		
		
		:Parameters:
			* **$shippingDate** (string)  Shipping date (format: `Y-m-d H:i:s`)
			* **$preferredDeliveryDate** (string)  Customer preference

		
		:Returns: int 
		:Throws: :any:`\\Exception <Exception>` 
	
	

.. rst-class:: protected static

	.. php:method:: protected static getHolidaysForYear( $year)
	
		.. rst-class:: phpdoc-description
		
			| Get an array with all Dutch holidays for the given year
			
		
		
		:Parameters:
			* **$year** (string)  

		
		:Returns: array Credits to @tvlooy \(https://gist\.github\.com/tvlooy/1894247\)
		:Throws: :any:`\\Exception <Exception>` 
	
	

