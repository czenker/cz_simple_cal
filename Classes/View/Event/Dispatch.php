<?php 

/**
 * This class exists so that the Event Controller won't initialize 
 * an empty view.
 * 
 * If this was done the dispatch action will not be called.
 * 
 * @author Christian Zenker <christian.zenker@599media.de>
 */
class Tx_CzSimpleCal_View_Event_Dispatch extends Tx_Fluid_View_TemplateView {
}