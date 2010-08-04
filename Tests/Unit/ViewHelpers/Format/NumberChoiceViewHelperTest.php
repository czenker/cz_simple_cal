<?php 
require_once(t3lib_extmgm::extPath('fluid') . 'Tests/Unit/ViewHelpers/ViewHelperBaseTestcase.php');
 
/**
 * testing the features of the Condition_CompareViewHelper
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Format_NumberChoiceViewHelperTest extends Tx_Fluid_ViewHelpers_ViewHelperBaseTestcase {
	
	protected $viewHelper = null;
	
	public function setUp() {
		parent::setUp();
		$this->viewHelper = new Tx_CzSimpleCal_ViewHelpers_Format_NumberChoiceViewHelper();
	}
	
	public function testArgumentsParameter() {
		self::assertEquals('baz', $this->viewHelper->render(1, '[0]foo|[1]###bar###', array('bar' => 'baz')), 'markers are substituted.');
	}
	
	/**
     * @dataProvider provider
     * @return unknown_type
     */
	public function testIfCorrectIntervalIsFound($text, $number, $assert) {
		self::assertEquals($assert, $this->viewHelper->render($number, $text));
	}
	
	public function provider() {
    	return array(
    		array('[0]foo', 0, 'foo'),
    		array('[0]foo|[1]bar', 1, 'bar'),
    		array('[0,+Inf]foo', 0, 'foo'),                      // +Inf
    		array('(0,+Inf]foo|[0]bar', 0, 'bar'),
    		array('[0]bar|(0,+Inf]foo', 9999, 'foo'),            // large numbers
    		array('[-Inf,0]foo|(0,+Inf]bar', -3, 'foo'),         // -Inf
    		array('[42]foo|[0,+Inf]bar', 42, 'foo'),             // overlapping intervals
       	);
    }
    
	/**
     * Gets the data set description of a TestCase.
     *
     * @param  boolean $includeData
     * @return string
     * @since  Method available since Release 3.3.0
     */
    protected function getDataSetAsString($includeData = TRUE) {
    	$buffer = '';

        if (!empty($this->data)) {
            if (is_int($this->dataName)) {
                $buffer .= sprintf(' with data set "%s" and number %d',$this->data[0], $this->data[1]);
            } else {
                $buffer .= sprintf(' with data set "%s"', $this->dataName);
            }

            if ($includeData) {
                $buffer .= sprintf(' (%s)', $this->dataToString($this->data));
            }
        }

        return $buffer;
    }
	
}