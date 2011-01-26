<?php 

/**
 * This class exists so that the EventIndex Controller won't initialize 
 * an empty view.
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_View_Event extends Tx_Fluid_View_TemplateView {
	
	/**
	 * this view states it could render anything.
	 * 
	 * it has no possibility to request the template to render from the controller.
	 * So it states it is able to render it and the controller takes care to check if 
	 * it really does
	 * 
	 * @see Classes/View/Tx_Fluid_View_TemplateView::canRender()
	 */
	public function canRender(Tx_Extbase_MVC_Controller_ControllerContext $controllerContext) {
		return true;
	}
}