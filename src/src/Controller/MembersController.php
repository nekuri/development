<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;

/**
 * Members Controller
 *
 * @property \App\Model\Table\MembersTable $Members
 *
 * @method \App\Model\Entity\Member[] paginate($object = null, array $settings = [])
 */
class MembersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $members = $this->paginate($this->Members);

        $this->set(compact('members'));
        $this->set('_serialize', ['members']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $member = $this->Members->newEntity();
        if ($this->request->is('post')) {
            try {
                $member = $this->Members->patchEntity($member, $this->request->getData(), ['validate' => false]);
                if (!empty($member->errors())) {
                    throw new \Exception('入力内容にエラーがあります。');
                }

                $this->Members->saveAndSendEmail($this->request->getData());
                $this->Flash->success(__('本登録用のメールを送りました。'));

                return $this->redirect(['controller' => 'animes', 'action' => 'index']);
            } catch (\Exception $e) {
                $this->Flash->error(__($e->getMessage()));
            }
        }
        $this->set(compact('member'));
        $this->set('_serialize', ['member']);
    }

    /**
     * 本登録画面
     *
     * @param string $temporary_id 仮登録ID
     *
     * @return void
     */
    public function formal($temporary_id = null)
    {
        if (isset($temporary_id)) {
            $this->Session->delete('to_save');

            $this->Session->write('temporary_id', $temporary_id);
            $this->redirect(['action' => 'formal']);

            return;
        }

        $result = $this->Members->findTemporaryEmail($this->Session->read('temporary_id'));
        if (!$this->Session->check('temporary_id') || !$result) {
            $this->redirect(['action' => 'add']);
            $this->Flash->error('仮登録情報が取得できませんでした。');

            return;
        }

        $to_save = $this->Session->consume('to_save');
        $member = $this->Members->newEntity($to_save, ['validate' => false]);
        unset($member->password);

        if ($this->request->is('post')) {
            try {
                $to_save = $this->request->getData();
                $member = $this->Members->patchEntity($member, $to_save);

                if (!empty($member->errors())) {
                    throw new \Exception('入力内容が正しくありません。');
                }

                $this->Session->write('to_save', $to_save);
                $this->redirect(['action' => 'confirm']);

                return;
            } catch (\Exception $e) {
                $this->Flash->error($e->getMessage());
            }
        }
        $this->set(compact('member'));
    }

    /**
     * 確認画面
     *
     * @return void
     */
    public function confirm()
    {
        if (!$this->Session->check('to_save')) {
            $this->redirect(['action' => 'add']);

            return;
        }

        $to_save = $this->Session->read('to_save');
        $email = $this->Members->findTemporaryEmail($this->Session->read('temporary_id'));
        $member = $this->Members->newEntity($to_save, ['validate' => false]);
        $member->email = $email;
        //メール送信用に、平文のパスワードをセット
        $member->plaintext_password = Hash::get($to_save, 'password');

        if ($this->request->is('post')) {
            try {
                $this->Members->saveAndSendEmail($member);
                $this->Session->delete('to_save');
                $this->Session->delete('temporary_id');
                $this->Flash->success('本登録が完了しました。');
            } catch (\Exception $e) {
                $this->Flash->error($e->getMessage());
            }
            $this->redirect(['controller' => 'animes', 'action' => 'index']);

            return;
        }

        $this->set(compact('member'));
    }
}
