<?php 

namespace ashrafmansy\JobProfileExporter;
use ashrafmansy\JobProfileExporter\JobPostingValidator;
use Exception;

require_once('JobProfile.php');
/**
*  A sample class
*
*  Use this section to define what this class is doing, the PHPDocumentator will use this
*  to automatically generate an API documentation using this information.
*
*  @author yourname
*/
class JobProfileFactory{

    public static function create($JobProfileElement)
    {
    	$errors = JobPostingValidator::getErrors($JobProfileElement);	
    	if(empty($errors)){
    		return new JobProfile($JobProfileElement);
    	}else{
    		return json_encode($errors);
    	}
        
    }
}