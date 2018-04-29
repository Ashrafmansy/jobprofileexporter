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
class JobProfile implements \JsonSerializable{

   /**  @var string $m_SampleProperty define here what this variable is for, do this for every instance variable */
   private $JobProfileElement = array(
    "@context" => "http://schema.org/",
    "@type" => "JobPosting"
  );

  function __construct($JobProfileElement){
    $this->JobProfileElement = array_merge($this->JobProfileElement, $JobProfileElement);
  }

  public function jsonSerialize() {
        return $this->JobProfileElement;
  }
 
  /**
  * Sample method 
  *
  * Always create a corresponding docblock for each method, describing what it is for,
  * this helps the phpdocumentator to properly generator the documentation
  *
  * @param string $param1 A string containing the parameter, do this for each parameter to the function, make sure to make it descriptive
  *
  * @return string
  */
   public function method1($param1){
			return "Hello World";
   }
}