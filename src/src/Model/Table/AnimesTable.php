<?php
namespace App\Model\Table;

use Cake\Datasource\Connection;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Search\Manager;
use \Exception;

/**
 * Animes Model
 *
 * @property \App\Model\Table\ReviewsTable|\Cake\ORM\Association\HasMany $Reviews
 *
 * @method \App\Model\Entitie$entities\Anime get($primaryKey, $options = [])
 * @method \App\Model\Entity\Anime newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Anime[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Anime|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Anime patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Anime[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Anime findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AnimesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('animes');
        $this->setDisplayField('title');
        $this->setPrimaryKey('api_id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');

        $this->hasMany('Reviews', [
            'foreignKey' => 'anime_id'
        ]);

        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'photo' => [
                'path' => 'webroot' . DS . 'img' . DS . 'files' . DS . '{primaryKey}',
                    'fields' => [
                        'dir' => 'photo_dir'
                    ]
            ]
        ]);
    }

     public function searchManager()
    {
        $search = $this->behaviors()->Search->searchManager();

        //like検索
        $search->like('title', [
            'before' => true,
            'after' => true
        ]);

        return $search;
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator->provider('custom', 'App\Model\Validation\CustomValidation');

        $validator
            ->integer('id')
            ->requirePresence('id', 'create')
            ->notEmpty('id');

        $validator
            ->scalar('title')
            ->allowEmpty('title');

        $validator
            ->scalar('title_short')
            ->allowEmpty('title_short');

        $validator
            ->scalar('url')
            ->allowEmpty('url');

        $validator
            ->integer('api_id')
            ->requirePresence('api_id', 'create')
            ->notEmpty('api_id');

        $validator
            ->integer('year')
            ->requirePresence('year', 'create')
            ->notEmpty('year');

        $validator
            ->integer('cool')
            ->requirePresence('cool', 'create')
            ->notEmpty('cool');

        $validator
        ->add('photo', 'custom', [
            'rule' => ['checkImageFileExtension'],
            'provider' => 'custom',
            'message' => '許可されていない拡張子です。'
        ]);

        return $validator;
    }

    /**
     * アニメデータを保存
     *
     * @param object $entities
     * @return void
     */
    public function saveAnimesData($entities)
    {
        $conn = ConnectionManager::get('default');
        foreach ($entities as $entity) {
            try {
                $conn->begin();
                if (!$this->save($entity)) {
                    throw new \Exception('保存に失敗しました');
                }
                $conn->commit();
            } catch(\Exception $e) {
                //TODO エラー処理 ログに書き出す？
                $conn->rollback();
                return false;
            }
        }

        return true;
    }

    /**
     * anime用のエンティティーを作成する
     *
     * @param object $animes_data
     * @return object
     */
    public function createAnimeEntities($animes_data, $year, $cool)
    {
        foreach ($animes_data as $key => $anime) {
            $data[$key]['id'] = $key + 1;
            $data[$key]['title'] = $anime->title;
            $data[$key]['title_short'] = $anime->title_short1;
            $data[$key]['url'] = $anime->public_url;
            $data[$key]['api_id'] = $anime->id;
            $data[$key]['year'] = $year;
            $data[$key]['cool'] = $cool;
        }

        return $this->newEntities($data);
    }
}
