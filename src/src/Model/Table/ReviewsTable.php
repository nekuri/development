<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Reviews Model
 *
 * @property \App\Model\Table\AnimesTable|\Cake\ORM\Association\BelongsTo $Animes
 *
 * @method \App\Model\Entity\Review get($primaryKey, $options = [])
 * @method \App\Model\Entity\Review newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Review[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Review|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Review patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Review[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Review findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class ReviewsTable extends Table
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

        $this->setTable('reviews');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Animes', [
            'foreignKey' => 'anime_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {

        $validator
            ->requirePresence('body', 'create')
            ->notEmpty('title', 'タイトルを入力してください。')
            ->add('title', [
                'maxLength' => [
                    'rule' => ['maxLength', 20],
                    'last' => true,
                    'message' => 'タイトルは20文字以内で入力してください。',
                ]
            ]);

        $validator
            ->requirePresence('body', 'create')
            ->notEmpty('body', '内容を入力してください。')
            ->add('body', [
                'maxLength' => [
                    'rule' => ['maxLength', 200],
                    'last' => true,
                    'message' => '内容は200文字以内で入力してください。',
                ]
            ]);

        $validator
            ->integer('evalution', '不正な値です。')
            ->requirePresence('evalution', 'create')
            ->notEmpty('evalution', '評価をつけてください。')
            ->add('evalution', [
                'inList' => [
                    'rule' => ['inList', [1,2,3,4,5]],
                    'message' => '評価は1〜5でつけてください。',
                ]
            ]);

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        return $rules;
    }
}
