<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AnimesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AnimesTable Test Case
 */
class AnimesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AnimesTable
     */
    public $Animes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.animes',
        'app.reviews'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Animes') ? [] : ['className' => AnimesTable::class];
        $this->Animes = TableRegistry::get('Animes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Animes);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test searchManager method
     *
     * @return void
     */
    public function testSearchManager()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     *
     * @test
     * @return void
     */
    public function アニメデータのエンティティを保存する()
    {
        $animes_data = [
            0 => (Object) [
                'id' => 1,
                'title' => 'hoge',
                'title_short1' => 'ho',
                'public_url' => 'http://hogehoge.com',
            ],
            1 => (Object) [
                'id' => 2,
                'title' => 'hoge2',
                'title_short1' => 'ho2',
                'public_url' => 'http://hogehoge2.com',
            ]
        ];

        $entities = $this->Animes->createAnimeEntities($animes_data, 2014, 1);
        $this->assertTrue($this->Animes->saveAnimesData($entities));

        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     *
     * @test
     * @return void
     */
    public function アニメ用のエンティティを作成()
    {
        $expected_entities = [
               0 => [
                    'id' => 1,
                    'title' => 'hoge',
                    'title_short' => 'ho',
                    'url' => 'http://hogehoge.com',
                    'api_id' => 1,
                    'year' => 2014,
                    'cool' => 1,
                    '[new]' => true,
                    '[accessible]' => [
                        'id' => true,
                        'title' => true,
                        'title_short' => true,
                        'url' => true,
                        'year' => true,
                        'cool' => true,
                        'photo' => true,
                        'photo_dir' => true,
                        'created' => true,
                        'modified' => true,
                        'api_id' => true
                    ],
                    '[dirty]' => [
                        'id' => true,
                        'title' => true,
                        'title_short' => true,
                        'url' => true,
                        'api_id' => true,
                        'year' => true,
                        'cool' => true
                    ],
                    '[original]' => [],
                    '[virtual]' => [],
                    '[errors]' => [],
                    '[invalid]' => [],
                    '[repository]' => 'Animes'
                ],
                1 =>  [
                    'id' => 2,
                    'title' => 'hoge2',
                    'title_short' => 'ho2',
                    'url' => 'http://hogehoge2.com',
                    'api_id' => 2,
                    'year' => 2014,
                    'cool' => 1,
                    '[new]' => true,
                    '[accessible]' => [
                        'id' => true,
                        'title' => true,
                        'title_short' => true,
                        'url' => true,
                        'year' => true,
                        'cool' => true,
                        'photo' => true,
                        'photo_dir' => true,
                        'created' => true,
                        'modified' => true,
                        'api_id' => true
                    ],
                    '[dirty]' => [
                        'id' => true,
                        'title' => true,
                        'title_short' => true,
                        'url' => true,
                        'api_id' => true,
                        'year' => true,
                        'cool' => true
                    ],
                    '[original]' => [],
                    '[virtual]' => [],
                    '[errors]' => [],
                    '[invalid]' => [],
                    '[repository]' => 'Animes'
                ],
            ];

        $expected_entities = $this->Animes->newEntities($expected_entities);

        $animes_data = [
            0 => (Object) [
                'id' => 1,
                'title' => 'hoge',
                'title_short1' => 'ho',
                'public_url' => 'http://hogehoge.com',
            ],
            1 => (Object) [
                'id' => 2,
                'title' => 'hoge2',
                'title_short1' => 'ho2',
                'public_url' => 'http://hogehoge2.com',
            ]
        ];

        $entities = $this->Animes->createAnimeEntities($animes_data, 2014, 1);
        $this->assertEquals($expected_entities, $entities);

        $this->markTestIncomplete('Not implemented yet.');
    }
}
