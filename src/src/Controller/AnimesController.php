<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Utility\Hash;
use Cake\Core\Configure;
use \Exception;
use Cake\Network\Exception\NotFoundException;

/**
 * Animes Controller
 *
 * @property \App\Model\Table\AnimesTable $Animes
 *
 * @method \App\Model\Entity\Anime[] paginate($object = null, array $settings = [])
 */
class AnimesController extends AppController
{

   /**
     * Initialization hook method.
     * データベースにアニメデータが格納されていない場合(初回)、apiにアクセスしてデータを保存する
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        if (count($this->Animes->find('all')->all()) == 0) {
            $years = Configure::read('Common.anime_years');
            $cools = Configure::read('Common.anime_cools');

            foreach ($years as $year) {
                foreach ($cools as $cool) {
                    $api_data = $this->callAnimeApi($year, $cool);
                    $animes_data = json_decode($api_data);

                    if (is_null($animes_data)) {
                        $this->Flash->error('パラメータが正しくありません。');
                        return;
                    }

                    $entities = $this->Animes->createAnimeEntities($animes_data, $year, $cool);
                    $this->Animes->saveAnimesData($entities);
                }
            }
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $year = date('Y');
        $cool = Configure::read('Common.default_cool');

        if ($this->request->query) {
            $params = $this->request->getQueryParams();
            $title = Hash::get($params, 'title');

            if (array_key_exists('year', $params) && array_key_exists('cool', $params) ) {
                $year = (int)Hash::get($params, 'year');
                $cool = (int)Hash::get($params, 'cool');
            }

            if (isset($title)) {
                $query = $this->Animes->find('search', ['search' => $this->request->query])->contain(['Reviews']);
                $animes = $this->paginate($query);

                $this->set('anime_season', Configure::read('Common.anime_season'));
                $this->set(compact('animes', 'year', 'cool', 'title'));
                return;
            }
        }

        $result = $this->Animes->find('all')->where(['Animes.year' => $year, 'Animes.cool' => $cool])->contain(['Reviews']);
        try {
            $animes = $this->paginate($result);
        } catch (NotFoundException $e) {
            //範囲外のページが指定された場合、1ページ目に遷移させる
            return $this->redirect([
                'action' => 'index',
                '?' => [
                    'page' => 1
                ]
            ]);
        }
        $this->set('anime_season', Configure::read('Common.anime_season'));
        $this->set(compact('animes', 'year', 'cool'));
    }

    /**
     * View method
     *
     * @param string|null $id Anime id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $animes = $this->Animes->find('all')->where(['Animes.api_id' => $id])->contain(['Reviews']);
        $anime = $animes->first();
        if (is_null($anime)) {
            $this->redirect(['action' => 'index']);
            return;
        }

        if (!empty($anime->reviews)) {
            $evalution = [];
            foreach ($anime->reviews as $review) {
                $evalution[] = $review->evalution;
            }
            $sum = array_sum($evalution);
            $cnt = count($evalution);
            $avg_evalution = round($sum / $cnt);
            $this->set('avg_evalution', $avg_evalution);
        }
        $this->set('anime', $anime);
        $this->set('_serialize', ['anime']);
        $this->set('anime_season', Configure::read('Common.anime_season'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $anime = $this->Animes->newEntity();
        if ($this->request->is('post')) {
            $anime = $this->Animes->patchEntity($anime, $this->request->getData());
            if ($this->Animes->save($anime)) {
                $this->Flash->success(__('The anime has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The anime could not be saved. Please, try again.'));
        }
      //  $apis = $this->Animes->Apis->find('list', ['limit' => 200]);
        //$this->set(compact('anime', 'apis'));
        $this->set('_serialize', ['anime']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Anime id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $anime = $this->Animes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $anime = $this->Animes->patchEntity($anime, $this->request->getData());
            if ($this->Animes->save($anime)) {
                $this->Flash->success(__('The anime has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The anime could not be saved. Please, try again.'));
        }
        //$apis = $this->Animes->Apis->find('list', ['limit' => 200]);
        $this->set(compact('anime'));
        $this->set('_serialize', ['anime']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Anime id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $anime = $this->Animes->get($id);
        if ($this->Animes->delete($anime)) {
            $this->Flash->success(__('The anime has been deleted.'));
        } else {
            $this->Flash->error(__('The anime could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
