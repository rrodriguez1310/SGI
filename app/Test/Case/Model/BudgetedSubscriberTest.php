<?php
App::uses('BudgetedSubscriber', 'Model');

/**
 * BudgetedSubscriber Test Case
 *
 */
class BudgetedSubscriberTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.budgeted_subscriber',
		'app.month',
		'app.year',
		'app.company',
		'app.company_type',
		'app.channel'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->BudgetedSubscriber = ClassRegistry::init('BudgetedSubscriber');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->BudgetedSubscriber);

		parent::tearDown();
	}

}
