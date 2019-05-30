<?php
/**
 * BudgetedSubscriberFixture
 *
 */
class BudgetedSubscriberFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 11, 'key' => 'primary'),
		'month_id' => array('type' => 'integer', 'null' => true),
		'year_id' => array('type' => 'integer', 'null' => true),
		'presupuesto' => array('type' => 'text', 'null' => true),
		'created' => array('type' => 'date', 'null' => true),
		'modified' => array('type' => 'date', 'null' => true),
		'company_id' => array('type' => 'integer', 'null' => true),
		'channel_id' => array('type' => 'integer', 'null' => true),
		'indexes' => array(
			'PRIMARY' => array('unique' => true, 'column' => 'id')
		),
		'tableParameters' => array()
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'month_id' => 1,
			'year_id' => 1,
			'presupuesto' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'created' => '2014-07-21',
			'modified' => '2014-07-21',
			'company_id' => 1,
			'channel_id' => 1
		),
	);

}
