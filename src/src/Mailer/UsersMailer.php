<?php
namespace App\Mailer;

use Cake\Mailer\Mailer;

class UsersMailer extends Mailer
{

    /**
     * 仮登録用メール
     *
     * @param object $entity 仮登録情報
     * @return void
     */
    public function temporary($entity)
    {
        $this
            ->profile('default')
            ->to($entity->email)
            ->subject('本登録のお知らせ')
            ->template('temporary')
            ->viewVars(compact('entity'));
    }

    /**
     * 本登録用メール
     *
     * @param object $entity 本登録情報
     * @return void
     */
    public function register($entity)
    {
        $this
            ->profile('default')
            ->to($entity->email)
            ->subject('本登録が完了しました')
            ->template('register')
            ->viewVars(compact('entity'));
    }
}
