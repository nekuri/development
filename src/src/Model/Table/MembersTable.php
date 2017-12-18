<?php
namespace App\Model\Table;

use Cake\I18n\Time;
use Cake\Mailer\Email;
// MailerAwareTrait追加
use Cake\Mailer\MailerAwareTrait;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Validation\Validator;

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
            ->requirePresence('name', 'create')
            ->notEmpty('name', '項目が入力されていません。');

        $validator
            ->requirePresence('password', 'create')
            ->notEmpty('password', '項目が入力されていません。');

        $validator
            ->requirePresence('secret_kind', 'create')
            ->notEmpty('secret_kind', '項目が入力されていません。');

        $validator
            ->requirePresence('secret_question', 'create')
            ->notEmpty('secret_question', '項目が入力されていません。');

        return $validator;
    }

    /**
     * 仮登録バリデーション ルール
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationTemporary($validator)
    {
        $validator->provider('customProvider', 'App\Model\Validation\CustomValidation');

        $validator
            ->requirePresence('email', 'create')
            ->notEmpty('email', '項目が入力されていません。')
            ->add('email', [
                'email' => [
                    'rule' => 'email',
                    'message' => 'メールアドレスの形式で入力してください。',
                    'last' => true,
                ],
                'unique' => [
                    'rule' => ['isEmailUnique'],
                    'provider' => 'customProvider',
                    'message' => 'すでに使用されているメールアドレスです。',
                    'last' => true,
                ]
            ]);

        $validator
            ->notEmpty('email_confirm', '項目が入力されていません。')
            ->add('email_confirm', [
                'compare' => [
                    'rule' => ['compareWith', 'email'],
                    'message' => 'メールアドレスが一致しません。',
                    'last' => true,
                ],
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
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }

    /**
     * 保存とメール送信を行う
     *
     * @param object $data ユーザー情報
     * @return bool
     */
    public function saveAndSendEmail($data)
    {
        $temporary = TableRegistry::get('Temporary');

        if (isset($data->password)) { //本登録の場合
            $this->connection()->begin();
            if (!$this->save($data)) {
                $this->connection()->rollback();
                throw new \Exception('保存に失敗しました。');
            }
            $data->url = LOGIN_URL;
            $this->getMailer('Users')->send('register', [$data]);
            $temporary->deleteAll(['email' => $data->email]);
            $this->connection()->commit();
        } else { //仮登録の場合
            $url = FORMAL_REGISTER_URL;
            $timestamp = new Time(REMIND_JUDGMENT_TIME);
            $Utils = TableRegistry::get('Utils');

            $temporary_id = md5($Utils->makeRandStr());
            $url .= $temporary_id;

            $entity = $temporary->newEntity($data, ['validate' => false]);
            $entity->expire = $timestamp;
            $entity->temporary_id = $temporary_id;
            $entity->created = date('Y-m-d H:i:s');

            $temporary->connection()->begin();
            if (!$temporary->save($entity)) {
                $temporary->connection()->rollback();
                throw new \Exception('保存に失敗しました。');
            }

            $entity->url = $url;
            $this->getMailer('Users')->send('temporary', [$entity]);
            $temporary->connection()->commit();
        }

        return true;
    }

    /**
     * 仮登録テーブルからメールアドレスを取得する
     *
     * @param string $temporary_id 仮登録ID
     * @return string
     */
    public function findTemporaryEmail($temporary_id)
    {
        $temporary = TableRegistry::get('Temporary');
        $result = $temporary->find()->where([
            'temporary_id' => $temporary_id,
            'expire >' => Time::now()->i18nFormat('yyyy-MM-dd HH:mm:ss')
        ])
        ->first();

        return $result->email;
    }
}
