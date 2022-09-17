<?php
/*<<<<<USES*/
namespace app\tests\functional;

use tests\fixtures\unit\CountryFixture;
use app\models\Country;
use app\models\comp\CountrySearch;
/*>>>>>USES*/
/*<<<<<CLASS*/
/**
 * CrudCountryCest
 *
 * @see https://phpunit.de/manual/6.5/en/appendixes.assertions.html
 * @see https://codeception.com/docs/modules/Yii2
 */
class CrudCountryCest
{

    public function _fixtures()
    {
        $ret = [];
		$ret['countries'] = [
			'class' => CountryFixture::class
		];
/*>>>>>CLASS*/
/*<<<<<FIXTURE_RETURN*/
		return $ret;
	} // _fixtures

	public function testsCanSeeCrudPagesCountry(/* FunctionalTester */ $I )
	{

		$tests_fields = [
			'code' => [
				'iso2' => [],
			],
		];
/*>>>>>FIXTURE_RETURN*/
/*<<<<<CRUD_TESTS*/
		$country0 = $I->grabFixture('countries', 'countries0');
		$I->assertNotNull($country0);
		$id = $country0->getPrimaryKey();
		$country9 = $I->grabFixture('countries', 'countries9');
		$I->assertNotNull($country9);
		$id9 = $country9->getPrimaryKey();
/*>>>>>CRUD_TESTS*/
/*<<<<<CRUD_INDEX*/
		$I->amOnPage('/country/index');
		$I->see($country0->getModelInfo('title_plural'));
/*>>>>>CRUD_INDEX*/
//		$I->see($country0->iso2);
		// Fill the filters array here: like this:
		// $country_filter = [
		// 	'iso2' => $country0->iso2
		// ];
/*<<<<<CRUD_INDEX_FILTER*/
 		$search_model = new CountrySearch();
		if( isset($country_filter) ) {
			$I->submitForm('#search-default-form', [
				$search_model->formName() => $country_filter
			]);
		}
/*>>>>>CRUD_INDEX_FILTER*/
// 		$I->see($country0->iso2);

/*<<<<<CRUD_VIEW*/
		$I->amOnPage("/country/view?id=$id");
		$I->see($country0->getModelInfo('title'));
/*>>>>>CRUD_VIEW*/
		// Fill the updates array here, like this:
		// $country_updates = [
		// 	'iso2' => $country0->iso2
		// ];
/*<<<<<CRUD_UPDATE*/
		$I->amOnPage("/country/update?id=$id9");
		$I->see($country9->getModelInfo('title'));
// 		$I->see($country9->iso2);
// 		$I->seeRecord(Country::class,
// 			[ 'iso2' => $country9->iso2 ] );
		if( isset($country_updates) ) {
			$I->submitForm('#default-country-form', [
				$country9->formName() => $country_updates
			]);
			$I->seeRecord(Country::class, $country_updates );
		}
/*>>>>>CRUD_UPDATE*/
/*<<<<<CRUD_TEST_END*/
	}
/*>>>>>CRUD_TEST_END*/
/*<<<<<END*/
} // class CrudCountryCest
/*>>>>>END*/

