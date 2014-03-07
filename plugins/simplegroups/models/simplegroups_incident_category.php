<?php defined('SYSPATH') or die('No direct script access.');

/**
* Model for Categories for each Incident
 *
 * PHP version 5
 * LICENSE: This source file is subject to LGPL license 
 * that is available through the world-wide-web at the following URI:
 * http://www.gnu.org/copyleft/lesser.html
 * @author     Ushahidi Team <team@ushahidi.com> 
 * @package    Ushahidi - http://source.ushahididev.com
 * @module     Incident Category Model  
 * @copyright  Ushahidi - http://www.ushahidi.com
 * @license    http://www.gnu.org/copyleft/lesser.html GNU Lesser General Public License (LGPL) 
 */

class Simplegroups_incident_category_Model extends ORM
{
	protected $belongs_to = array('incident', 'simplegroups_category');
	
	// Database table name
	protected $table_name = 'simplegroups_incident_category';
}
