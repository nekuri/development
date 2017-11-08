<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use Cake\Mailer\Email;
use Cake\Utility\Hash;
// MailerAwareTrait追加
use Cake\Mailer\MailerAwareTrait;

/**
 * Members Model
 *
 * @method \App\Model\Entity\Member get($primaryKey, $options = [])
 * @method \App\Model\Entity\Member newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Member[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Member|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Member patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Member[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Member findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MembersTable extends Table
{
    // MailerAwareTrait追加(getMailer()が実装されてる)
    use MailerAwareTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('members');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->scalar('password')
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->integer('secret_kind')
            ->requirePresence('secret_kind', 'create')
            ->notEmpty('secret_kind');

        $validator
            ->scalar('secret_question')
            ->requirePresence('secret_question', 'create')
            ->notEmpty('secret_question');

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
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }

    public function saveAndSendEmail($data)
    {
        $url = 'http://192.168.10.10/members/formal/';
        $Utils = TableRegistry::get('Utils');
        $temporary_id = md5($Utils->makeRandStr());
        $url .= $temporary_id;

        $temporary = TableRegistry::get('Temporary');
        $entity = $temporary->newEntity($data, ['validate' => false]);
        $entity->temporary_id = $temporary_id;
        $entity->created = date('Y-m-d H:i:s');

        if (!$temporary->save($entity)) {
            throw new \Exception('保存に失敗しました。');
        }

        $entity->url = $url;
        $this->getMailer('Users')->send('temporary', [$entity]);

        return true;

    }
}
