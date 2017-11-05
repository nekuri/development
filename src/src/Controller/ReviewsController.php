<?php
namespace App\Controller;

use App\Controller\AppController;
use \Exception;
use Cake\Datasource\ConnectionManager;
use Cake\Core\Configure;

/**
 * Reviews Controller
 *
 * @property \App\Model\Table\ReviewsTable $Reviews
 *
 * @method \App\Model\Entity\Review[] paginate($object = null, array $settings = [])
 */
class ReviewsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Animes']
        ];
        $reviews = $this->paginate($this->Reviews);

        $this->set(compact('reviews'));
        $this->set('_serialize', ['reviews']);
    }

    /**
     * View method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $review = $this->Reviews->get($id, [
            'contain' => ['Animes']
        ]);

        $this->set('review', $review);
        $this->set('_serialize', ['review']);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add($id = null)
    {
        $stars = Configure::read('Common.reviews');
        $review = $this->Reviews->newEntity();
        if ($this->request->is('post')) {
            $review = $this->Reviews->patchEntity($review, $this->request->getData());
            $review['anime_id'] = $id;
            $conn = ConnectionManager::get('default');

            try {
                if (!empty($review->errors())) {
                    throw new \Exception('入力内容に誤りがあります。');
                }
                $conn->begin();
                if ($this->Reviews->save($review)) {
                    $conn->commit();
                    $this->redirect(['controller' => 'animes', 'action' => 'view', $id]);
                    $this->Flash->success(__('レビューを投稿しました。'));
                }
            } catch(\Exception $e) {
                $this->Flash->error(__($e->getMessage()));
                //TODO エラー処理
                $conn->rollback();
            }
        }
        $this->set(compact('stars', 'review', 'id'));
        $this->set('_serialize', ['review']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $review = $this->Reviews->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $review = $this->Reviews->patchEntity($review, $this->request->getData());
            if ($this->Reviews->save($review)) {
                $this->Flash->success(__('The review has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The review could not be saved. Please, try again.'));
        }
        $animes = $this->Reviews->Animes->find('list', ['limit' => 200]);
        $this->set(compact('review', 'animes'));
        $this->set('_serialize', ['review']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Review id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $review = $this->Reviews->get($id);
        if ($this->Reviews->delete($review)) {
            $this->Flash->success(__('The review has been deleted.'));
        } else {
            $this->Flash->error(__('The review could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
