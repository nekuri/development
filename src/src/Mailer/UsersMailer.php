<?php
namespace App\Mailer;

use Cake\Mailer\Mailer;

class UsersMailer extends Mailer
{

    public function temporary($entity)
    {
        $this
            ->profile('default')
            ->to($entity->email)
            ->subject('本登録のお知らせ')
            ->template('temporary')
            ->viewVars(compact('entity'));
    }
}