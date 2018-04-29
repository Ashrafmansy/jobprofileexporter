<?php 
namespace ashrafmansy\JobProfileExporter;

/**
*  A sample class
*
*  Use this section to define what this class is doing, the PHPDocumentator will use this
*  to automatically generate an API documentation using this information.
*
*  @author ashrafmansy
*/
class JobPostingValidator{

   /**  @var string $m_SampleProperty define here what this variable is for, do this for every instance variable */
    const JobPostingValidator = array(
					'title' => 'text',
					'description' => 'html',
					'identifier' => array('@type' => 'text', 'name' => 'text', 'value' => 'numeric' ),
					'datePosted' => 'date',
					"validThrough" => "date",
					"employmentType" => "employment_type_choice",
					"hiringOrganization" => array('@type' => 'text', 'name' => 'text', 'sameAs' => 'url' ,"logo" => "url"),
					'jobLocation' => array('@type' => 'text'),
					'jobLocation__address' => array('@type' => 'text', 'streetAddress' => 'text', 'addressLocality' => 'text', 'addressRegion' => 'text', 'postalCode' => 'numeric', 'addressCountry' => 'text'), 
					'baseSalary' => array('@type' => 'MonetaryAmount','currency' => 'text'),
					'baseSalary__value' => array('@type' => 'text', 'value' => 'number', 'unitText' => 'salary_type_choice')
					);

    const SalaryTypeChoice = array('HOUR','DAY','WEEK','MONTH','YEAR');
    const EmploymentTypeChoice = array('FULL_TIME','PART_TIME','CONTRACTOR','TEMPORARY','INTERN','VOLUNTEER','PER_DIEM','OTHER');
    const notRequired = array('baseSalary','employmentType','identifier');

    function getErrors($jobPosting){
    	return self::checkValueTypes($jobPosting,'');
    }

	function checkValueTypes($jobPosting, $composite_key_name = '') {
    	foreach($jobPosting as $key => $value){
        	//If $value is an array.
        	if(is_array($value) && is_string($key)){
            	//We need to loop through it.
            	self::checkValueTypes($value,$composite_key_name . $key . '__');
        	} else{
            //It is not an array, so print it out.
        		$validatorKey = preg_replace("/__$/", '', $composite_key_name );
        		$validatorValue = $validatorKey ? self::JobPostingValidator[$validatorKey][$key] : self::JobPostingValidator[$key];
            	 if(!self::isValidType($value,$validatorValue)){
            	 	$errorKey = $validatorKey ? $validatorKey.'__'.$key : $key;
            	 	return self::prepareErrorMessage($validatorValue, $errorKey);
            	 };
        	}
    	}
  	}  

  	function isValidType($value, $type){
  		switch ($type) {
		    case 'text':
		        return is_string($value);
		    case 'numeric':
		        return is_numeric($value);
		     case 'number':
		        return (is_int($value) || is_float($value)) ? true: false;
		    case 'url':
		        return filter_var($value, FILTER_VALIDATE_URL);
		    case 'salary_type_choice':
		    	if(is_array($value)){
		    		return empty(array_intersect($value, self::SalaryTypeChoice)) ? false : true;
		    	}else{
		    		return in_array($value, self::SalaryTypeChoice);	
		    	}
		    case 'employment_type_choice':
		        return in_array($value, self::EmploymentTypeChoice);
		    default:
		        return true;
		}
  	}

  	function prepareErrorMessage($type, $validatorKey){
  		switch ($type) {
		    case 'salary_type_choice':
				return array($validatorKey => 'The value should be one of the following ('. implode(',' ,self::SalaryTypeChoice).')');
		    case 'employment_type_choice':
		        return array($validatorKey => 'The value should be one of the following ('. implode(',' ,self::EmploymentTypeChoice).')');
		    default:
		        return array($validatorKey => 'The value should be a $type');
		}
  	}  
}